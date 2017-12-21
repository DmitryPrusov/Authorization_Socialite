@extends('layout.main')

@section('content')
    <!-- modal_window -->
    <div id="overlay2" class="overlay2">
        <div class="authorisation_icons">
            <span id="close2" class="close2"></span>
            <h1>АВТОРИЗАЦІЯ</h1>
            <div class="golden-line">  </div>
            <p>УВІЙТИ ЧЕРЕЗ<br>СОЦІАЛЬНІ МЕРЕЖІ: </p>
            <div class="autorization-buttons">
                <div class="autorization-buttons-itm">
                    <a href="{{url('oauth/facebook')}}" class="autorization-btn">
                        <div class="autorization-btn-wrp">
                            <div class="autorization-btn-ico fb"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                            <div class="autorization-btn-lbl">Facebook</div>
                        </div>
                    </a>
                </div>
                <div class="autorization-buttons-itm">
                    <a href="{{url('oauth/google')}}" class="autorization-btn">
                        <div class="autorization-btn-wrp">
                            <div class="autorization-btn-ico gplus"><i class="fa fa-google-plus" aria-hidden="true"></i></div>
                            <div class="autorization-btn-lbl">Google+</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- modal_window -->

    <div class="inner">
        <div class="sec1-inner bg-black">
            <div class="cont-1280">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('home.page') }}">Головна</a></li>
                    <li> / Голосування</li>
                </ul>
                <h1>Голосування за номінанток “{{ $nomination->name }}”</h1>

                @if ($nomination->nominees->where('year', '2017')->where('active', 1)->count())
                    <div class="slider_for_wrapper">
                        <div class="golden-line"></div>
                        <div class="slider-for bg-broun">

                            @php
                                $i=0; $number = 0;
                            @endphp

                            @foreach($nomination->nominees->where('year', '2017')->where('active', 1) as $nominee)
                                @php
                                    if ($nominee->slug == $nomineeSlug) {
                                        $number = $i;
                                    }
                                @endphp

                                <div class="slide">
                                    <div class="table">
                                        <div class="table-cell nominee-img">
                                            <div class="img_wrapper">
                                                <img src="{{$nominee->getCroppedPhoto('list', 'norm')}}"/>
                                            </div>
                                            <div class="votesnumber">{{ $nominee->votes }} голосів</div>
                                            @if (!$nominee->isPossibleVote AND Auth::guard('social_user')->check())
                                                <div class="votesnumber">Ваш голос зараховано!</div>
                                            @elseif ($nominee->isPossibleVote AND Auth::guard('social_user')->check())
                                                <div class="btn-box">
                                                    <a class="vote rel" href="{{route('vote.authorized', [$nomination->id, $nominee->id])}}"><div class="vote-overlay"></div>Голосувати</a>
                                                </div>
                                            @else
                                                <div class="btn-box">
                                                    <button data-nomination="{{ $nomination->id }}" data-nominee="{{ $nominee->id }}" class="vote rel authorisation"><div class="vote-overlay"></div>Голосувати</button>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="table-cell nominee-desc">
                                            <h5>{{ $nominee->name }}</h5>
                                            <p>{{ $nominee->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        </div>
                    </div>
                @endif

                @include('includes.nominee-slider', ['nominees' => $nomination->nominees->where('year', '2017')->where('active', 1)])
            </div>
        </div>
        <div class="sec2-inner bg-white">
            <div class="cont-1280">
                <h1>Експерти номінації "{{ $nomination->name }}"</h1>
                @include('includes.s5-slider', ['experts' => $nomination->experts->where('year', '2017')->where('active', 1)])
                <div class="btn-box">
                    <div class="onethird">
                        <a class="vote" href="{{route('about.page')}}">
                            <div class="vote-overlay"></div>
                            Про премію</a>
                    </div>
                    <div class="onethird">
                        <a class="vote" href="{{route('experts.page')}}">
                            <div class="vote-overlay"></div>
                            Експерти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-footer')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.slider-for').slick({
                initialSlide: {{$number}},
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                adaptiveHeight: true,
                asNavFor: '.slider-nav'
            });
            $('.slider-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                asNavFor: '.slider-for',
                // dots: true,
                // centerMode: true,
                focusOnSelect: true,
                responsive: [
                    {
                        breakpoint: 980,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 2,
                        }
                    },
                    {
                        breakpoint: 780,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 580,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 360,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.s5-slider').slick({
                slidesToShow: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                adaptiveHeight: false,
                fade: true,
                cssEase: 'linear',
                arrows: true,
            });

            {{--@if (session('message'))--}}
{{--alert("{{ session('message') }}")--}}
            {{--@endif--}}
        })
    </script>
    <script type="text/javascript" src="{{asset('js/script.js')}}"></script>
@endsection

