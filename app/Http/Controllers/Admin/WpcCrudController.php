<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WpcRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use \App\Models\Approval;
use \App\Models\Base;
use \App\Models\Container;
use \App\Models\Facility;
use \App\Models\Generator;
use \App\Models\Pricing;
use \App\Models\Profile;
use \App\Models\Waste;
use \App\Models\Wpc;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class WpcCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WpcCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Wpc::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/wpc');
        CRUD::setEntityNameStrings('wpc', 'WPCs & Costs');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::denyAccess(['update','create', 'delete']);

        CRUD::setDefaultPageLength(15);
        CRUD::disablePersistentTable();
        CRUD::removeAllButtonsFromStack('top');
        CRUD::setOperationSetting('lineButtonsAsDropdown', false);

        /* CRUD::enableDetailsRow();
        CRUD::setDetailsRowView('vendor.backpack.crud.details_row.wpc_costs'); */
        
        //$this->crud->addButtonFromView('top', 'price-data', 'priceRouting', 'beginning');
        CRUD::allowAccess('cost-data');
        CRUD::addButtonFromView('top', 'cost-data', 'wpcCosts', 'beginning');


        $this->crud->OrderBy('id', 'asc');

        $this->crud->addColumns([

            [
                'label' => 'WPC',
                'type' => 'integer',
                'name' => 'id',
            ],

            [
                'label' => 'Waste Type',
                'type' => 'text',
                'name' => 'waste_type',
                'limit' => 100,
            ],

            [
                'label' => 'Disposal Method',
                'type' => 'text',
                'name' => 'disposal_method',
            ],

        ]);
    }

    protected function setupShowOperation()
    {
       Widget::add([
        'type' => 'alert',
        'class' => 'alert alert-dark mb-2',
        'heading' => '<b> WPC: ' . Wpc::find(\Route::current()->parameter('id'))->id . '</b> <br> Waste Type: ' . Wpc::find(\Route::current()->parameter('id'))->waste_type .'<br> Disposal Method: ' . Wpc::find(\Route::current()->parameter('id'))->disposal_method .'<br>',
        'content' => null,
        'close_button' => false,
       ])->to('before_content');

       Widget::add([
        'type'           => 'relation_table',
        'name'           => 'waste_costs',
        'label'          => 'Costs',
        'backpack_crud'  => 'waste',
        'visible' => True,
        'relation_attribute' => 'id',
        'button_create' => false,
        'button_delete' => false,
        'button_edit' => false,
        'button_show' => false,
        'buttons' => false,
        'search' => true,
        'columns' => [
            [
                'label' => 'TSDF',
                'closure' => function($entry){
                    return "{$entry->facility->name}";
                },
            ],
            [
                'label' => 'Vendor Code',
                'closure' => function($entry){
                    return "{$entry->vendor_code}";
                }
            ],
            [
                'label' => 'Container Type',
                'closure' => function($entry){
                    return "{$entry->container->category}";
                }
            ],
            [
                'label' => 'Container Size',
                'closure' => function($entry){
                    return "{$entry->container->size}";
                }
            ],
            [
                'label' => 'Cost Basis',
                'closure' => function($entry){
                    return "{$entry->base->name}";
                }
            ],
            [
                'label' => 'Cost',
                'closure' => function($entry){
                    return '$' . "{$entry->cost}";
                }
            ],
            [
                'label' => 'Min Cost',
                'closure' => function($entry){
                    return '$' . "{$entry->min_cost}";
                }
            ],
            [
                'label' => 'Case By Case',
                'closure' => function($entry){
                    return "{$entry->is_case_by_case}";
                }
            ],
            [
                'label' => 'Enterprise',
                'closure' => function($entry){
                    return "{$entry->is_enterprise}";
                }
            ],
        ],
    ])->to('after_content');
    

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(WpcRequest::class);
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
