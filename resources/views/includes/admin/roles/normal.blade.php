@if(Auth::guard('admin')->user()->role_id != 0)

<!-- Dashboard Start -->
    <li class="nav-item {{Route::is('admin.dashboard') ? 'active':''}}" ><a href="{{ route('admin.dashboard') }}"><i class="menu-livicon"
    data-icon="desktop"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
    </li>
<!-- Dashboard End -->


<!-- Manage Users Start -->
    @if(Auth::guard('admin')->user()->sectionCheck('roles'))
        @php
            $active_link = Route::is('admin-role-index')||Route::is('admin-role-index');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="settings"></i><span class="menu-title" data-i18n="Form Elements">{{ __('Manage Roles') }}</span></a>
            <ul class="menu-content">
                <li class="nav-item {{Route::is('admin-role-index') ? 'active':''}}"><a href="{{ route('admin-role-index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">{{ __('Roles') }}</span></a>
                </li>
            </ul>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('manage_staffs') || Auth::guard('admin')->user()->sectionCheck('manage_customer'))
        @php
            $active_link = Route::is('admin-staff-index')||Route::is('users.index')||Route::is('users.create')||Route::is('users.edit');
            $manage_staff_link = Route::is('admin-staff-index');
            $manage_customer_link = Route::is('users.index')||Route::is('users.create')||Route::is('users.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="Form Elements">Manage Users</span></a>
            <ul class="menu-content">
            @if(Auth::guard('admin')->user()->sectionCheck('manage_staffs'))
                <li class="{{ $manage_staff_link ? 'active':''}}"><a href="{{ route('admin-staff-index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">{{ __('Manage Staffs') }}</span></a>
                </li>
            @endif
            @if(Auth::guard('admin')->user()->sectionCheck('manage_customer'))
                <li class="{{ $manage_customer_link ? 'active':''}}"><a href="{{ route('users.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">{{ __('Manage Customer') }}</span></a>
                </li>
            @endif
            </ul>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('leads'))
        @php
            $active_link = Route::is('lead.index')||Route::is('lead.create')||Route::is('lead.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('lead.index') }}"><i class="menu-livicon"
                    data-icon="unlink"></i><span class="menu-title" data-i18n="Package">Lead</span></a>
        </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('franchises') || Auth::guard('admin')->user()->sectionCheck('franchise_user'))
        @php
            $active_link = Route::is('franchise-view')||Route::is('franchise-edit')||Route::is('franchise-user-view');
            $franchise_link = Route::is('franchise-view')||Route::is('franchise-edit');
            $franchise_user_link = Route::is('franchise-user-view');
        @endphp
        {{--<!-- <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('franchise-view') }}"><i class="menu-livicon"
                    data-icon="building"></i><span class="menu-title" data-i18n="Package">Franchise</span></a>
        </li> -->--}}
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="building"></i><span class="menu-title" data-i18n="Form Elements">Manage Franchise</span></a>
            <ul class="menu-content">
            @if(Auth::guard('admin')->user()->sectionCheck('franchises'))
                <li class="{{ $franchise_link ? 'active':''}}"><a href="{{ route('franchise-view') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Franchise</span></a>
                </li>
            @endif
            @if(Auth::guard('admin')->user()->sectionCheck('franchise_user'))
                <li class="{{ $franchise_user_link ? 'active':''}}"><a href="{{ route('franchise-user-view') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Franchise User</span></a>
                </li>
            @endif
            </ul>
        </li>
    @endif

<!-- Manage Users End -->


