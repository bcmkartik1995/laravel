@extends('layouts.load')
@section('content')

<section class="users-view">
  <!-- users view media object start -->
  <div class="row">
    <div class="col-12 col-sm-12">
      <div class="media mb-2">
        <a class="mr-1" href="javascript:void(0);">
          <img src="{{ $data->photo ? asset('assets/images/admins/'.$data->photo):asset('assets/images/noimage.png')}}" alt="users view avatar" class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>
        <div class="media-body pt-25">
          <h4 class="media-heading"><span class="users-view-name">{{$data->name}} </span></h4>
          <span>ID:</span>
          <span class="users-view-id">{{$data->id}}</span>
        </div>
      </div>
    </div>
  </div>
  <!-- users view media object ends -->
  <!-- users view card details start -->
  <div class="col-12">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td>{{ __("Staff Role") }}:</td>
              <td class="users-view-username">{{ $data->role_id == 0 ? 'No Role' : $data->role->name }}</td>
            </tr>
            <tr>
              <td>{{ __("Staff Email") }}:</td>
              <td class="users-view-name">{{$data->email}}</td>
            </tr>
            <tr>
              <td>{{ __("Staff Phone") }}:</td>
              <td class="users-view-email">{{$data->phone}}</td>
            </tr>
            <tr>
              <td>{{ __("Joined") }}:</td>
              <td>{{$data->created_at->diffForHumans()}}</td>
            </tr>

          </tbody>
        </table>
      </div>
  <!-- users view card details ends -->

</section>

@endsection