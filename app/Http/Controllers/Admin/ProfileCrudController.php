<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProfileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProfileCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Profile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/profile');
        CRUD::setEntityNameStrings('profile', 'profiles');
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

        CRUD::enableDetailsRow();
        CRUD::setDetailsRowView('vendor.backpack.crud.details_row.profile');

        
        $this->crud->orderBy('generator_id', 'asc');
        $this->crud->orderBy('number', 'asc');

        $this->crud->addColumns([
            [
                'label'     => 'Generator', // Table column heading
                'type'      => 'select',
                'name'      => 'generator.FullGenerator', // the column that contains the ID of that connected entity;
                'limit'     => 255,
                'orderable'  => true,
                'orderLogic' => function ($query, $column, $columnDirection) {
                        return $query->leftJoin('generators', 'generators.id', '=', 'profiles.generator_id')
                                     ->orderBy('generators.name', $columnDirection)->select('profiles.*');
                    },
                'wrapper'   => [
                    'href'=> function($crud, $column, $entry, $related_key) {
                        return backpack_url('generator/'.$related_key.'/show');
                    },
                ],
            ],

            [
                'name' => 'number',
                'type' => 'integer',
                'label' => 'Profile Number',
                'wrapper' => [
                    'style' => 'float:right',
                    'class' => 'badge bg-info',
                ]
            ],

            [
                'name' => 'name',
                'type' => 'text',
                'label' => 'Name',
            ],

            [
                'label' => 'Primary Disposal Facility',
                'type' => 'select',
                'name' => 'primaryFacility.facility.name',
                'limit' => 255,
                'orderable'  => true,
                'orderLogic' => function ($query, $column, $columnDirection) {
                        return $query->leftJoin('approvals', 'profiles.id', '=', 'approvals.profile_id')
                                     ->leftJoin('facilities', 'approvals.facility_id', '=', 'facilities.id')
                                     ->orderBy('facilities.name', $columnDirection)->select('profiles.*');
                    },
            ],
            
            [
                'name' => 'profile_status',
                'type' => 'text',
                'label' => 'Status',
                'wrapper' => [
                    'element' => 'span',
                    'class'   => function ($crud, $column, $entry, $related_key) {
                        if ($column['text'] == 'Approved') {
                            return 'badge rounded-pill bg-success';
                        } elseif ($column['text'] == 'Expired') {
                            return 'badge rounded-pill bg-danger';
                        } elseif ($column['text'] == 'Cancelled') {
                            return 'badge rounded-pill bg-warning';
                        }
                        return 'badge rounded-pill bg-info';
                    },
                ],
            ],

            [
                'label'     => 'Enterprise/Network', 
                'type'      => 'boolean',
                'options'   => ['1' => 'Enterprise', '0' => 'Network'],
                'name'      => 'enterprise.is_enterprise',
                'orderable'  => true,
                'orderLogic' => function ($query, $column, $columnDirection) {
                        return $query->leftJoin('pricings', 'pricings.profile_id', '=', 'profiles.id')
                                     ->orderBy('pricings.is_enterprise', $columnDirection)->select('profiles.*');
                    },
                'wrapper' => [
                    'element' => 'span',
                    'class'   => function ($crud, $column, $entry, $related_key) {
                        if ($column['text'] == 'Enterprise') {
                            return 'badge rounded-pill bg-success';
                        } elseif ($column['text'] == 'Network') {
                            return 'badge rounded-pill bg-info';
                        } 
                        return 'badge rounded-pill bg-info';
                    },
                ],
            ],
            
        ]);

    }

    protected function setupShowOperation()
    {
        CRUD::setFromDb();
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProfileRequest::class);
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
