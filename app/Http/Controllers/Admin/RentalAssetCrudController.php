<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RentalAssetRequest;
use App\Models\RentalAsset;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

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

    protected function setupShowOperation() 
    {
        CRUD::removeAllButtons();

        //CRUD::setOperationSetting('tabsType', 'vertical');

        // Title Widget
        Widget::add([
            'type' => 'alert',
            'class' => 'alert alert-dark mb-2',
            'heading' => '<b> Asset: </b>' . RentalAsset::find(\Route::current()->parameter('id'))->displayed_num . "<br> Status: " . RentalAsset::find(\Route::current()->parameter('id'))->assetStatusType->status_type ,
            'content' => null,
            'close_button' => false,
            'wrapper' => ['class' => 'col-sm-6 col-md-4', 'style' => 'margin-bottom: 50px;',]
           ])->to('before_content');

        // Details Tab
        CRUD::column('displayed_num')->label('Asset #')->type('text')->tab('Details');
        CRUD::column('old_num')->label('Old #')->type('text')->tab('Details');
        CRUD::column('assetClass')->label('Asset Type')->type('select')->tab('Details');
        CRUD::column('capacity')->label('Capacity')->type('integer')->tab('Details');
        CRUD::column('capacity_unit')->label('Unit')->type('text')->tab('Details');
        CRUD::column('assetOwner')->label('Owner')->type('select')->tab('Details');
        CRUD::column('propertyType')->label('Property Type')->type('select')->tab('Details');
        CRUD::column('serial_vin_num')->label('Serial Number')->type('text')->tab('Details');

        // Current/Recent Tab TODO: This should show the LATEST/Current generator renting this box
        CRUD::column('latest_transaction.generator.id')->label('Generator Number')->type('select')->tab('Latest Rental');
        CRUD::column('latest_transaction.generator.name')->label('Generator Name')->type('select')->tab('Latest Rental');
        CRUD::column('latest_transaction.on_rent_date')->label('On Rent Date')->type('date')->format('M/D/Y')->tab('Latest Rental');
        CRUD::column('latest_transaction.off_rent_date')->label('Off Rent Date')->type('date')->format('M/D/Y')->tab('Latest Rental');
        CRUD::column('latest_transaction.release_date')->label('Release Date')->type('date')->format('M/D/Y')->tab('Latest Rental');
        CRUD::column('latest_transaction.delivery_order_num')->label('Delivery Order #')->type('select')->tab('Latest Rental');
        CRUD::column('latest_transaction.pickup_order_num')->label('Pickup Order #')->type('select')->tab('Latest Rental');
        CRUD::column('latest_transaction.transaction_notes')->label('Notes')->type('select')->limit(100)->tab('Latest Rental');

        // margin widget
        Widget::add([
            'type' => 'div',
            'class' => 'row',
            'style' => 'margin-bottom: 50px',
        ])->to('after_content');

        // Rental History
        Widget::add([
            'type' => 'relation_table',
            'name' => 'rental_transactions',
            'label' => 'Rental History',
            'backpack_crud' => 'rentalassettransaction',
            'relation_attribute' => 'id',
            'button_create' => false,
            'button_delete' => true,
            'button_edit' => true,
            'button_show' => false,
            'buttons' => true,
            'search' => true,
            'visible' => function($entry){
                return $entry->rental_transactions->count() > 0;
            },
            'columns' => [
                [
                    'label' => 'Generator #',
                    'closure' => function($entry){
                        return "{$entry->generator_id}";
                    }
                ],
                [
                    'label' => 'Generator Name',
                    'closure' => function($entry){
                        return "{$entry->generator->name}";
                    }
                ],
                [
                    'label' => 'On Rent Date',
                    'closure' => function($entry){
                        return date_format($entry->on_rent_date, 'n/j/Y');
                    }
                ],
                [
                    'label' => 'Off Rent Date',
                    'closure' => function($entry){
                        return date_format($entry->off_rent_date, 'n/j/Y');
                    }
                ],
                [
                    'label' => 'Release Date',
                    'closure' => function($entry){
                        return date_format($entry->release_date, 'n/j/Y');
                    }
                ],
                [
                    'label' => 'Delivery Order #',
                    'closure' => function($entry){
                        return "{$entry->delivery_order_num}";
                    }
                ],
                [
                    'label' => 'Pickup Order #',
                    'closure' => function($entry){
                        return "{$entry->pickup_order_num}";
                    }
                ],
                [
                    'label' => 'Rental Notes',
                    'closure' => function($entry){
                        return "{$entry->transaction_notes}";
                    },
                    'limit' => 100,
                ],

            ],
        ])->to('after_content');

        // margin widget
        Widget::add([
            'type' => 'div',
            'class' => 'row',
            'style' => 'margin-bottom: 50px',
        ])->to('after_content');

        // Notes
        Widget::add([
            'type' => 'relation_table',
            'name' => 'rental_notes',
            'label' => 'Asset Notes',
            'backpack_crud' => 'rentalassetnotes',
            'relation_attribute' => 'id',
            'button_create' => false,
            'button_delete' => true,
            'button_edit' => true,
            'button_show' => false,
            'buttons' => true,
            'search' => true,
            'visible' => function($entry){
                return $entry->rental_notes->count() > 0;
            },
            'columns' => [
                [
                    'label' => 'Date',
                    'closure' => function($entry){
                        return date_format($entry->note_date, 'n/j/Y');
                    }
                ],
                [
                    'label' => 'Note',
                    'closure' => function($entry){
                        return "{$entry->note}";
                    }
                ],
            ],
        ])->to('after_content');

        // margin widget
        Widget::add([
            'type' => 'div',
            'class' => 'row',
            'style' => 'margin-bottom: 50px',
        ])->to('after_content');

        // Events
        Widget::add([
            'type' => 'relation_table',
            'name' => 'rental_events',
            'label' => 'Rental Events',
            'backpack_crud' => 'rentalassetevents',
            'relation_attribute' => 'id',
            'button_create' => false,
            'button_delete' => true,
            'button_edit' => true,
            'button_show' => false,
            'buttons' => true,
            'search' => true,
            'visible' => function($entry){
                return $entry->rental_events->count() >= 0;
            },
            'columns' => [
                [
                    'label' => 'Event Type',
                    'closure' => function($entry){
                        return "{$entry->eventType->event_type_name}";
                    }
                ],
                [
                    'label' => 'Status',
                    'closure' => function($entry){
                        return "{$entry->eventStatusType->status_type_name}";
                    }
                ],
                [
                    'label' => 'Created Date',
                    'closure' => function($entry){
                        return "{$entry->created_date}";
                    }
                ],
                [
                    'label' => 'Due Date',
                    'closure' => function($entry){
                        return "{$entry->due_date}";
                    }
                ],
                [
                    'label' => 'Start Date',
                    'closure' => function($entry){
                        return "{$entry->start_date}";
                    }
                ],
                [
                    'label' => 'Completed Date',
                    'closure' => function($entry){
                        return "{$entry->completed_date}";
                    }
                ],
                [
                    'label' => 'Cost',
                    'closure' => function($entry){
                        return "{$entry->cost}";
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
