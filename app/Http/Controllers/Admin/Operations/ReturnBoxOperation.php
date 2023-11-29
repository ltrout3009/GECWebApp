<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait ReturnBoxOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupReturnBoxRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/{id}/return-box', [
            'as'        => $routeName . '.return-box',
            'uses'      => $controller . '@returnBox',
            'operation' => 'returnBox',
        ]);

        Route::post($segment . '/{id}/return-box', [
            'as' => $routeName . '.return-box-save',
            'uses' => $controller . '@postReturnBox',
            'operation' => 'returnBox',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupReturnBoxDefaults()
    {
        CRUD::allowAccess('returnBox');

        CRUD::operation('returnBox', function () {
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
    public function returnBox()
    {
        CRUD::hasAccessOrFail('returnBox');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? 'Return Box ' . $this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();
        $this->data['open_rental'] = $this->crud->getCurrentEntry()->open_rental();

        // load the view
        return view('crud::operations.return_box_form', $this->data);
    }

    public function postReturnBox(Request $request)
    {

        $washout = $request->input('washout');
        $repair = $request->input('repair');
        $today = date('Y-m-d');

        if ($washout == '0' && $repair == '0') {
            // box return ONLY logic
            try {
                // rental_asset_transaction
                $this->crud->getCurrentEntry()->rental_transactions()->where('id', $this->crud->getCurrentEntry()->open_rental->id)->update([
                    'return_date' => $request->input('returndate'),
                    'off_rent_date' => $request->input('offrentdate'),
                    'pickup_order_num' => $request->input('puordernum'),
                    'off_rent_notes' => $request->input('punotes'),
                    'is_rental_complete' => 1,
                ]);
                //rental_asset
                $this->crud->getCurrentEntry()->status_id = 2;
                $this->crud->getCurrentEntry()->save();

                Alert::success('Asset: ' . $this->crud->getCurrentEntry()->displayed_num . ' returned successfully.')->flash();
                return redirect(url($this->crud->route));
            } catch (\Exception $e) {
                Alert::error('Error: ' . $e->getMessage())->flash();

                return redirect()->back()-withInput();
            }
        } else if ($washout == '1' && $repair == '0') {
            // box return with washout logic
            try {
                // rental_asset_transaction
                $this->crud->getCurrentEntry()->rental_transactions()->where('id', $this->crud->getCurrentEntry()->open_rental->id)->update([
                    'return_date' => $request->input('returndate'),
                    'off_rent_date' => null,
                    'pickup_order_num' => $request->input('puordernum'),
                    'off_rent_notes' => $request->input('punotes'),
                    'is_rental_complete' => 0,
                ]);
                //rental_asset_event - washout
                $this->crud->getCurrentEntry()->rental_events()->create([
                    'rental_asset_id' => $this->crud->getCurrentEntry()->id,
                    'rental_asset_transaction_id' => $this->crud->getCurrentEntry()->open_rental->id,
                    'event_type_id' => $request->input('eventtype'),
                    'event_status_id' => 2,
                    'created_date' => $today,
                    'due_date' => $request->input('duedate'),
                    'description' => $request->input('washoutnotes'),
                ]);

                //rental_asset
                $this->crud->getCurrentEntry()->status_id = 6;
                $this->crud->getCurrentEntry()->save();

                Alert::success('Asset: ' . $this->crud->getCurrentEntry()->displayed_num . ' sent for washout successfully.')->flash();
                return redirect(url($this->crud->route));
            } catch (\Exception $e) {
                Alert::error('Error: ' . $e->getMessage())->flash();

                return redirect()->back()-withInput();
            }
        } else if ($washout == '0' && $repair == '1') {
            // box return with repair logic
            try {
                // rental_asset_transaction
                $this->crud->getCurrentEntry()->rental_transactions()->where('id', $this->crud->getCurrentEntry()->open_rental->id)->update([
                    'return_date' => $request->input('returndate'),
                    'off_rent_date' => null,
                    'pickup_order_num' => $request->input('puordernum'),
                    'off_rent_notes' => $request->input('punotes'),
                    'is_rental_complete' => 0,
                ]);
                //rental_asset_event - repair
                $this->crud->getCurrentEntry()->rental_events()->create([
                    'rental_asset_id' => $this->crud->getCurrentEntry()->id,
                    'rental_asset_transaction_id' => $this->crud->getCurrentEntry()->open_rental->id,
                    'event_type_id' => $request->input('eventtype2'),
                    'event_status_id' => 2,
                    'created_date' => $today,
                    'due_date' => $request->input('duedate2'),
                    'description' => $request->input('repairnotes'),
                ]);

                //rental_asset
                $this->crud->getCurrentEntry()->status_id = 6;
                $this->crud->getCurrentEntry()->save();

                Alert::success('Asset: ' . $this->crud->getCurrentEntry()->displayed_num . ' sent for repair successfully.')->flash();
                return redirect(url($this->crud->route));
            } catch (\Exception $e) {
                Alert::error('Error: ' . $e->getMessage())->flash();

                return redirect()->back()-withInput();
            }
        } else if ($washout == '1' && $repair == '1') {
            // box return with washout and repair logic
            try {
                // rental_asset_transaction
                $this->crud->getCurrentEntry()->rental_transactions()->where('id', $this->crud->getCurrentEntry()->open_rental->id)->update([
                    'return_date' => $request->input('returndate'),
                    'off_rent_date' => null,
                    'pickup_order_num' => $request->input('puordernum'),
                    'off_rent_notes' => $request->input('punotes'),
                    'is_rental_complete' => 0,
                ]);
                //rental_asset_event - washout
                $this->crud->getCurrentEntry()->rental_events()->create([
                    'rental_asset_id' => $this->crud->getCurrentEntry()->id,
                    'rental_asset_transaction_id' => $this->crud->getCurrentEntry()->open_rental->id,
                    'event_type_id' => $request->input('eventtype'),
                    'event_status_id' => 2,
                    'created_date' => $today,
                    'due_date' => $request->input('duedate'),
                    'description' => $request->input('washoutnotes'),
                ]);
                //rental_asset_event - repair
                $this->crud->getCurrentEntry()->rental_events()->create([
                    'rental_asset_id' => $this->crud->getCurrentEntry()->id,
                    'rental_asset_transaction_id' => $this->crud->getCurrentEntry()->open_rental->id,
                    'event_type_id' => $request->input('eventtype2'),
                    'event_status_id' => 2,
                    'created_date' => $today,
                    'due_date' => $request->input('duedate2'),
                    'description' => $request->input('repairnotes'),
                ]);

                //rental_asset
                $this->crud->getCurrentEntry()->status_id = 6;
                $this->crud->getCurrentEntry()->save();

                Alert::success('Asset: ' . $this->crud->getCurrentEntry()->displayed_num . ' sent for repair successfully.')->flash();
                return redirect(url($this->crud->route));
            } catch (\Exception $e) {
                Alert::error('Error: ' . $e->getMessage())->flash();

                return redirect()->back()-withInput();
            }
        }
    }
}
