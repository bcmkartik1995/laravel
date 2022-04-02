@extends('layouts.front')

@section('content')


<div class="blogpagearea">
    <div class="container">
        <div class="bg-white rounded sd">
        @if(count($blogs) > 0)
            <div class="row">
                @foreach($blogs as $blogg)
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-box shadow-md">
                            <div class="blog-images">
                                <div class="img">
                                    {{-- <img src="https://images.pexels.com/photos/210186/pexels-photo-210186.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" /> --}}
                                <img src="{{ ($blogg->photo ? asset('assets/images/blogimage/'.$blogg->photo) : asset('assets/front-assets/images/noimage.png')) .'?auto=compress&cs=tinysrgb&dpr=1&w=10' }}" class="img-fluid" alt="">
                                <div class="date d-flex justify-content-center">
                                    <p>{{date('d', strtotime($blogg->created_at))}}</p>
                                    <p>{{date('M', strtotime($blogg->created_at))}}</p>
                                </div>
                                </div>
                            </div>
                            <div class="details">
                                <a href="{{ route('front.blog.view',$blogg->id) }}">
                                <h4 class="blog-title">
                                    {{mb_strlen($blogg->title,'utf-8') > 50 ? mb_substr($blogg->title,0,50,'utf-8')."...":$blogg->title}}
                                </h4>
                                </a>
                            <p class="blog-text">
                                {!! substr(strip_tags($blogg->details),0,120) !!}
                            </p>
                            <a class="read-more-btn" href="{{ route('front.blog.view',$blogg->id) }}">{{ $langg->lang38 }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="blog-page-center">
                {!! $blogs->links() !!}
            </div>
            @else
                <P class="no-blog">No Blog On this Category</P>
            @endif
        </div>
    </div>
</div>


@endsection

@section('scripts')

@endsection
