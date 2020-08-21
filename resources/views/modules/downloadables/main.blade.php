
<h3>Folder Lists</h3>

<ul>
@foreach($downloadables as $downloadable)
<li><a href="/archives?folder={{$downloadable->directory_snake}}">{{$downloadable->directory}}</a></li>
@endforeach
</ul>