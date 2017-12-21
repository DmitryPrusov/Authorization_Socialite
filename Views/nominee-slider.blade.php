@if($nominees->count())
    <div class="for_slider_nav">
        <div class="vote-line">
            <div class="slider-nav">

                @foreach($nominees as $nominee)
                    <div class="slide">
                        <div class="nominee-vote-line">
                            <img src="{{$nominee->getCroppedPhoto('slider', 'norm')}}" alt="6">
                            <div class="nominee-overlay-vote-line">
                                <p>{{$nominee->name}}<br>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif