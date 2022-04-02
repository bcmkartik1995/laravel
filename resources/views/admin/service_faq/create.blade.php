@extends('layouts.admin')

@section('styles')


@endsection

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Services Faq</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('service_faq.index',$service_id) }}">Service Faq</a>
                            </li>
                            <li class="breadcrumb-item active">Add Faq
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
                            <h4 class="card-title">Add Faq</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_specification" method="POST" action="{{ route('service_faq.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    <input type="hidden" name="service_id" value="{{$service_id}}">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Question</label>
                                            <input type="text" class="form-control @if($errors->has('question')) is-invalid @endif" name="question" value="{{old('question')}}" placeholder="Enter Question">
                                            @if($errors->has('question'))
                                                <label id="question-error" class="error" for="question">{{ $errors->first('question') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Answer</label>
                                            <textarea class="form-control @if($errors->has('answer')) is-invalid @endif" name="answer" rows="5" >{{old('answer')}}</textarea>
                                            @if($errors->has('answer'))
                                                <label id="answer-error" class="error" for="answer">{{ $errors->first('answer') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
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


@endsection

