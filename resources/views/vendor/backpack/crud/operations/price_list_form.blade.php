@extends(backpack_view('blank'))



@php
$defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    'RentBox' => false,
];
$breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp



@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Price List</span>
            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                        <i
                            class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>

    <script>
        function SelectProfiles() {
            var rows = document.querySelectorAll();
            var profileItems = [];

            for (var i = 0; i < rows.length; i++) {
                var elm = rows[i].querySelector('input[type="checkbox"].select').id;
            }
        }

        function deleteRow(){
        if(document.querySelectorAll('input[type="checkbox"]:checked').length == 0) {
            new Noty({
                type: "warning",
                text: "<strong>No rows selected.</strong>"      
            }).show();

            return
        } else {
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(e => {
			e.parentNode.parentNode.remove()
		  });
		new Noty({
				type: "success",
				text: "<strong>Success!</strong><br>Selected rows were removed."
			  }).show();
        }
    }
    </script>
@endsection



@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mx-auto text-center mt-1 mb-4">
                <h2>Select Profiles</h2>
                <h3>{{$entry->FullGenerator}}</h3>
                <h4>{{$entry->site_address}}, {{$entry->site_city}}, {{$entry->site_state}} {{$entry->site_zip}}</h4>
            </div>
        </div>
        <div class="row">
            <button class="btn btn-danger" onclick="deleteRow();">REMOVE SELECTED</button>
        </div>
        <table class="table table-striped table-hover" id="profile_table">
            <thead>
                <tr>
                    <th scope="col">Select</th>
                    <th scope="col" class="text-end">Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Primary Disposal Facility</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Enterprise</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entry->profiles as $profile)
                    <tr>
                        <td class="hide">
                            <input type="checkbox" class="select" id="checkbox_">
                        </td>
                        <td class="text-end">{{$profile->number}}</td>
                        <td>{{$profile->name}}</td>
                        <td>{{$profile->primaryFacility->facility->name ?? ''}}</td>
                        <td>{{$profile->profile_status}}</td>
                        <td class="text-center">{{$profile->enterprise->is_enterprise == 1 ? "Yes" : "No"}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection