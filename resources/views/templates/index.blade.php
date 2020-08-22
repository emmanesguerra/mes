<div class="topnav">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 my-3">
                <span class="mr-5"><i class="far fa-envelope-open mr-2"> </i>emman.esguerra2013@gmail.com</span>
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
<div id="banner" class="banner">
    <div class="banner-container">
        <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                {!! $Sliders !!}
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
<div class="forthrow">
    <div class="container">
        <div class="row">
            <div class="box col-md-12 pb-5">
                <div class='row my-3'>
                    <div class='col-md-3 my-2'>
                        <h3><i class='fas fa-door-open'></i> Accommodating</h3>
                        <p>Helping community</p>
                    </div>
                    <div class='col-md-3 my-2'>
                        <h3><i class='fas fa-graduation-cap'></i>  Graduation</h3> 
                        <p>Teaching leaders</p>
                    </div>
                    <div class='col-md-3 my-2'>
                        <h3><i class='fas fa-award'></i> Awards</h3>
                        <p>Thriving success</p>
                    </div>
                    <div class='col-md-3 my-2'>
                        <h3><i class='fas fa-trophy'></i> Trophy</h3>
                        <p>Building Champions</p>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6 p-3'>
                        {!! $SloganImage !!}
                    </div>
                    <div class='col-md-6 p-3'>
                        {!! $SloganMsg !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fifthrow">
    <div class="container">
        <div class='row'>
            <div class='col-md-4 p-5 text-center' style='position: relative'>
                <div class='mes sticky-top'>
                    <h2>Malaya Elementary School Quote</h2>
                    <img src='/images/logo2.png' class='m-3' />
                </div>
            </div>
            <div class='quotes col-md-8 p-5'>
                {!! $Quotes !!}
            </div>
        </div>
    </div>
</div>
<div class="sixthrow">
    <div class="container">
        <div class='row'>
            <div class='newscontainer col-md-8'>
                <h2>News and Updates</h2>
                <div class='newslistcontainer'>
                    {!! $NewsLists !!}
                </div>
            </div>
            <div class='subscribe col-md-4'>
                {!! $NewsletterSignup !!}
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