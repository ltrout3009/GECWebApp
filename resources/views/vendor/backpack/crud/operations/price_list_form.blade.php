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

    <style>
        .tab-green {
            background-color: #00a859;
        }
    </style>

    <script>
        function SelectProfiles() {
            var rows = document.querySelectorAll();
            var profileItems = [];

            for (var i = 0; i < rows.length; i++) {
                var elm = rows[i].querySelector('input[type="checkbox"].select').id;
            }
        }

        function selectProfiles(){

            if(document.querySelectorAll('input[type="checkbox"]:checked').length == 0) {
                new Noty({
                    type: "warning",
                    text: "<strong>No rows selected.</strong>"      
                }).show();
            return
            } else {
                document.querySelectorAll('input[type="checkbox"]:checked').forEach(e => {
                    var prof_id = e.getAttribute("id");

                    new Noty({
                    type: "success",
                    text: "<strong>Success!</strong><br>Profile ID: " + prof_id
                    }).show();
                });
            }
        }

        function openTab(evt, tabName) {
            var i, x, tablinks;
            x = document.getElementsByClassName("tab");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < x.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" tab-green", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " tab-green";
        }


        function getProfileData(generator_id) {

            if (generator_id == 0) {
                var html = '<td>No Profiles</td>';
                document.getElementById("gen_profiles").innerHTML = html;
            } else {
                var ajax = new XMLHttpRequest();
                ajax.open("GET", "profiles-data?generator_id=" + generator_id, true);
                ajax.send();

                ajax.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        var html = '<td>loading</td>';

                        for (var a = 0; a < response.length; a++) {
                            html += "<td>" + response[a].number + "</td>";
                            html += "<td>" + response[a].name + "</td>";
                            html += "<td>" + response[a].facility_id + "</td>";
                            html += "<td>" + response[a].profile_status + "</td>";
                            html += "<td>0</td>";
                        }
                        document.getElementById("gen_profiles").innerHTML = html;
                    }
                };
            }

        }

    </script>
@endsection



@section('content')

    <div class="container-fluid">

        <!-- TABS -->

        <div class="text-center mt-1 mb-5">
            <div class="btn-group d-flex">
                <button class="btn tablink tab-green" onclick="openTab(event,'Profiles')">Profiles</button>
                <button class="btn tablink" onclick="openTab(event, 'Containers')">Containers</button>
                <button class="btn tablink" onclick="openTab(event, 'Pricing')">Pricing</button>
            </div>
        </div>

        <!-- TAB - Profiles -->
        <div class="card tab" id="Profiles">

            <div class="card-body">

                <h2 class="card-title">Select Profiles</h2>
                <h4 class="card-subtitle">{{$entry->FullGenerator}}</h4>

            <!-- BUTTONS -->
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <button class="btn btn-success" onclick="selectProfiles();">Continue with Selected Profiles</button>
                    </div>
                </div>

            </div>
                <!-- CONTENT -->
            <div class="card-body">

                <div>
                    <table class="table table-striped table-hover" id="profile_table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Select</th>
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
                                    <td class="hide text-center">
                                        <input type="checkbox" class="select" id="{{$profile->id}}">
                                    </.>
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
            </div>
        </div>


        <!-- TAB - Containers -->
        <div class="card tab" id="Containers" style="display:none;">

            <div class="card-body">

                <h2 class="card-title">Select Containers</h2>
                <h4 class="card-subtitle">{{$entry->FullGenerator}}</h4>

            <!-- BUTTONS -->
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <button class="btn btn-info" onclick="getProfileData({{$entry->id}});">Get Profiles</button>
                    </div>
                </div>

            </div>
                <!-- CONTENT -->
            <div class="card-body">

                <div>
                    <table class="table table-striped table-hover" id="container_table" style="">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Select</th>
                                <th scope="col" class="text-end">Number</th>
                                <th scope="col">Name</th>
                                <th scope="col">Primary Disposal Facility</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Enterprise</th>
                            </tr>
                        </thead>
                        <tbody id="gen_profiles">
                            <!-- AJAX Handled -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection