<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GeneratorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Profile;
use App\Models\Pricing;

/**
 * Class GeneratorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GeneratorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Admin\Operations\PriceListOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Generator::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/generator');
        CRUD::setEntityNameStrings('generator', 'generators');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        
        
        /* Initial Setup Options */
        CRUD::setDefaultPageLength(15);
        CRUD::disablePersistentTable();
        CRUD::removeAllButtonsFromStack('top');
        CRUD::setOperationSetting('lineButtonsAsDropdown', false);

        CRUD::removeButtons(['update', 'delete'], 'line');

        CRUD::enableDetailsRow();
        CRUD::setDetailsRowView('vendor.backpack.crud.details_row.generator');

        CRUD::hasAccess('priceList');

        CRUD::orderBy('name','asc');


        $this->crud->addColumns([
            [
                'name' => 'id',
                'type' => 'integer',
                'label' => 'Number',
                'wrapper' => [
                    'style' => 'float:right',
                    'class' => 'badge bg-info',
                ]
            ],
            [
                'name' => 'name',
                'type' => 'text',
                'label' => 'Name',
                'limit' => '500',
            ],
            [
                'name' => 'facility',
                'type' => 'text',
                'label' => 'Facility',
                'wrapper' => [
                    'element' => 'div',
                    'class'   => function ($crud, $column, $entry, $related_key) {
                        if ($column['text'] == 'NBT') {
                            return 'badge rounded-pill bg-success';
                        } elseif ($column['text'] == 'HOU') {
                            return 'badge rounded-pill bg-info';
                        }
                        return 'badge rounded-pill bg-info';
                    }
                ]
            ],
            [
                'name' => 'epa_num',
                'type' => 'text',
                'label' => 'EPA ID',
            ],
            [
                'name' => 'state_num',
                'type' => 'text',
                'label' => 'State ID',
            ]
        ]);


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
        CRUD::setValidation(GeneratorRequest::class);
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

    public function getProfiles()
    {
        if(isset($_GET['generator_id'])) {
            $gen_id = $_GET['generator_id'];
        } else {
            $gen_id = "0";
        }

        $data = Profile::where('generator_id', $gen_id)->with('pricings')->with('enterprise')->with('primaryFacility.facility')->get();

        echo json_encode($data);
    }

    public function getPricing_old() 
    {
        if(isset($_GET['profile_id'])) {
            $get_array = array($_GET['profile_id']);

            foreach($get_array as $get) {
                $prof_id = $get;
            } 
        } else {
            $prof_id = 0;
        }

        $data = Pricing::where('profile_id', $prof_id)->with('profile')->with('waste')->with('waste.container')->with('waste.facility')->with('base')->get();

        echo json_encode($data);
    }

    public function getPricing() 
    {        
        $profiles = json_decode($_GET['profile_id'], true);

        //TODO: CANNOT PARSE. No EOF or , between different profiles. Probably bc of loop?

        foreach ($profiles as $profile) {
            if(isset($_GET['profile_id'])) {                
                $prof_id = $profile;
    
                $data = Pricing::where('profile_id', $prof_id)->with('profile')->with('waste')->with('waste.container')->with('waste.facility')->with('base')->get();
    
                echo json_encode($data);
    
            } else {
                $prof_id = 0;
    
                echo json_encode('if(isset) == false currently.');
            }

            
        }
    }
}
