@extends('layouts.app')

@section('content')
    <section class="pabout">
        <header style="background-image: url({{asset('img/about-head.jpg')}})">
            <div class="container">
                <div class="img-wrap">
                    {!! $content['body'] ?? '' !!}
                </div>
            </div>
        </header>
        <div class="container pabout__wrap">
            <div class="pabout__grid">
                <h2>Meet the team</h2>
                @foreach($content['team_response'] as $team)
                    <div class="pabout__grid-item"><i><img src="{{asset($team['image'])}}" alt="Alexandra Gburova"></i>
                        <h4>{{$team['title']}}</h4><em>{{$team['position']}}</em>
                        <p>
                            {!! $team['body'] !!}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container pabout__footer">
            <img class="pabout__footer-green-vector" src="{{asset('img/green-vector.png')}}" alt="green-vector">
            <img class="pabout__footer-blue-vector" src="{{asset('img/blue-vector.png')}}" alt="blue-vector">
            <img class="pabout__footer-center-img" src="{{asset('img/logo-fin2.png')}}" alt="logo-fin2">
            <img class="pabout__footer-red-vector" src="{{asset('img/red-vector.png')}}" alt="red-vector">
            <img class="pabout__footer-orange-vector" src="{{asset('img/orange-vector.png')}}" alt="orange-vector">
            <ul>
                <li><span>Green color</span><b class="--green">Autumn</b>
                    <p>Even the leaves left their comfort zone and fled after our departure. New beginning. Different perspective. No delays. This is your trip. This is your MYTRIPLINE.</p>
                </li>
                <li><span>Blue color</span><b class="--blue">Winter</b>
                    <p>Short daylight and hours and hours of darkness. Time to seek the sun. Bags in a car, seatbelt fastened. No days wasted.</p>
                </li>
                <li><span>Red color</span><b class="--red">Summer</b>
                    <p>We continue our journey and keep on chasing the red and bloody sun setting to remind us there are next days to be lived. It’s summer. Not one leaf left the tree. But we did.</p>
                </li>
                <li><span>Orange color</span><b class="--orange">Spring</b>
                    <p>Passing by picturesque landscapes, we stop to take a picture. Smile. These are your trips. Collect the memories. Seize the moment. Don’t be afraid to walk barefoot. It’s spring.</p>
                </li>
            </ul>
        </div>
    </section>
@endsection
