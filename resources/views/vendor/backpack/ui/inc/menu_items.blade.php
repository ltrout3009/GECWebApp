{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')



{{-- WASTELINQ DATA --}}

<x-backpack::menu-separator title="Wastelinq Data"  style="text-transform:uppercase" />

<x-backpack::menu-dropdown title="Generator Info" icon="la la-info">
    <x-backpack::menu-dropdown-item title="Generators" icon="la la-industry" :link="backpack_url('generator')" />
    <x-backpack::menu-dropdown-item title="Bill Tos" icon="la la-money-bill-wave" />
    <x-backpack::menu-dropdown-item title="Profiles" icon="la la-file-invoice" :link="backpack_url('profile')" />
    <x-backpack::menu-dropdown-item title="Approvals" icon="la la-handshake" :link="backpack_url('approval')" />
    <x-backpack::menu-dropdown-item title="Billing Prices" icon="la la-file-invoice-dollar" :link="backpack_url('pricing')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Waste Info" icon="la la-trash">
    <x-backpack::menu-dropdown-item title="WPCs & Costs" icon="la la-home" :link="backpack_url('wpc')" />
<!--
        <x-backpack::menu-dropdown-item title="Costs" icon="la la-home" :link="backpack_url('waste')" />
-->
    <x-backpack::menu-dropdown-item title="Containers" icon="la la-home" :link="backpack_url('container')" />
    <x-backpack::menu-dropdown-item title="Disposal Facilities" icon="la la-home" :link="backpack_url('facility')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Products & Services" icon="la la-dropbox">
    <x-backpack::menu-dropdown-item title="Supplies" icon="la la-home" />
    <x-backpack::menu-dropdown-item title="Transportation & Fees" icon="la la-home" />
</x-backpack::menu-dropdown>



{{-- TOOLS --}}

<x-backpack::menu-separator title="Tools"  style="text-transform:uppercase" />

<x-backpack::menu-dropdown title="Pricing" icon="la la-search-dollar">
    <x-backpack::menu-dropdown-item title="Proposal" icon="la la-comments-dollar" />
    <x-backpack::menu-dropdown-item title="Price List" icon="la la-file-invoice-dollar" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Asset Tracking" icon="la la-search">
    <x-backpack::menu-dropdown-item title="Rentals" icon="la la-dumpster" />
    <x-backpack::menu-dropdown-item title="Powered" icon="la la-truck-moving" />
    <x-backpack::menu-dropdown-item title="Non-Powered" icon="la la-truck-loading" />
    <x-backpack::menu-dropdown-item title="Machinery & Equipment" icon="la la-tools" />
</x-backpack::menu-dropdown>
<x-backpack::menu-item title="Asset classes" icon="la la-question" :link="backpack_url('asset-class')" />
<x-backpack::menu-item title="Asset lienholders" icon="la la-question" :link="backpack_url('asset-lienholder')" />
<x-backpack::menu-item title="Asset owners" icon="la la-question" :link="backpack_url('asset-owner')" />
<x-backpack::menu-item title="Asset types" icon="la la-question" :link="backpack_url('asset-type')" />
<x-backpack::menu-item title="Asset status types" icon="la la-question" :link="backpack_url('asset-status-type')" />
<x-backpack::menu-item title="Branches" icon="la la-question" :link="backpack_url('branch')" />
<x-backpack::menu-item title="Bulk waste container types" icon="la la-question" :link="backpack_url('bulk-waste-container-type')" />
<x-backpack::menu-item title="Departments" icon="la la-question" :link="backpack_url('department')" />
<x-backpack::menu-item title="Locations" icon="la la-question" :link="backpack_url('location')" />
<x-backpack::menu-item title="Insurance types" icon="la la-question" :link="backpack_url('insurance-type')" />
<x-backpack::menu-item title="Waste disposition ts types" icon="la la-question" :link="backpack_url('waste-disposition-ts-type')" />
<x-backpack::menu-item title="Property types" icon="la la-question" :link="backpack_url('property-type')" />
<x-backpack::menu-item title="Event status types" icon="la la-question" :link="backpack_url('event-status-type')" />
<x-backpack::menu-item title="Event types" icon="la la-question" :link="backpack_url('event-type')" />
<x-backpack::menu-item title="Event interval types" icon="la la-question" :link="backpack_url('event-interval-type')" />
<x-backpack::menu-item title="Power assets" icon="la la-question" :link="backpack_url('power-asset')" />