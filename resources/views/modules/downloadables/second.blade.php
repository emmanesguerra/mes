
<h3>Document Lists</h3> 
<p><small><a href="{{ route('download.archive') }}?folder={{$downloadables->directory_snake}}" class="text-danger">Download all documents</a> | <a href='{{ url()->previous() }}'>Go Back</a></small></p>

<ul>
@foreach($images as $image)
<li><a href="{{ $image->value }}"> {{ $image->title }} </a></li>
@endforeach
</ul>