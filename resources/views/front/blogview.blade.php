@extends('layouts.front')

@section('content')
<div class="blog-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-content">
                    <div class="feature-image">
                        <img class="img-fluid" src="{{ asset('assets/images/blogimage/'.$blog->photo) }}" alt="">
                    </div>
                
                    <div class="contents">
                        <h3 class="title">
                            {{ $blog->title }}
                        </h3>
                        <ul class="post-meta p-0">
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="fa fa-calendar"></i> {{ date('d M, Y',strtotime($blog->created_at)) }}
                                </a>
                            </li>
                            @if(!empty($blog->author_name))
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="fa fa-user"></i> Post By : {{ $blog->author_name }}
                                </a>
                            </li>
                            @endif
                            @if(!empty($blog->source))
                            <li>
                                <a href="{{$blog->source}}" target="_blank">
                                    <i class="fa fa-link"></i> Source : {{ $blog->source }}
                                </a>
                            </li>
                            @endif
                        </ul>
                        {!! $blog->details !!}
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="blog-aside">
                    <div class="serch-form">
                        <!-- <form action="#">
                            <input type="text" name="search" placeholder="" required="">
                            <button type="submit"><i class="icofont-search"></i></button>
                        </form> -->
                    </div>
                    <div class="categori">
                        <h4 class="title">Categories</h4>
                        <span class="separator"></span>
                        <ul class="categori-list">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('front.blog.category',$category->id) }}" >
                                        <span>{{ $category->title }}</span>
                                        <span>{{ $category->blog_count }}</span>
                                    </a>
                                </li>
                            @endforeach        
                        </ul>
                    </div>
                    <div class="recent-post-widget">
                        <h4 class="title">Recent Post</h4>
                        <span class="separator"></span>
                        <ul class="post-list">
                        @foreach (App\Blog::orderBy('id', 'desc')->limit(4)->get() as $blog)
                        <li>
                        <div class="post">
                            <div class="post-img">
                            <img style="width: 73px; height: 59px;" src="{{ asset('assets/images/blogimage/'.$blog->photo) }}" alt="">
                            </div>
                            <div class="post-details">
                            <a href="{{ route('front.blog.view',$blog->id) }}">
                                <h4 class="post-title">
                                    {{mb_strlen($blog->title,'utf-8') > 45 ? mb_substr($blog->title,0,45,'utf-8')." .." : $blog->title}}
                                </h4>
                            </a>
                            <p class="date">
                                {{ date('M d - Y',(strtotime($blog->created_at))) }}
                            </p>
                            </div>
                        </div>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="tags">
                        <h4 class="title">Tags</h4>
                        <span class="separator"></span>
                        <ul class="tags-list">
                        @foreach($tags as $tag)
                            @if(!empty($tag))
                            <li>
                                <a href="{{ route('front.blog.tag',$tag) }}">{{ $tag }} </a>
                            </li>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection