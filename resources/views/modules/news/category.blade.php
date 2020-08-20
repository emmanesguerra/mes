<div class='aetinymce-content col-md-9'>
    <div class="newsheader">
        <h1>{{ $category->name }}</h1>
    </div>
    <div class='newslistcontainer' style="max-height: none">
        @foreach($news as $new)
        <section>
            <h3><a href='/news/{{ $new->category->slug }}/{{ $new->slug }}'>{{ $new->title }}</a></h3>
            <span class='date'>{{ date('M d Y', strtotime($new->created_at)) }} | {{ Carbon\Carbon::parse($new->created_at)->diffForHumans() }}</span>
            <p>{{ $new->short_description }}</p>
            <span class='readmore'><a href='/news/{{ $new->category->slug }}/{{ $new->slug }}'>Read More</a></span>
        </section>
        @endforeach
    </div>
    <div style="float:left; width: 100%;">
        {{ $news->onEachSide(0)->links() }}
    </div>
</div>
<div class='col-md-3'>
    <div class='row'>
    {!! $categoryLists !!}
    
        <div class='quicklinks col-md-12'>
            <h3>Quicklinks</h3>
            {!! $quicklinks !!}
        </div>
    </div>
</div>