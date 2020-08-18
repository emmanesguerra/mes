<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>AeCMS</title>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/fontawesome-5.14.0-web/css/all.css') }}" rel="stylesheet">
        @yield('styles')
        @yield('javascripttop')
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        AeCMS
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                <div class="container">

                    @include('admin.layouts.common.leftsidebar')
                    
                    @yield('right-panel')

                    @yield('module-content')
                </div>
            </main>
        </div>

        @include('admin.layouts.common.footer')
        <div class="modal fade in" id="delete-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h4 class="modal-title">Danger!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <p>You are about to remove this record (<strong id="idtobedeleted"></strong>:<strong id="texttobedeleted"></strong>) in the system. Do you wish to continue?</p>

                        <form id="deletemodalform" method="POST" accept-charset="UTF-8" style="display:inline">
                            <input name="_method" type="hidden" value="DELETE">
                            @csrf
                            <input class="btn btn-outline text-danger" type="submit" value="Delete">
                        </form>
                        <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scripts -->

        <script src="{{ asset('js/admin/app.js') }}"></script>
        <script>
            var showdeletemodal = function (id, text, url) {
                $('#deletemodalform').attr('action', url)
                $('#idtobedeleted').html(id);
                $('#texttobedeleted').html(text);
                $('#delete-modal').modal('show');
            }
        </script>
        @yield('javascript')
            
        <script>
            $('.datatable tfoot th').each( function () {
                var title = $(this).text();
                if(title !== '') {
                    $(this).html( '<input type="text" class="form-control form-control-sm" placeholder="Search '+title+'" />' );
                }
            });

            if($.fn.dataTable) {
                $.extend( true, $.fn.dataTable.defaults, {
                    initComplete: function () {
                        // Apply the search
                        this.api().columns().every( function () {
                            var that = this;

                            $( 'input', this.footer() ).on( 'keyup change clear', function () {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            } );
                        } );
                    },
                    dom: "<'row'<'col-sm-12 col-md-6'l>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    "columnDefs": [{
                        "defaultContent": "-",
                        "targets": "_all"
                    }]
                });
            }
        </script>
    </body>
</html>
