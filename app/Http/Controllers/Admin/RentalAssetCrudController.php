<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RentalAssetRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RentalAssetCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RentalAssetCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\RentalAsset::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/rental-asset');
        CRUD::setEntityNameStrings('rental asset', 'rental assets');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setDefaultPageLength(15);
        CRUD::disablePersistentTable();
        CRUD::removeAllButtonsFromStack('top');
        CRUD::setOperationSetting('lineButtonsAsDropdown', true);

        CRUD::orderBy('displayed_num', 'asc');

        CRUD::addColumns ([

            [
                'label' => 'Status',
                'type' => 'text',
                'name' => 'assetStatusType.status_type',
                'orderable'  => true,
                'orderLogic' => function ($query, $column, $columnDirection) {
                        return $query->leftJoin('asset_status_types', 'rental_assets.status_id', '=', 'asset_status_types.id')
                                     ->orderBy('asset_status_types.status_type', $columnDirection)->select('rental_assets.*');
                    },
                'wrapper' => [
                    'element' => 'span',
                    'class'   => function ($crud, $column, $entry, $related_key) {
                        if ($column['text'] == 'Available') {
                            return 'badge rounded-pill bg-success';
                        } elseif ($column['text'] == 'On Rent') {
                            return 'badge rounded-pill bg-danger';
                        } elseif ($column['text'] == 'Retired') {
                            return 'badge rounded-pill bg-info';
                        } 
                        return 'badge rounded-pill bg-warning';
                    },
                ],
            ],

            [
                'label' => 'Asset #',
                'type' => 'text',
                'name' => 'displayed_num',
            ],

            [
                'label' => 'Old #',
                'type' => 'text',
                'name' => 'old_num',
            ],

            [
                'label' => 'Type',
                'type' => 'select',
                'name' => 'assetClass',
            ],

            [
                'label' => 'Capacity',
                'type' => 'integer',
                'name' => 'capacity',
            ],

            [
                'label' => 'Unit',
                'type' => 'text',
                'name' => 'capacity_unit',
            ],

            [
                'label' => 'Serial #',
                'type' => 'text',
                'name' => 'serial_vin_num',
            ],

            [
                'label' => 'Property Type',
                'type' => 'select',
                'name' => 'propertyType',
            ],

        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RentalAssetRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
