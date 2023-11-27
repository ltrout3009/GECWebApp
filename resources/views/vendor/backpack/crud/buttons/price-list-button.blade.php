@if ($crud->hasAccess('priceList', $entry))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/price-list') }}" class="btn btn-xs btn-success">
        <span><i class="la la-file-invoice-dollar" style="padding: 0px 5px 0px 0px"></i>Create Price List</span>
    </a>
@endif