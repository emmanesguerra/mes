<div class="topnav">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 my-3">
                <span class="mr-5"><i class="far fa-envelope-open mr-2"> </i>sample.email@gmail.com</span>
                <span><i class="fas fa-phone-alt mr-2"> </i>+63 909 1234 567</span>
            </div>
            <div class="col-sm-6 my-3">
                {!! $TopLinks !!}
            </div>
        </div>
    </div>
</div>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 my-3">
                <a class="logo" href="/">
                    <img src="/images/logo2.png" alt="Malaya Elementary School" title="Malaya Elementary School" />
                    <span><span>Malaya Elementary</span> School</span>
                </a>
            </div>
            <div class="col-sm-8 my-3">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainnav" aria-controls="mainnav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div id="mainnav"  class="collapse navbar-collapse">
                        {!! $HeaderNav !!}
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
{!! $Banner !!}
<div class="forthrow mb-5">
    <div class="container">
        <div class="row">
            <div class="box col-md-12 pb-5">
                <div class='row my-3'>
                    <div class='aetinymce-content col-md-9'>
                        {!! $Main !!}
                    </div>
                    <div class='col-md-3'>
                        <div class="row">
                            <div class='quicklinks col-md-12'>
                                <h3>Quicklinks</h3>
                                {!! $Quicklinks !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class='row'>
            <div class='col-md-12'>
                <span>&COPY; Malaya Elementary School 2020. All Right Reserved</span>
                <span>Website by <a href='#'>AeServices</a></span>
            </div>
        </div>
    </div>
</footer>