<!-- Manage Service Start -->

    @if(Auth::guard('admin')->user()->sectionCheck('categories'))
        @php
            $active_link = Route::is('categories.index')||Route::is('categories.create')||Route::is('categories.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('categories.index') }}"><i class="menu-livicon"
                    data-icon="thumbnails-big"></i><span class="menu-title" data-i18n="Email">Category</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('sub_categories'))
        @php
            $active_link = Route::is('sub-categories.index')||Route::is('sub-categories.create')||Route::is('sub-categories.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('sub-categories.index') }}"><i class="menu-livicon"
                    data-icon="diagram"></i><span class="menu-title" data-i18n="sub-category">Sub
                    Category</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('services') || Auth::guard('admin')->user()->sectionCheck('best_services'))
        @php
            $active_link = Route::is('services.index')||Route::is('services.create')||Route::is('services.edit')||Route::is('services.index')||Route::is('services.create')||Route::is('services.edit')||Route::is('service_specification.index')||Route::is('service_specification.create')||Route::is('service_specification.edit')||Route::is('service_faq.index')||Route::is('service_faq.create')||Route::is('service_faq.edit');
            $service_link = Route::is('services.index')||Route::is('services.create')||Route::is('services.edit') || Route::is('service_specification.index')||Route::is('service_specification.create')||Route::is('service_specification.edit')||Route::is('service_faq.index')||Route::is('service_faq.create')||Route::is('service_faq.edit');
            $best_service_link = Route::is('best-service.index')||Route::is('best-service.create')||Route::is('best-service.edit');
        @endphp

        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="wrench"></i><span class="menu-title" data-i18n="Form Elements">Services</span></a>
            <ul class="menu-content">
            @if(Auth::guard('admin')->user()->sectionCheck('services'))
                <li class="{{ $service_link ? 'active':''}}"><a href="{{ route('services.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Services</span></a>
                </li>
            @endif
            @if(Auth::guard('admin')->user()->sectionCheck('best_services'))
                <li class="{{ $best_service_link ? 'active':''}}"><a href="{{ route('best-service.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Best Services</span></a>
                </li>
            @endif
            </ul>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('packages'))
        @php
            $active_link = Route::is('package.index')||Route::is('package.create')||Route::is('package.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('package.index') }}"><i class="menu-livicon"
                    data-icon="grid"></i><span class="menu-title" data-i18n="Package">Package</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('orders') || Auth::guard('admin')->user()->sectionCheck('unallocated_orders'))
        <!-- order start -->
        @php
            $active_link = Route::is('orders-view')||Route::is('orders-details')||Route::is('unallocated-orders-view')||Route::is('unallocated-orders-details');
            $order_link = Route::is('orders-view')||Route::is('orders-details');
            $unallocated_order_link = Route::is('unallocated-orders-view')||Route::is('unallocated-orders-details') || Route::is('unallocated-franchise-assign-order');
        @endphp
        <!-- <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('orders-view') }}"><i class="menu-livicon"
                    data-icon="shoppingcart-in"></i><span class="menu-title" data-i18n="Package">Orders</span></a>
        </li> -->
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="shoppingcart-in"></i><span class="menu-title" data-i18n="Form Elements">Orders</span></a>
            <ul class="menu-content">
            @if(Auth::guard('admin')->user()->sectionCheck('orders'))
                <li class="{{ $order_link ? 'active':''}}"><a href="{{ route('orders-view') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Orders</span></a>
                </li>
            @endif
            @if(Auth::guard('admin')->user()->sectionCheck('unallocated_orders'))
                <li class="{{ $unallocated_order_link ? 'active':''}}"><a href="{{ route('unallocated-orders-view') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Unallocated Order</span></a>
                </li>
            @endif
            </ul>
        </li>
        <!-- order end -->
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('offers') || Auth::guard('admin')->user()->sectionCheck('best_offers'))
        @php
            $active_link = Route::is('offer.index')||Route::is('offer.create')||Route::is('offer.edit')||Route::is('best-offer.index')||Route::is('best-offer.create')||Route::is('best-offer.edit');
            $offer_link = Route::is('offer.index')||Route::is('offer.create')||Route::is('offer.edit');
            $best_offer_link = Route::is('best-offer.index')||Route::is('best-offer.create')||Route::is('best-offer.edit');
        @endphp

        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="divide-alt"></i><span class="menu-title" data-i18n="Form Elements">Offers</span></a>
            <ul class="menu-content">
                @if(Auth::guard('admin')->user()->sectionCheck('offers'))
                    <li class="{{ $offer_link ? 'active':''}}"><a href="{{ route('offer.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Offer</span></a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->sectionCheck('best_offers'))
                    <li class="{{ $best_offer_link ? 'active':''}}"><a href="{{ route('best-offer.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Best Offer</span></a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('gifts'))
        @php
            $active_link = Route::is('gift-card.index')||Route::is('gift-card.create')||Route::is('gift-card.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('gift-card.index') }}"><i class="menu-livicon"
                    data-icon="gift"></i><span class="menu-title" data-i18n="Package">Gift</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('service_ratings') || Auth::guard('admin')->user()->sectionCheck('package_ratings') || Auth::guard('admin')->user()->sectionCheck('order_review') || Auth::guard('admin')->user()->sectionCheck('testimonial'))
        @php
            $active_link = Route::is('service-rating.index')||Route::is('service-rating.create')||Route::is('service-rating.edit')||Route::is('package-rating.index')||Route::is('package-rating.create')||Route::is('package-rating.edit')||Route::is('order-review.index')||Route::is('order-review.create')||Route::is('order-review.edit')||Route::is('testimonial.index')||Route::is('testimonial.create')||Route::is('testimonial.edit');

            $service_rating_link = Route::is('service-rating.index')||Route::is('service-rating.create')||Route::is('service-rating.edit');
            $package_rating_link = Route::is('package-rating.index')||Route::is('package-rating.create')||Route::is('package-rating.edit');
            $order_review_link = Route::is('order-review.index')||Route::is('order-review.create')||Route::is('order-review.edit');
            $testimonial_link = Route::is('testimonial.index')||Route::is('testimonial.create')||Route::is('testimonial.edit');
        @endphp
        <li class=" navigation-header"><span>Ratings</span>
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="star-half"></i><span class="menu-title" data-i18n="Form Elements">Rating</span></a>
            <ul class="menu-content">
                @if(Auth::guard('admin')->user()->sectionCheck('service_ratings'))
                    <li class="{{ $service_rating_link ? 'active':''}}"><a href="{{ route('service-rating.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Service Rating</span></a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->sectionCheck('package_ratings'))
                    <li class="{{ $package_rating_link ? 'active':''}}"><a href="{{ route('package-rating.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Package Rating</span></a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->sectionCheck('order_review'))
                    <li class="{{ $order_review_link ? 'active':''}}"><a href="{{ route('order-review.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Order Review</span></a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->sectionCheck('testimonial'))
                    <li class="{{ $testimonial_link ? 'active':''}}"><a href="{{ route('testimonial.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Testimonial</span></a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

