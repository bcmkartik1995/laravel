<div class="location-search">
    <form id="frm-set-header-location" action="{{ route('location.set_location_session') }}" method="post">
        {{csrf_field()}}
        @php
            $location_search = old('location_search');
            $lat = old('lat');
            $lng = old('lng');
            $country = old('country');
            $city = old('city');
            $zip = old('zip');
            $state = old('state');
            if(Session::has('location_search')){
                $location_search_arr = Session::get('location_search');
                $location_search = $location_search_arr['location_search'];
                $lat = $location_search_arr['lat'];
                $lng = $location_search_arr['lng'];
                $country = $location_search_arr['country'];
                $city = $location_search_arr['city'];
                $zip = $location_search_arr['zip'];
                $state = $location_search_arr['state'];
            }

        @endphp
        <input type="text" placeholder="Enter Location" name="location_search" id="header_location_search" value="{{$location_search}}"/>
        <input type="hidden" name="lat" id="header_lat" value="{{$lat}}">
        <input type="hidden" name="lng" id="header_lng" value="{{$lng}}">
        <input type="hidden" name="country" id="header_country" value="{{$country}}">
        <input type="hidden" name="city" id="header_city" value="{{$city}}">
        <input type="hidden" name="state" id="header_state" value="{{$state}}">
        <input type="hidden" name="zip" id="header_zip" value="{{$zip}}">
        <input type="hidden" name="is_header_search" value="1">
        <button type="button" class="btn-header-search-location cursor-pointer"><i class="fas fa-map-marker-alt"></i></button>
    </form>
</div>
