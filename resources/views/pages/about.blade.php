@extends('layouts.app')

@section('content')
{{--    {{print_r($content)}}--}}
    <section class="pabout">
        <header style="background-image: url({{asset('img/about-head.jpg')}})">
            <div class="container">
                {!! $content['body'] ?? '' !!}
{{--                <p>Mytripline was founded in 2020. However, before this, the company had been securing the transport of people all around Europe. During that time we had satisfied clients and made contracts with international companies in order to provide the best possible experience during their journey’s.</p>--}}
            </div>
        </header>
        <div class="container pabout__wrap">
            <div class="pabout__grid">
                <h2>Meet the team</h2>
                <div class="pabout__grid-item"><i><img src="{{asset('img/user-1.jpg')}}" alt="Alexandra Gburova"></i>
                    <h4>Alexandra Gburova</h4><em>Blogger</em>
                    <p>Having graduated english bilingual school in Slovakia, this ambitious blogger, who already belongs to the best producers in Slovak film industry, joined our team. She is deeply into languages, travelling and possesses creative soul.</p>
                </div>
                <div class="pabout__grid-item"><i><img src="{{asset('img/user-2.jpg')}}" alt="Andriana Bentsa"></i>
                    <h4>Andriana Bentsa</h4><em>Chief Marketing Officer</em>
                    <p>After completing an intensive degree at Russian university in Perm, we enlarged our team by this chief of marketing, whose main goal is to manage international affairs with Russia. Furthermore it is a crucial person regards to social media involvement of our company. We feel honoured she forms our team.</p>
                </div>
                <div class="pabout__grid-item"><i><img src="{{asset('img/user-3.jpg')}}" alt="VOJTĚCH REINER"></i>
                    <h4>VOJTĚCH REINER</h4><em>Chief Operations Officer</em>
                    <p>I have 35 years of professional experience in tourism and I have worked on multiple positions in the field of hotel industry. Living and working in Tyrol  has brought me rich experience in international transport. Having worked for big or small firms, I am fully capable of providing accomodation, discount opportunities, usage of local services, cultural and gastronomy events for our guests. I would be pleased to organise a perfect trip in my area of living.</p>
                </div>
                <div class="pabout__grid-item"><i><img src="{{asset('img/user-4.jpg')}}" alt="Erik Lehuta"></i>
                    <h4>Erik Lehuta</h4><em>Chief Executive Officer</em>
                    <p>The founder of company MYTRIPLINE, who is determined to meet the highest possible satisfaction of every client as well as those of the partners. He came up with the algoritm that connects us all. He had been running a successful transfer company within the whole Europe. As time went by, the decision to globalize this idea was made.</p>
                </div>
            </div>
        </div>
        <div class="container pabout__footer"><img src="{{asset('img/about-group.jpg')}}" alt="about-group">
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
