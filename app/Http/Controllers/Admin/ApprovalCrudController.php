<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ApprovalRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Profile;

/**
 * Class ApprovalCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ApprovalCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Approval::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/approval');
        CRUD::setEntityNameStrings('approval', 'approvals');
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
        CRUD::removeAllButtons();
        CRUD::setOperationSetting('lineButtonsAsDropdown', true);

        //CRUD::enableDetailsRow();
        //CRUD::setDetailsRowView('vendor.backpack.crud.details_row.profile');

        CRUD::orderBy('profile_id', 'asc');


        CRUD::addColumns ([
            
            [
                'label' => 'Profile Number',
                'type' => 'select',
                'name' => 'profile.number',
                'orderable'  => true,
                'orderLogic' => function ($query, $column, $columnDirection) {
                        return $query->leftJoin('profiles', 'approvals.profile_id', '=', 'profiles.id')
                                     ->orderBy('profiles.number', $columnDirection)->select('approvals.*');
                    },
                'wrapper'   => [
                    'href'=> function($crud, $column, $entry, $related_key) {
                        return backpack_url('profile/'.$related_key.'/show');
                    },
                ],
            ],

            [
                'label' => 'Profile Name',
                'type' => 'select',
                'name' => 'profile.name',
                'orderable'  => true,
                'orderLogic' => function ($query, $column, $columnDirection) {
                        return $query->leftJoin('profiles', 'approvals.profile_id', '=', 'profiles.id')
                                     ->orderBy('profiles.name', $columnDirection)->select('approvals.*');
                    },
            ],
            
            [
                'label' => 'Disposal Facility',
                'type' => 'select',
                'name' => 'facility.name',
                'orderable'  => true,
                'orderLogic' => function ($query, $column, $columnDirection) {
                        return $query->leftJoin('facilities', 'approvals.facility_id', '=', 'facilities.id')
                                     ->orderBy('facilities.name', $columnDirection)->select('approvals.*');
                    },
            ],

            [
                'label' => 'Primary Facility',
                'type' => 'boolean',
                'name' => 'is_primary_facility',
            ],

            [
                'label' => 'Approval Status',
                'type' => 'text',
                'name' => 'approval_status',
            ],

            [
                'label' => 'Approval Number',
                'type' => 'text',
                'name' => 'number',
            ],

            [
                'label' => 'Expiration',
                'type' => 'date',
                'name' => 'expiration',
                'format' => 'MMM D, YYYY'
            ],

        ]);

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ApprovalRequest::class);
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
