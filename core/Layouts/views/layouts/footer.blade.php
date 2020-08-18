
        @foreach($page->javascripts as $js)
        <script type="text/javascript" src="{{ asset('js/templates/' . $js) }}"></script>
        @endforeach
    </body>
</html>
