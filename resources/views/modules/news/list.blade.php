@foreach($news as $new)
    <section>
        <h3><a href='{{ $new->category->slug }}/{{ $new->slug }}'>{{ $new->title }}</a></h3>
        <span class='date'>{{ date('M d Y', strtotime($new->created_at)) }}</span>
        <p>{{ $new->short_description }}</p>
        <span class='readmore'><a href='{{ $new->category->slug }}/{{ $new->slug }}'>Read More</a></span>
    </section>
@endforeach


