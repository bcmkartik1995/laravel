@extends('layouts.admin') 

@section('content')  
<input type="hidden" id="headerdata" value="{{ __('ROLE') }}">
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">{{ __('Roles') }}</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">{{__('Manage Roles') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.admin.form-success')
        <!-- Add rows table -->
        <section id="add-row">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-12">
                                          <h4 class="card-title">Role</h4>
                                        </div>
                                        <div class="col-md-3 col-sm-12 text-md-right">
                                          <a href="{{route('admin-role-create')}}" class="add-btn  txt-white cusor-pointer btn btn-dark glow mr-1 mb-1"> <i class="bx bx-plus"></i>{{ __('Add New Staff') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="card-content">
                            <div class="card-body">
                              <div class="mr-table allproduct">
                                <div class="table-responsiv">
                                    <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th width="50%">{{ __('Permissions') }}</th>
                                            <th>{{ __('Options') }}</th>
                                        </tr>
                                      </thead>
                                    </table>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Add rows table -->
    </div>   
</div>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

  <div class="modal-header d-block text-center">
    <h4 class="modal-title d-inline-block">{{ __("Confirm Delete") }}</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
  </div>

      <!-- Modal body -->
      <div class="modal-body">
            <p class="text-center">{{ __('You are about to delete this Role.') }}</p>
            <p class="text-center">{{ __('Do you want to proceed?') }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
            <a class="btn btn-danger btn-ok">{{ __('Delete') }}</a>
      </div>

    </div>
  </div>
</div>

{{-- DELETE MODAL ENDS --}}

@endsection    

@section('scripts')
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/admin-assets/js/myscript.js') }}"></script>
<script src="{{ asset('assets/admin-assets/js/load.js') }}"></script>
<!-- END: Page Vendor JS-->
<script type="text/javascript">

    var table = $('#geniustable').DataTable({
           ordering: false,
           processing: true,
           serverSide: true,
           ajax: '{{ route('admin-role-datatables') }}',
           columns: [
                    { data: 'name', name: 'name' },
                    { data: 'section', name: 'section' },
                    { data: 'action', searchable: false, orderable: false }

                 ],
            language : {
              processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
            }
        });

      /*$(function() {
      $(".btn-area").append('<div class="col-sm-4 table-contents">'+
        '<a class="add-btn" href="{{route('admin-role-create')}}">'+
        '<i class="fas fa-plus"></i> {{ __("Add New Role") }}'+
        '</a>'+
        '</div>');
    }); */                    

</script>

@endsection   