@if ($crud->hasAccess('show', $entry))
    @if(!$crud->model->translationEnabled())

    <a href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}" class="btn btn-xs btn-info" style="margin: 0px 5px;">
        <span><i class="la la-eye" style="padding: 0px 5px 0px 0px"></i>View</span>
    </a>
    
    @endif
@endif