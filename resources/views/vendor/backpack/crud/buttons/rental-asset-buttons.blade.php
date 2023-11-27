@if ($crud->hasAccess('rentBox', $entry))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/rent-box') }}" class="btn btn-xs btn-primary" style="margin: 0px 5px;">
        <span><i class="la la-dumpster" style="padding: 0px 5px 0px 0px;"></i>Rent</span>
    </a>
@endif

@if ($crud->hasAccess('returnBox', $entry))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/return-box') }}" class="btn btn-xs btn-danger" style="margin: 0px 5px;">
        <span><i class="la la-dumpster" style="padding: 0px 5px 0px 0px"></i>Return</span>
    </a>
@endif