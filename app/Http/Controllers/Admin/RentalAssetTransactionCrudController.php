<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RentalAssetTransactionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RentalAssetTransactionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RentalAssetTransactionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\RentalAssetTransaction::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/rental-asset-transaction');
        CRUD::setEntityNameStrings('rental asset transaction', 'rental asset transactions');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RentalAssetTransactionRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.

        CRUD::addFields([
            /*
            [
                'label' => 'Asset ID',
                'type' => 'text',
                'name' => 'code',
                'default' => request()->input('code', ''),
            ],
            */
            [
                'label'     => "Asset #",
                'type'      => 'select',
                'name'      => 'rental_asset_id',
                'default'   => request()->input('code', ''),
                'entity'    => 'rentalAsset',
                'model'     => "App\Models\RentalAsset",
                'attribute' => 'displayed_num',
            ],
            [
                'label'     => "Generator",
                'type'      => 'select',
                'name'      => 'generator_id',
                'entity'    => 'generator',
                'model'     => "App\Models\Generator",
                'attribute' => 'FullGenerator',
            ],
            [
                'label' => 'On Rent Date',
                'type' => 'date',
                'name' => 'on_rent_date',
            ],
            [
                'label' => 'Delivery Order Number',
                'type' => 'number',
                'name' => 'delivery_order_num',
            ],
            [
                'label' => 'Notes',
                'type' => 'textarea',
                'name' => 'transaction_notes',
            ],

        ]);


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
