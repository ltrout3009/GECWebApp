<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait PriceListOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupPriceListRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/price-list', [
            'as'        => $routeName.'.priceList',
            'uses'      => $controller.'@priceList',
            'operation' => 'priceList',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupPriceListDefaults()
    {
        CRUD::allowAccess('priceList');

        CRUD::operation('priceList', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'price_list', 'view', 'crud::buttons.price_list');
             CRUD::addButton('line', 'price-list-button', 'view', 'crud::buttons.price-list-button');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function priceList()
    {
        CRUD::hasAccessOrFail('priceList');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Price List '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();

        // load the view
        return view('crud::operations.price_list_form', $this->data);
    }
}