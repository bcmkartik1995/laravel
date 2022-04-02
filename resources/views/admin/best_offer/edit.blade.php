@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('content')


<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Best Offer</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('best-offer.index') }}">Best Offer</a>
                            </li>
                            <li class="breadcrumb-item">Edit Best Offer
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Best Offer</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_offer" method="POST" action="{{ route('best-offer.update',$best_offer->id) }}" enctype="multipart/form-data">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                    <div class="form-group">
                                        <div class="form-line">       
                                            <select class="form-control select2" name="offer_id" id="offer_id">
                                                <option value="">Select Offer</option>
                                                @foreach($offers as $offer)
                                                    <option value="{{ $offer->id }}" {{ $offer->id == $best_offer->offer_id ? 'selected':''}}>{{ $offer->title }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('offer_id'))
                                                <label id="name-error" class="error" for="offer_id">{{ $errors->first('offer_id') }}</label>
                                            @endif
                                        </div>
                                    </div>

                                <button class="btn btn-primary btn-sm" type="submit">UPDATE</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
    </div>
</div>


@endsection

@section('scripts')

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<script>

    $(".select2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
 

</script>


@endsection