<!-- Manage Service End -->

    
<!-- Account Start -->

    @if(Auth::guard('admin')->user()->sectionCheck('accounts'))
        @php
            $active_link = Route::is('income')||Route::is('franchise_fees')||Route::is('franchise_outstanding');
            $income_link = Route::is('income');
            $franchise_fees = Route::is('franchise_fees');
            $franchise_outstanding = Route::is('franchise_outstanding');
        @endphp
        <li class=" navigation-header"><span>Accounts</span>
        </li>
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="calculator"></i><span class="menu-title"
                    data-i18n="Form Elements">Accounts</span></a>
            <ul class="menu-content">

                    <li class="{{ $income_link ? 'active':''}}"><a href="{{ route('income') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                data-i18n="Input">Income</span></a>
                    </li>
                    <li class="{{ $franchise_fees ? 'active':''}}"><a href="{{ route('franchise_fees') }}"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Input Groups">Franchise Fees</span></a>
                    </li>

                    <li class="{{ $franchise_outstanding ? 'active':''}}"><a href="{{ route('franchise_outstanding') }}"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Number Input">Franchise Outstanding</span></a>
                    </li>

            </ul>
        </li>
    @endif

<!-- Account End -->

    
<!--Payment Start -->

    @if(Auth::guard('admin')->user()->sectionCheck('payments'))
        @php
            $active_link = Route::is('payments.index')||Route::is('payments.create')||Route::is('payments.edit');
        @endphp
        <li class=" navigation-header"><span>Payments</span>
        </li>
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('payments.index') }}"><i class="menu-livicon"
                    data-icon="credit-card-in"></i><span class="menu-title"
                    data-i18n="Package">Payments</span></a>
        </li>
    @endif

    {{--<!-- @if(Auth::guard('admin')->user()->sectionCheck('credit_plans'))
        @php
            $active_link = Route::is('credit_plans.index')||Route::is('credit_plans.create')||Route::is('credit_plans.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('credit_plans.index') }}"><i class="menu-livicon" data-icon="credit-card-in"></i><span class="menu-title" data-i18n="sub-category">Credit Plans</span></a>
        </li>
    @endif -->--}}

    @if(Auth::guard('admin')->user()->sectionCheck('credit_plans') || Auth::guard('admin')->user()->sectionCheck('custome_plans'))
        @php
            $active_link = Route::is('credit_plans.index')||Route::is('credit_plans.create')||Route::is('credit_plans.edit');
            $credit_plans_link = Route::is('credit_plans.index')||Route::is('credit_plans.create')||Route::is('credit_plans.edit');
            $franchise_custome_plans_link = Route::is('custome-plan.index')||Route::is('custome-plan.create')||Route::is('custome-plan.store');
        @endphp

        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="credit-card-in"></i><span class="menu-title"
                            data-i18n="Form Elements">Credit</span></a>
            <ul class="menu-content">
            @if(Auth::guard('admin')->user()->sectionCheck('credit_plans'))
                <li class="{{ $credit_plans_link ? 'active':''}}"><a href="{{ route('credit_plans.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                            data-i18n="Input">Credit Plans</span></a>
                </li>
            @endif
            @if(Auth::guard('admin')->user()->sectionCheck('custome_plans'))
                <li class="{{ $franchise_custome_plans_link ? 'active':''}}"><a href="{{ route('custome-plan.index') }}"><i class="bx bx-right-arrow-alt"></i><span
                            class="menu-item" data-i18n="Input Groups">Custome Plans</span></a>
                </li>
            @endif
            </ul>
        </li>
    @endif

<!-- Payment End -->
    

<!--Manage Content Start -->
    @if(Auth::guard('admin')->user()->sectionCheck('news_letter'))
        @php
            $active_link = Route::is('news-letter.index')||Route::is('news-letter.create')||Route::is('news-letter.edit');
        @endphp  
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('news-letter.index') }}"><i class="menu-livicon"
                    data-icon="list"></i><span class="menu-title" data-i18n="Package">News Letter</span></a>
        </li>
    @endif    

    @if(Auth::guard('admin')->user()->sectionCheck('slider_list'))
        @php
            $active_link = Route::is('slider.index')||Route::is('slider.create')||Route::is('slider.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('slider.index') }}"><i class="menu-livicon" data-icon="image"></i><span class="menu-title" data-i18n="sub-category">Slider</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('referral_program'))
        @php
            $active_link = Route::is('referral-program.index')||Route::is('referral-program.create')||Route::is('referral-program.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('referral-program.index') }}"><i class="menu-livicon" data-icon="retweet"></i><span class="menu-title" data-i18n="sub-category">Referral Program</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('request_quotes') || Auth::guard('admin')->user()->sectionCheck('followups'))
        @php
            $active_link = Route::is('request.index')||Route::is('request.followups');
            $request = Route::is('request.index');
            $followups = Route::is('request.followups');
        @endphp
        </li>
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="comment"></i><span class="menu-title"
                    data-i18n="Form Elements">Request Quotes</span></a>
            <ul class="menu-content">
                @if(Auth::guard('admin')->user()->sectionCheck('request_quotes'))
                    <li class="{{ $request ? 'active':''}}"><a href="{{ route('request.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                data-i18n="Input">Requests</span></a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->sectionCheck('followups'))
                    <li class="{{ $followups ? 'active':''}}"><a href="{{ route('request.followups') }}"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Input Groups">Followups</span></a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    {{--<!-- @if(Auth::guard('admin')->user()->sectionCheck('request_list'))
        @php
            $active_link = Route::is('request.index')||Route::is('request.create')||Route::is('request.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('request.index') }}"><i class="menu-livicon" data-icon="image"></i><span class="menu-title" data-i18n="sub-category">Request quotes</span></a>
        </li>
    @endif -->--}}


    @if(Auth::guard('admin')->user()->sectionCheck('about_us') || Auth::guard('admin')->user()->sectionCheck('blog') || Auth::guard('admin')->user()->sectionCheck('contact_list'))
        @php
            $active_link = Route::is('about.index')||Route::is('about.create')||Route::is('about.edit')||Route::is('blog.index')||Route::is('blog.create')||Route::is('blog.edit')||Route::is('contact.index')||Route::is('contact.create')||Route::is('contact.edit');
            $aboutus_link = Route::is('about.index')||Route::is('about.create')||Route::is('about.edit');
            $blog_link = Route::is('blog.index')||Route::is('blog.create')||Route::is('blog.edit');
            $contact_link = Route::is('contact.index')||Route::is('contact.create')||Route::is('contact.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="globe"></i><span class="menu-title"
                    data-i18n="Form Elements">Manage Pages</span></a>
            <ul class="menu-content">
                @if(Auth::guard('admin')->user()->sectionCheck('about_us'))
                    <li class="{{ $aboutus_link ? 'active':''}}"><a href="{{ route('about.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                data-i18n="Input">About us</span></a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->sectionCheck('blog'))
                    <li class="{{ $blog_link ? 'active':''}}"><a href="{{ route('blog.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                    data-i18n="Input">Blog</span></a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->sectionCheck('contact_list'))
                    <li class="{{ $contact_link ? 'active':''}}"><a href="{{ route('contact.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                data-i18n="Input">Contact us</span></a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

<!-- Manage Content End -->

<!--Others Start -->

    @if(Auth::guard('admin')->user()->sectionCheck('general_settings'))
        @php
            $active_link = Route::is('admin-gs-logo')||Route::is('admin-gs-contents')||Route::is('admin-gs-maintenance');
            $permissions_link = Route::is('admin-gs-logo');
            $roles_link = Route::is('admin-gs-contents');
            $users_link = Route::is('admin-gs-maintenance');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="gears"></i><span class="menu-title" data-i18n="Form Elements">{{ __('General Settings') }}</span></a>
            <ul class="menu-content">
                <li class="{{ $permissions_link ? 'active':''}}"><a href="{{ route('admin-gs-logo') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">{{ __('Logo') }}</span></a>
                </li>
                {{--<!-- <li class="{{ $roles_link ? 'active':''}}"><a href="{{ route('admin-gs-contents') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">{{ __('Website Contents') }}</span></a>
                </li>
                <li class="{{ $users_link ? 'active':''}}"><a href="{{ route('admin-gs-maintenance') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Number Input">{{ __('Website Maintenance') }}</span></a> -->--}}
                </li>
            </ul>
        </li>
    @endif

<!--Others End -->


<!--Franchise Module Start -->

    @if(Auth::guard('admin')->user()->sectionCheck('franchise_orders') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('franchise-order');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('franchise-order') }}"><i class="menu-livicon"
                    data-icon="shoppingcart-in"></i><span class="menu-title" data-i18n="Package">Franchise Orders</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('franchise_services') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('franchises-service.index')||Route::is('franchises-service.create')||Route::is('franchises-service.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('franchises-service.index') }}"><i class="menu-livicon"
                    data-icon="wrench"></i><span class="menu-title" data-i18n="Service">Franchises Service</span></a>
        </li>
    @endif

    {{--<!-- @if(Auth::guard('admin')->user()->sectionCheck('franchise_packages') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('franchises-package.index')||Route::is('franchises-package.create')||Route::is('franchises-package.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('franchises-package.index') }}"><i class="menu-livicon"
                    data-icon="grid"></i><span class="menu-title" data-i18n="Service">Franchises Packages</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('franchise_offers') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('franchises-offer.index')||Route::is('franchises-offer.create')||Route::is('franchises-offer.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('franchises-offer.index') }}"><i class="menu-livicon"
                data-icon="divide-alt"></i><span class="menu-title" data-i18n="Service">Franchises Offer</span></a>
        </li>
    @endif -->--}}

    @if(Auth::guard('admin')->user()->sectionCheck('franchise_timing') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('franchises-timing.index')||Route::is('franchises-timing.create')||Route::is('franchises-timing.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('franchises-timing.index') }}"><i class="menu-livicon"
                data-icon="calendar"></i><span class="menu-title" data-i18n="Service">Franchises Timing</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('franchise_worker') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('franchises-worker.index')||Route::is('franchises-worker.create')||Route::is('franchises-worker.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('franchises-worker.index') }}"><i class="menu-livicon"
                data-icon="legal"></i><span class="menu-title" data-i18n="Service">Franchises Worker</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('franchise_credits') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('franchise_credits.index');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('franchise_credits.index') }}"><i class="menu-livicon"
                data-icon="credit-card-in"></i><span class="menu-title" data-i18n="Service">Manage Credit</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('franchise_profile') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('franchises-profile.index')||Route::is('franchises-profile.create')||Route::is('franchises-profile.edit');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('franchises-profile.index') }}"><i class="menu-livicon"
                data-icon="user"></i><span class="menu-title" data-i18n="Service">Franchise Profile</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('request_list') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('request.index');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('request.index') }}"><i class="menu-livicon"
                data-icon="calendar"></i><span class="menu-title" data-i18n="Service">Request quotes</span></a>
        </li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('franchise_account') && Auth::guard('admin')->user()->hasFranchise() == true)
        @php
            $active_link = Route::is('franchises-account');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('franchises-account') }}"><i class="menu-livicon"
                data-icon="calculator"></i><span class="menu-title" data-i18n="Service">Account</span></a>
        </li>
    @endif

<!--Franchise Module End -->

    {{--<!-- @if(Auth::guard('admin')->user()->sectionCheck('franchise_assigned'))
        @php
            $active_link = Route::is('franchises-assigned');
        @endphp
        <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('franchises-assigned') }}"><i class="menu-livicon"
                    data-icon="check-alt"></i><span class="menu-title" data-i18n="Package">Franchises
                    Assigned</span></a>
        </li>
    @endif -->--}}

@endif
