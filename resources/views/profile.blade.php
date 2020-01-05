@extends('layouts.frontend.app')

@section('title','Profile')


@push('css')


    <link href=" {{ asset('assets/frontend/css/profile/styles.css') }} " rel="stylesheet">

    <link href=" {{ asset('assets/frontend/css/profile/responsive.css') }} " rel="stylesheet">


    <style>

        .favorite_post{
            color: red;
        }

    </style>

@endpush



@section('content')


    <div class="slider display-table center-text">
        <h1 class="title display-table-cell"><b style="color: #00E676;">{{ $author->name }}</b></h1>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="row">

                        @if( $posts->count() > 0 )

                            @foreach( $posts as $post )

                                <div class="col-md-6 col-sm-12">
                                    <div class="card h-100">


                                        <div class="single-post post-style-1">

                                            <div class="blog-image"><img src="{{ url('storage/post/'. $post->image) }}" alt="{{ $post->slug }}"></div>

                                            <a class="avatar" href="{{ route('author.profile',$post->user->username) }}"><img src="{{ url('storage/profile/'.$post->user->image) }}" alt="{{ $post->user->name }}"></a>

                                            <div class="blog-info">

                                                <h4 class="title"><a href="{{ route('post.details',$post->slug) }}"><b>{{ $post->title }}</b></a></h4>

                                                <ul class="post-footer">

                                                    <li>

                                                        @guest()

                                                            <a href="javascript:void(0);"
                                                               onclick="toastr.info('To add favorite list.You need to login first','Info',{

                                                               closeButton: true,
                                                               progressBar: true

                                                           })">
                                                                <i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>

                                                        @else

                                                            <a href="javascript:void(0);"

                                                               onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();"
                                                               class="{{ !Auth::user()->favorite_posts()
                                                        ->where('post_id',$post->id)-> count() == 0 ? 'favorite_post':''}}"
                                                            >

                                                                <i class="ion-heart"></i> {{ $post->favorite_to_users->count() }} </a>

                                                            <form id="favorite-form-{{ $post->id }}" method="POST"
                                                                  action="{{ route('post.favorite',$post->id) }}"
                                                                  style="display: none;">

                                                                {{ csrf_field() }}

                                                            </form>

                                                        @endguest


                                                    </li>
                                                    <li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
                                                    <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>

                                                </ul>

                                            </div><!-- blog-info -->
                                        </div><!-- single-post -->


                                    </div><!-- card -->
                                </div><!-- col-md-6 col-sm-12 -->

                            @endforeach

                        @else

                            <div class="col-lg-12 col-md-12">
                                <div class="card h-100">
                                    <div class="single-post post-style-1">


                                        <div class="blog-info">

                                            <h4 class="title" style="color: red;"> Sorry, No Post Found for this User :-
                                                <strong>{{ $author->name }}</strong>
                                            </h4>

                                        </div><!-- blog-info -->
                                    </div><!-- single-post -->
                                </div><!-- card -->
                            </div><!-- col-lg-4 col-md-6 -->

                        @endif

                    </div><!-- row -->



                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 ">

                    <div class="single-post info-area ">

                        <div class="about-area">
                            <h4 class="title"><b style="color: #0f74a8"> ABOUT AUTHOR </b></h4>
                            <p style="color: #00b0e4;">{{ $author->about }}</p>
                        </div>

                        <div class="about-area">
                            <h4 class="title"><b style="color: #0f74a8"> AUTHOR INFO </b></h4>

                            <p>
                                <span style="color: #00b0e4;"> NAME:- </span>
                                <span style="color: #00b0e4;"> {{ $author->name }} </span>

                            </p>

                            <p>
                                <span style="color: #00b0e4;">AUTHOR TOTAL POSTS:-</span>
                                <span style="color: #00b0e4;">{{ $posts->count() }}</span>
                            </p>

                            <p>
                                <span style="color: #00b0e4;"> AUTHOR SINCE:- </span>
                                <span style="color: #00b0e4;">{{ $author->created_at->toDateString() }}</span>

                            </p>

                        </div>


                        <div class="about-area">

                            <h4 class="title"><b style="color: #0f74a8"> AUTHOR IMAGE </b></h4>

                            <img class="img-responsive thumbnail"
                                 src="{{url('storage/profile/'. $author->image)}}" alt="">

                        </div>

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->

@endsection



@push('js')

@endpush
