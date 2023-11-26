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
            <span class="text-capitalize">Return Box</span>
            <!-- <small>Asset #: {!! $entry->displayed_num !!}</small> -->
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


    <script type="text/javascript">
        function showDiv(divId, element) {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }
    </script>

    <style>
        #washout_form, #repair_form {
            display: none;
            margin-top: 20px;
        }
    </style>
@endsection



@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-8 bold-labels">
                @if ($errors->any())
                    <div class="alert alert-danger pb-0">
                        <ul class="list-ustyled">
                            @foreach ($errors->all() as $error)
                                <li><i class="la la-info-circle"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="post" action="">
                    @csrf
                    <div class="card">
                        <div class="card-body row">
                            <div class="form-group col-md-6">
                                <label>Asset #</label>
                                <input type="text" name="asset" value="{{ $entry->displayed_num }}" readonly disabled class="form-control @error('asset') is invalid @enderror">
                                    @error('asset')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Generator</label>
                                <input type="text" name="generator" value="{{ $entry->open_rental->generator->FullGenerator }}" readonly disabled class="form-control @error('generator') is invalid @enderror">
                                    @error('generator')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>On Rent Date</label>
                                <input type="text" name="onrentdate" value="{{ $entry->open_rental->on_rent_date->format('m/d/Y') }}" readonly disabled class="form-control @error('onrentdate') is invalid @enderror">
                                    @error('onrentdate')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Delivery Order Number</label>
                                <input type="text" name="delordernum" value="{{ $entry->open_rental->delivery_order_num }}" readonly disabled class="form-control @error('delordernum') is invalid @enderror">
                                    @error('delordernum')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Delivery Notes</label>
                                <input type="text" name="delnotes" value="{{ $entry->open_rental->delivery_notes }}" readonly disabled class="form-control @error('delnotes') is invalid @enderror">
                                    @error('delnotes')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <hr>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Off Rent Date</label>
                                <input type="date" name="offrentdate" value="{{ old('offrentdate') }}" class="form-control @error('offrentdate') is invalid @enderror">
                                    @error('offrentdate')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pickup Order Number</label>
                                <input type="number" name="puordernum" value="{{ old('puordernum') }}" class="form-control @error('puordernum') is invalid @enderror">
                                    @error('puordernum')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Pickup Notes</label>
                                <textarea name="punotes" class="form-control @error('punotes') is invalid @enderror">{{ old('punotes') }}</textarea>
                                    @error('punotes')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Washout Needed?</label><br>
                                <select name="washout" onchange="showDiv('washout_form', this)">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Repairs Needed?</label><br>
                                <select name="washout" onchange="showDiv('repair_form', this)">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url($crud->route) }}" class="btn w-100 btn-default"><span class="la la-ban"></span>
                                &nbsp;Cancel</a>
                            </div>
                            <div class="col-md-8">
                                <input type="hidden" name="_save_action" value="save_return">
                                <button type="submit" class="btn w-100 btn-success">
                                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                    <span data-value="save-return">Return Box</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="washout_form">
                        <div class="card-body row">
                            <h2>Washout Form</h2>
                            <h4 style="color: orangered;">TODO: Washouts...</h4>
                        </div>
                    </div>

                    <div class="card" id="repair_form">
                        <div class="card-body row">
                            <h2>Repair Form</h2>
                            <h4 style="color: orangered;">TODO: Repairs...</h4>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection