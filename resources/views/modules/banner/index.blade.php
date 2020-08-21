<div id="banner" class="banner">
<div class="banner-container" style="background: url('{{ asset('/storage/pagebanner/'.$banner->image) }}') no-repeat {{ $banner->backgound_pos }}; background-size: 100%;">
    <div class="container">
        <div class="pagetitle">
            <h1>{{ $banner->title }}</h1>
            <p>{{ $banner->description }}</p>
        </div>
    </div>
</div>
</div>