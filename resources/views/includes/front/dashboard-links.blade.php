<ul class="links">
    <li class="{{Route::is('user-dashboard')?'active':''}}">
    <a href="{{route('user-dashboard')}}">
      Dashboard
    </a>
  </li>
  <li class="{{Route::is('user-orders')?'active':''}}">
    <a href="{{route('user-orders')}}">
      Order History
    </a>
  </li>
  <li class="{{Route::is('user-ongoingorders')?'active':''}}">
        <a href="{{route('user-ongoingorders')}}">
            Ongoing Order
        </a>
  </li>
  <li class="{{Route::is('user-order-track')?'active':''}}">
      <a href="{{route('user-order-track')}}">Order Tracking</a>
  </li>
  <li class="{{Route::is('user-profile')?'active':''}}">
        <a href="{{route('user-profile')}}">
            Edit Profile
        </a>
  </li>

  <li class="{{Route::is('resetform')?'active':''}}">
        <a href="{{route('resetform')}}">
            Reset Password
        </a>
  </li>

  <li>
    <a href="{{route('user-logout')}}">
      Logout
    </a>
  </li>

</ul>
