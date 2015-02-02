{{--<a class="image-container" href="{{ route('home.offer', $offer->id) }}">--}}
<img src="{{{ $offer->image }}}">
</a>
<div class="caption">
    <h3>{{{ $offer->title }}}</h3>
    <hr>
    <p class="description">{{ $offer->webDescription() }}
        {{{ $offer->image }}}
    </p>
    <hr>
    <p><span class="label label-important">{{{ $offer->off }}} % off</span></p>
    <p>Город: <a href="{{ route('home.by_city', $offer->city->name) }}">{{{ $offer->city->name }}}</a></p>
    <p>Скидка от компании: <a href="{{ route('home.by_company', $offer->company->title) }}">{{{ $offer->company->title }}}</a></p>
    <p>До: <span class="label label-warning">{{{ $offer->expires }}}</span></p>
    <p>Тэги:
        @foreach($offer->tags as $tag)
            <a class="no_decoration" href="{{ route('home.by_tag', $tag->title) }}">
                <span class="badge">{{{$tag->title}}}</span>
            </a>
        @endforeach
        {{ link_to_route('home.offer', 'Подробнее...', array($offer->id), array('class' => 'btn btn-info', 'style' => 'float: right')) }}
    </p>

</div>