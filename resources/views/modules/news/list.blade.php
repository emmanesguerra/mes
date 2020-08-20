@foreach($news as $new)
    <section>
        <h3><a href='/news/{{ $new->category->slug }}/{{ $new->slug }}'>{{ $new->title }}</a></h3>
        <span class='date'><a href="/news/{{ $new->category->slug }}" style="font-size: 14px;">{{ $new->category->name }}</a> | {{ date('M d Y', strtotime($new->created_at)) }} | {{ Carbon\Carbon::parse($new->created_at)->diffForHumans() }}</span>
        <p>{{ $new->short_description }}</p>
        <span class='readmore'><a href='/news/{{ $new->category->slug }}/{{ $new->slug }}'>Read More</a></span>
    </section>
@endforeach