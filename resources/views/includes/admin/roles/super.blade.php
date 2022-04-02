<!-- Dashboard Start -->
            <li class="nav-item {{Route::is('admin.dashboard') ? 'active':''}}" ><a href="{{ route('admin.dashboard') }}"><i class="menu-livicon"
                            data-icon="desktop"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>
<!-- Dashboard End -->

<!-- Manage Users Start -->
            <li class=" navigation-header"><span>Manage Users</span>
            </li>
            @php
                $active_link = Route::is('admin-role-index')||Route::is('admin-role-index');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="settings"></i><span class="menu-title" data-i18n="Form Elements">{{ __('Manage Roles') }}</span></a>
                <ul class="menu-content">
                    <li class="nav-item {{Route::is('admin-role-index') ? 'active':''}}"><a href="{{ route('admin-role-index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">{{ __('Roles') }}</span></a>
                    </li>
                </ul>
            </li>
            @php
                $active_link = Route::is('admin-staff-index') || Route::is('users.index');
                $manage_staff_link = Route::is('admin-staff-index');
                $manage_customer_link = Route::is('users.index');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="Form Elements">Manage Users</span></a>
                <ul class="menu-content">
                    <li class="{{ $manage_staff_link ? 'active':''}}"><a href="{{ route('admin-staff-index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">{{ __('Manage Staffs') }}</span></a>
                    </li>
                    <li class="{{ $manage_customer_link ? 'active':''}}"><a href="{{ route('users.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">{{ __('Manage Customer') }}</span></a>
                    </li>
                </ul>
            </li>
            @php
                $active_link = Route::is('lead.index')||Route::is('lead.create')||Route::is('lead.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('lead.index') }}"><i class="menu-livicon"
                        data-icon="unlink"></i><span class="menu-title" data-i18n="Package">Lead</span></a>
            </li>
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
                    <li class="{{ $franchise_link ? 'active':''}}"><a href="{{ route('franchise-view') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Franchise</span></a>
                    </li>
                    <li class="{{ $franchise_user_link ? 'active':''}}"><a href="{{ route('franchise-user-view') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Franchise User</span></a>
                    </li>
                </ul>
            </li>

<!-- Manage Users End -->


<!-- Manage Service Start -->

            <li class=" navigation-header"><span>Manage Service</span></li>
            @php
                $active_link = Route::is('categories.index')||Route::is('categories.create')||Route::is('categories.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('categories.index') }}"><i class="menu-livicon"
                        data-icon="thumbnails-big"></i><span class="menu-title" data-i18n="Email">Category</span></a>
            </li>

            @php
                $active_link = Route::is('sub-categories.index')||Route::is('sub-categories.create')||Route::is('sub-categories.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('sub-categories.index') }}"><i class="menu-livicon"
                        data-icon="diagram"></i><span class="menu-title" data-i18n="sub-category">Sub
                        Category</span></a>
            </li>

            @php
                $active_link = Route::is('services.index')||Route::is('services.create')||Route::is('services.edit')||Route::is('best-service.index')||Route::is('best-service.create')||Route::is('best-service.edit')||Route::is('service_specification.index')||Route::is('service_specification.create')||Route::is('service_specification.edit')||Route::is('service_faq.index')||Route::is('service_faq.create')||Route::is('service_faq.edit');
                $service_link = Route::is('services.index')||Route::is('services.create')||Route::is('services.edit') || Route::is('service_specification.index')||Route::is('service_specification.create')||Route::is('service_specification.edit')||Route::is('service_faq.index')||Route::is('service_faq.create')||Route::is('service_faq.edit');
                $best_service_link = Route::is('best-service.index')||Route::is('best-service.create')||Route::is('best-service.edit');
            @endphp

            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="wrench"></i><span class="menu-title" data-i18n="Form Elements">Services</span></a>
                <ul class="menu-content">
                    <li class="{{ $service_link ? 'active':''}}"><a href="{{ route('services.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Services</span></a>
                    </li>
                    <li class="{{ $best_service_link ? 'active':''}}"><a href="{{ route('best-service.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Best Services</span></a>
                    </li>
                </ul>
            </li>

            @php
                $active_link = Route::is('package.index')||Route::is('package.create')||Route::is('package.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('package.index') }}"><i class="menu-livicon"
                        data-icon="grid"></i><span class="menu-title" data-i18n="Package">Package</span></a>
            </li>

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
                    <li class="{{ $order_link ? 'active':''}}"><a href="{{ route('orders-view') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Orders</span></a>
                    </li>
                    <li class="{{ $unallocated_order_link ? 'active':''}}"><a href="{{ route('unallocated-orders-view') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Unallocated Order</span></a>
                    </li>
                </ul>
            </li>
            <!-- order end -->

            @php
                $active_link = Route::is('offer.index')||Route::is('offer.create')||Route::is('offer.edit')||Route::is('best-offer.index')||Route::is('best-offer.create')||Route::is('best-offer.edit');
                $offer_link = Route::is('offer.index')||Route::is('offer.create')||Route::is('offer.edit');
                $best_offer_link = Route::is('best-offer.index')||Route::is('best-offer.create')||Route::is('best-offer.edit');
            @endphp

            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="divide-alt"></i><span class="menu-title" data-i18n="Form Elements">Offers</span></a>
                <ul class="menu-content">
                    <li class="{{ $offer_link ? 'active':''}}"><a href="{{ route('offer.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Offer</span></a>
                    </li>
                    <li class="{{ $best_offer_link ? 'active':''}}"><a href="{{ route('best-offer.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Best Offer</span></a>
                    </li>
                </ul>
            </li>


            @php
                $active_link = Route::is('gift-card.index')||Route::is('gift-card.create')||Route::is('gift-card.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('gift-card.index') }}"><i class="menu-livicon"
                        data-icon="gift"></i><span class="menu-title" data-i18n="Package">Gift</span></a>
            </li>

            @php
                $active_link = Route::is('service-rating.index')||Route::is('service-rating.create')||Route::is('service-rating.edit')||Route::is('package-rating.index')||Route::is('package-rating.create')||Route::is('package-rating.edit')||Route::is('order-review.index')||Route::is('order-review.create')||Route::is('order-review.edit')||Route::is('testimonial.index')||Route::is('testimonial.create')||Route::is('testimonial.edit');

                $service_rating_link = Route::is('service-rating.index')||Route::is('service-rating.create')||Route::is('service-rating.edit');
                $package_rating_link = Route::is('package-rating.index')||Route::is('package-rating.create')||Route::is('package-rating.edit');
                $order_review_link = Route::is('order-review.index')||Route::is('order-review.create')||Route::is('order-review.edit');
                $testimonial_link = Route::is('testimonial.index')||Route::is('testimonial.create')||Route::is('testimonial.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="star-half"></i><span class="menu-title" data-i18n="Form Elements">Rating</span></a>
                <ul class="menu-content">
                    <li class="{{ $service_rating_link ? 'active':''}}"><a href="{{ route('service-rating.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input">Service Rating</span></a>
                    </li>
                    <li class="{{ $package_rating_link ? 'active':''}}"><a href="{{ route('package-rating.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Package Rating</span></a>
                    </li>
                    <li class="{{ $order_review_link ? 'active':''}}"><a href="{{ route('order-review.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Order Review</span></a>
                    </li>
                    <li class="{{ $testimonial_link ? 'active':''}}"><a href="{{ route('testimonial.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Input Groups">Testimonial</span></a>
                    </li>
                </ul>
            </li>

<!-- Manage Service End -->

            
<!-- Account Start -->
            
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
            
<!-- Account End -->


<!--Payment Start -->

            @php
                $active_link = Route::is('payments.index')||Route::is('payments.create')||Route::is('payments.edit');
            @endphp
            <li class="navigation-header"><span>Payments</span>
            </li>
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('payments.index') }}"><i class="menu-livicon"
                        data-icon="credit-card-in"></i><span class="menu-title"
                        data-i18n="Package">Payments</span></a>
            </li>

            @php
                $active_link = Route::is('credit_plans.index')||Route::is('credit_plans.create')||Route::is('credit_plans.edit');
                $credit_plans_link = Route::is('credit_plans.index')||Route::is('credit_plans.create')||Route::is('credit_plans.edit');
                $franchise_custome_plans_link = Route::is('custome-plan.index')||Route::is('custome-plan.create')||Route::is('custome-plan.store');
            @endphp
            {{--<!-- <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('credit_plans.index') }}"><i class="menu-livicon" data-icon="credit-card-in"></i><span class="menu-title" data-i18n="sub-category">Credit Plans</span></a>
            </li> -->--}}
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="credit-card-in"></i><span class="menu-title"
                        data-i18n="Form Elements">Credit</span></a>
                <ul class="menu-content">
                    <li class="{{ $credit_plans_link ? 'active':''}}"><a href="{{ route('credit_plans.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                data-i18n="Input">Credit Plans</span></a>
                    </li>
                    <li class="{{ $franchise_custome_plans_link ? 'active':''}}"><a href="{{ route('custome-plan.index') }}"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Input Groups">Custome Plans</span></a>
                    </li>
                </ul>
            </li>

<!-- Payment End -->


<!--Manage Content Start -->

            <li class="navigation-header"><span>Manage Content</span></li>
            @php
                $active_link = Route::is('news-letter.index')||Route::is('news-letter.create')||Route::is('news-letter.edit');
            @endphp  
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('news-letter.index') }}"><i class="menu-livicon"
                        data-icon="list"></i><span class="menu-title" data-i18n="Package">News Letter</span></a>
            </li>
            @php
                $active_link = Route::is('slider.index')||Route::is('slider.create')||Route::is('slider.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('slider.index') }}"><i class="menu-livicon" data-icon="image"></i><span class="menu-title" data-i18n="sub-category">Slider</span></a>
            </li>

            @php
                $active_link = Route::is('referral-program.index')||Route::is('referral-program.create')||Route::is('referral-program.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('referral-program.index') }}"><i class="menu-livicon" data-icon="retweet"></i><span class="menu-title" data-i18n="sub-category">Referral Program</span></a>
            </li>

             @php
                $active_link = Route::is('request.index')||Route::is('request.followups');
                $request = Route::is('request.index');
                $followups = Route::is('request.followups');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="comment"></i><span class="menu-title"
                        data-i18n="Form Elements">Request Quotes</span></a>
                <ul class="menu-content">
                    <li class="{{ $request ? 'active':''}}"><a href="{{ route('request.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                data-i18n="Input">Requests</span></a>
                    </li>
                    <li class="{{ $followups ? 'active':''}}"><a href="{{ route('request.followups') }}"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Input Groups">Followups</span></a>
                    </li>
                </ul>
            </li>

    
            @php
                $active_link = Route::is('about.index')||Route::is('about.create')||Route::is('about.edit')||Route::is('blog.index')||Route::is('blog.create')||Route::is('blog.edit')||Route::is('contact.index')||Route::is('contact.create')||Route::is('contact.edit');
                $aboutus_link = Route::is('about.index')||Route::is('about.create')||Route::is('about.edit');
                $blog_link = Route::is('blog.index')||Route::is('blog.create')||Route::is('blog.edit');
                $contact_link = Route::is('contact.index')||Route::is('contact.create')||Route::is('contact.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="#"><i class="menu-livicon" data-icon="globe"></i><span class="menu-title"
                        data-i18n="Form Elements">Manage Pages</span></a>
                <ul class="menu-content">
                    <li class="{{ $aboutus_link ? 'active':''}}"><a href="{{ route('about.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                data-i18n="Input">About us</span></a>
                    </li>
                    <li class="{{ $blog_link ? 'active':''}}"><a href="{{ route('blog.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                data-i18n="Input">Blog</span></a>
                    </li>
                    <li class="{{ $contact_link ? 'active':''}}"><a href="{{ route('contact.index') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item"
                                data-i18n="Input">Contact us</span></a>
                    </li>
                </ul>
            </li>
            

<!-- Manage Content End -->


<!--Others Start -->
            <li class="navigation-header"><span>Others</span></li>
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
                    <li class="{{ $users_link ? 'active':''}}"><a href="{{ route('admin-gs-maintenance') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Number Input">{{ __('Website Maintenance') }}</span></a>
                    </li> -->--}}
                </ul>
            </li>
            <li>
                <a href="{{ route('admin-cache-clear') }}" class=" wave-effect"><i class="menu-livicon" data-icon="magic"></i><span class="menu-item" data-i18n="Input">{{ __('Clear Cache') }}</a>
            </li>

<!--Others End -->


            {{--<!-- @php
                $active_link = Route::is('franchises-assigned');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('franchises-assigned') }}"><i class="menu-livicon"
                        data-icon="check-alt"></i><span class="menu-title" data-i18n="Package">Franchises
                        Assigned</span></a>
            </li> -->--}}

            
            {{--<!-- @php
                $active_link = Route::is('franchise-order');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('franchise-order') }}"><i class="menu-livicon"
                        data-icon="check-alt"></i><span class="menu-title" data-i18n="Package">Franchise Orders</span></a>
            </li>

            @php
                $active_link = Route::is('franchises-service.index')||Route::is('franchises-service.create')||Route::is('franchises-service.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':''}}"><a href="{{ route('franchises-service.index') }}"><i class="menu-livicon"
                        data-icon="wrench"></i><span class="menu-title" data-i18n="Service">Franchises Service</span></a>
            </li>

            @php
                $active_link = Route::is('franchises-package.index')||Route::is('franchises-package.create')||Route::is('franchises-package.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('franchises-package.index') }}"><i class="menu-livicon"
                        data-icon="box-add"></i><span class="menu-title" data-i18n="Service">Franchises Packages</span></a>
            </li>

            @php
                $active_link = Route::is('franchises-offer.index')||Route::is('franchises-offer.create')||Route::is('franchises-offer.edit');
            @endphp
            <li class="nav-item {{ $active_link ? 'active':'' }}"><a href="{{ route('franchises-offer.index') }}"><i class="menu-livicon"
                    data-icon="divide-alt"></i><span class="menu-title" data-i18n="Service">Franchises Offer</span></a>
            </li> -->--}}

    
            {{--<!-- <li class="nav-item {{Route::is('admin-staff-index') ? 'active':''}}"><a href="{{ route('admin-staff-index') }}"><i class="menu-livicon" data-icon="unlink"></i><span class="menu-title" data-i18n="Email">{{ __('Manage Staffs') }}</span></a>
            </li>  -->--}}

            {{--<!-- <li class="nav-item {{Route::is('admin-role-index') ? 'active':''}}"><a href="{{ route('admin-role-index') }}"><i class="menu-livicon" data-icon="unlink"></i><span class="menu-title" data-i18n="Email">{{ __('Manage Roles') }}</span></a>
            </li> -->--}}
