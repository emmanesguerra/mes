@foreach($sliders as $slider)
    <div class="swiper-slide" style="background: url('{{ asset('/storage/sliders/'.$slider->image) }}') no-repeat {{ $slider->backgound_pos }}; background-size: 100%;">
        @if(!empty($slider->title) || !empty($slider->description))
        <div class="container">
            <span class="slider-msg"  style="{{ ($slider->text_pos1 == 'top') ? 'top: 30px;': 'bottom: 100px;' }} {{ ($slider->text_pos2 == 'lft') ? 'left': 'right' }}: 0px; ">
                @if(!empty($slider->title))
                <span class="slidetitle">{{ $slider->title }}</span>
                @endif
                @if(!empty($slider->description))
                <p>{{ $slider->description }}</p>
                @endif
                @if(!empty($slider->link))
                <a href="{{ $slider->link }}" class="readmore" target="_blank">Read more &raquo;</a>
                @endif
            </span>
        </div>
        @endif
    </div>
@endforeach