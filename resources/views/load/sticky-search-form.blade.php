<div class="sticky-search-form">
    <div>
        <input type="text" class=" {{!Session::has('location_search')?'service-search-alert':'service-search'}}" data-url={{route('front.service_search')}} placeholder="Search for services..." />
        <button><i class="fas fa-search"></i></button>
        <button><i class="far fa-times-circle"></i></button>
    </div>
</div>
