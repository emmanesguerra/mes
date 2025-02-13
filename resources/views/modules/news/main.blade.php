<div class='aetinymce-content col-md-9'>
    <div class="newsheader">
        <h1>{{ $news->title }}</h1>
        <span class='date'><a href="/news/{{ $news->category->slug }}" style="font-size: 14px;">{{ $news->category->name }}</a> | {{ date('M d Y', strtotime($news->created_at)) }} {{ Carbon\Carbon::parse($news->created_at)->diffForHumans() }}</span>
        <small>by:</small> {{ $news->user->email }}
    </div>
    {!! $news->description !!}
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