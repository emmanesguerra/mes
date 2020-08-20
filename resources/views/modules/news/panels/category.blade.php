<div class="categories-panel col-md-12">
    <h3>News Categories</h3>
    <ul>
        @foreach($categories as $categ)
        <li><a href="/news/{{ $categ->slug }}">{{ $categ->name }} ({{ count($categ->news) }}) </a></li>
        @endforeach
    </ul>
</div>