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

        document.addEventListener("DOMContentLoaded", function() {
            getProfileData();
        });

        function selectProfiles(){

            var profile_ids = [];

            if(document.querySelectorAll('input[type="checkbox"]:checked').length == 0) {
                new Noty({
                    type: "warning",
                    text: "<strong>No rows selected.</strong>"      
                }).show();
            return
            } else {
                document.querySelectorAll('input[type="checkbox"]:checked').forEach(e => {
                    var prof_id = e.getAttribute("id");

                    profile_ids.push(prof_id);

                    new Noty({
                    type: "success",
                    text: "<strong>Success!</strong><br>Profile ID: " + prof_id
                    }).show();
                });

                getProfileContainers(profile_ids);
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

        function getProfileData() {
            var elem = document.getElementById("gen_number");
            var gen_id = elem.getAttribute('data-gen-num');

            var ajax = new XMLHttpRequest();
            ajax.open("GET", "profiles-data?generator_id=" + gen_id, true);
            ajax.send();

            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    var html = '';

                    for (var a = 0; a < response.length; a++) {
                        html += "<tr id='" + response[a].id + "'>";
                            html += "<td class='hide text-center'>";
                                    html += "<input type='checkbox' class='select' id='" + response[a].id +"'>";
                                    html += "</td>";
                            html += "<td class='text-end'>" + response[a].number + "</td>";
                            html += "<td>" + response[a].name + "</td>";
                            html += "<td>" + response[a].primary_facility.facility.name + "</td>";
                            html += "<td>" + response[a].profile_status + "</td>";
                            html += "<td class='text-center'>" + response[a].enterprise.is_enterprise + "</td>";
                        html += "</tr>";
                    }
                    
                    document.getElementById("gen_profiles").innerHTML = html;
                }
            }
        }

        function getProfileContainers(profile_ids) {
            var prof_ids = [];
            prof_ids.push(profile_ids);
            
            /* for (var a = 0; a < prof_ids.length; a++) {
                
            } */

            var ajax = new XMLHttpRequest();
                ajax.open("GET", "pricing-data?profile_id=" + prof_ids, true);
                ajax.send();

                ajax.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        var html = '';

                        for (var b = 0; b < response.length; b++) {
                            html += "<tr id='" + response[b].id + "'>";
                                html += "<td class='hide text-center'>";
                                        html += "<input type='checkbox' class='select' id='" + response[b].id +"'>";
                                        html += "</td>";
                                html += "<td class='text-end'>" + response[b].profile.number + "</td>";
                                html += "<td>" + response[b].profile.name + "</td>";
                                html += "<td>" + response[b].waste.facility.name + "</td>";
                                html += "<td>" + "0" + "</td>";
                                html += "<td class='text-center'>" + response[b].waste.container.category + "</td>";
                                html += "<td class='text-end'>" + response[b].waste.container.size + "</td>";
                                html += "<td class='text-end'>" + response[b].waste.wpc_id + "</td>";
                                html += "<td class='text-center'>" + response[b].is_active + "</td>";
                            html += "</tr>";
                        }

                        document.getElementById("gen_containers").innerHTML = html;
                    }
                }
        }

    </script>

@endsection



@section('content')

    <div class="container-fluid" data-gen-num="{{$entry->id}}" id="gen_number">

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
                    <table class="table table-striped table-hover" id="profile_table" style="">
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


        <!-- TAB - Containers -->
        <div class="card tab" id="Containers" style="display:none;">

            <div class="card-body">

                <h2 class="card-title">Select Containers</h2>
                <h4 class="card-subtitle">{{$entry->FullGenerator}}</h4>

            <!-- BUTTONS -->
                <div class="btn-toolbar">
                    <div class="btn-group">
                        
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
                                <th scope="col" class="text-end">Profile Number</th>
                                <th scope="col">Profile Name</th>
                                <th scope="col">Disposal Facility</th>
                                <th scope="col">Primary Facility</th>
                                <th scope="col">Container Type</th>
                                <th scope="col">Container Size</th>
                                <th scope="col">WPC</th>
                                <th scope="col" class="text-center">Active</th>
                            </tr>
                        </thead>
                        <tbody id="gen_containers">
                            <!-- AJAX Handled -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection