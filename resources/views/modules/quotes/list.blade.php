@foreach($quotes as $quote)
    <section>
        <h2>"{{ $quote->title }}"</h2>
        <br />
        <p>{{ $quote->description }}</p>
    </section>
@endforeach