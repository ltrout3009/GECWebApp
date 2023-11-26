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
            <span class="text-capitalize">Rent Box</span>
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
@endsection



@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-8 bold-labels">
                @if ($errors->any())
                    <div class="alert alert-danger pb-0">
                        <ul class="list-unstyled">
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
                                <label>Generator</label> <br>
                                <select name="generators">
                                        <option value="" disabled selected>Select a generator...</option>
                                    @foreach($generator_info as $generator)
                                        <option value="{{ $generator->id }}"> {{ $generator->id . ' - ' . $generator->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>On Rent Date</label>
                                <input type="date" name="rentdate" value="{{ old('rentdate') }}" class="form-control @error('rentdate') is invalid @enderror">
                                    @error('rentdate')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Delivery Order Number</label>
                                <input type="number" name="delordernum" value="{{ old('delordernum') }}" class="form-control @error('delordernum') is invalid @enderror">
                                    @error('delordernum')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Rental Notes</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url($crud->route) }}" class="btn w-100 btn-default"><span class="la la-ban"></span>
                                &nbsp;Cancel</a>
                            </div>
                            <div class="col-md-8">
                                <input type="hidden" name="_save_action" value="save_rent">
                                <button type="submit" class="btn w-100 btn-success">
                                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                    <span data-value="save-rent">Rent Box</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection