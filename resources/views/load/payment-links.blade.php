@if(!empty($orders_pay_links))
    <div class="dropdown custom-header-link pay-sp">
        <a href="javascript:void(0);">
        <i class="fa fa-credit-card fa-lg" type="button" data-toggle="dropdown" aria-haspopup="true=" aria-expanded="false">  </i>
        <span class="badge badge-pill crt-dang">{{count($orders_pay_links)}}</span> </i>
        </a>
        <div class="dropdown-menu dropdown-menu-right payment-link-dropdown-menu dr-pay-ft ">
            @foreach ($orders_pay_links as $link)

                @php
                    $data_arr = [
                        'order_id' => $link['id']
                    ];
                    $data_string = json_encode($data_arr);
                    $error_message = null;
                    $encripted = Crypt::encryptString($data_string);
                    $pay_link = route('payment_link', ['hash' => $encripted]);

                    $title_array = [];
                    $image_path = null;
                    if(!empty($link['cart']['services'])){
                        foreach($link['cart']['services'] as $service){
                            $title_array[] = $service['title'];
                            if($image_path == null && isset($service['banner'])){
                                $image_path = asset('assets/images/servicebanner/'.$service['banner']);
                            }
                        }
                    }
                    if(!empty($link['unallocated']['services'])){
                        foreach($link['unallocated']['services'] as $service){
                            $title_array[] = $service['title'];
                            if($image_path == null && isset($service['banner'])){
                                $image_path = asset('assets/images/servicebanner/'.$service['banner']);
                            }
                        }
                    }
                    if(!empty($link['cart']['packages'])){
                        foreach($link['cart']['packages'] as $package){
                            foreach($package['package_service'] as $service){
                                $title_array[] = $service['title'];
                                if($image_path == null && isset($service['banner'])){
                                    $image_path = asset('assets/images/servicebanner/'.$service['banner']);
                                }
                            }
                        }
                    }
                    if(!empty($link['unallocated']['packages'])){
                        foreach($link['unallocated']['packages'] as $package){
                            foreach($package['package_service'] as $service){
                                $title_array[] = $service['title'];
                                if($image_path == null && isset($service['banner'])){
                                    $image_path = asset('assets/images/servicebanner/'.$service['banner']);
                                }
                            }
                        }
                    }

                @endphp
                <div class="row cart-detail">
                    <div class="col-lg-6 col-sm-8 col-8 cart-detail-product">
                        <p class="text-capitalize">{{$link['order_number']}}</p>
                        <span class="price "> {{implode(', ',$title_array)}}</span>
                    </div>
                        <div class="col-lg-6 col-sm-4 col-4 cart-detail-img">
                        <img src="{{$image_path}}">
                    </div>
                </div>
                <div class="row justify-content-center pt-2">
                    <div class="col-lg-6 col-sm-6 col-6 text-center checkout">
                        <a class="btn btn-crt-pay" href="{{$pay_link}}">Pay ₹{{$link['pay_amount']}}</a>
                    </div>
                </div>
                <div class="row justify-content-center pb-2 pt-2">
                    <div class="col-lg-11 col-sm-6 col-6 ">
                        <div class="bl-bd">
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>
@endif
