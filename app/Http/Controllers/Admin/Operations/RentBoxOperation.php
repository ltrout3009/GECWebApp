<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Exception;
use Validator;
use Alert;
use App\Models\RentalAssetTransaction;
use App\Models\RentalAsset;

trait RentBoxOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupRentBoxRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/rent-box', [
            'as'        => $routeName.'.rent-box',
            'uses'      => $controller.'@rentBox',
            'operation' => 'rentBox',
        ]);

        Route::post($segment.'/{id}/rent-box', [
            'as'        => $routeName.'.rent-box-save',
            'uses'      => $controller.'@postRentBox',
            'operation' => 'rentBox',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupRentBoxDefaults()
    {
        CRUD::allowAccess('rentBox');

        CRUD::operation('rentBox', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
             CRUD::addButton('line', 'rental-asset-buttons', 'view', 'crud::buttons.rental-asset-buttons', 'end');
        });

        CRUD::operation('show', function () {
            CRUD::addButton('line', 'rental-asset-buttons', 'view', 'crud::buttons.rental-asset-buttons.');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function rentBox()
    {
        CRUD::hasAccessOrFail('rentBox');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? 'Rent Box '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();
        

        // load the view
        return view('crud::operations.rent_box_form', $this->data);
    }

    
    public function postRentBox(Request $request) {
        /*
        $validator = Validator::make($request->all(), [
            'asset' => 'required',
            'generators' => 'required',
            'rentdate' => 'required|date',
            'delordernum' => 'required',
            'message' => 'nullable'
        ]);
        */
        try {
            $this->crud->getCurrentEntry()->rental_transactions()->create([
                'rental_asset_id' => $request->input('asset'),
                'generator_id' => $request->input('generators'),
                'on_rent_date'  => $request->input('rentdate'),
                'delivery_order_num' => $request->input('delordernum'),
                'on_rent_notes' => $request->input('message'),
                'is_rental_complete' => '0'
            ]);

            $this->crud->getCurrentEntry()->status_id = '3';
            $this->crud->getCurrentEntry()->save();

            Alert::success(trans('backpack::crud.insert_success'))->flash();
            return redirect(url($this->crud->route));

        } catch (\Exception $e) {
            Alert::error("Error: " . $e->getMessage())->flash();

            return redirect()->back()->withInput();
        }
    }     
}