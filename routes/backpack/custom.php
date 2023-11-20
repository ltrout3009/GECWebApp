<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('generator', 'GeneratorCrudController');
    Route::crud('profile', 'ProfileCrudController');
    Route::crud('facility', 'FacilityCrudController');
    Route::crud('approval', 'ApprovalCrudController');
    Route::crud('wpc', 'WpcCrudController');
    Route::crud('waste', 'WasteCrudController');
    Route::crud('container', 'ContainerCrudController');
    Route::crud('base', 'BaseCrudController');
    Route::crud('pricing', 'PricingCrudController');
    Route::crud('asset-class', 'AssetClassCrudController');
    Route::crud('asset-lienholder', 'AssetLienholderCrudController');
    Route::crud('asset-owner', 'AssetOwnerCrudController');
    Route::crud('asset-type', 'AssetTypeCrudController');
    Route::crud('asset-status-type', 'AssetStatusTypeCrudController');
    Route::crud('branch', 'BranchCrudController');
    Route::crud('bulk-waste-container-type', 'BulkWasteContainerTypeCrudController');
    Route::crud('department', 'DepartmentCrudController');
    Route::crud('location', 'LocationCrudController');
    Route::crud('insurance-type', 'InsuranceTypeCrudController');
    Route::crud('waste-disposition-ts-type', 'WasteDispositionTsTypeCrudController');
    Route::crud('property-type', 'PropertyTypeCrudController');
    Route::crud('event-status-type', 'EventStatusTypeCrudController');
    Route::crud('event-type', 'EventTypeCrudController');
    Route::crud('event-interval-type', 'EventIntervalTypeCrudController');
    Route::crud('power-asset', 'PowerAssetCrudController');
}); // this should be the absolute last line of this file