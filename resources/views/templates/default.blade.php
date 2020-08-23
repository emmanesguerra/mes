<div class="topnav">
    <div class="container">
        <div class="row">
            <div class="col-md-7 mt-3 mb-0 my-md-3">
                <span class="d-block d-sm-inline mb-2 mr-5"><i class="far fa-envelope-open mr-2"> </i>sample.email@gmail.com</span>
                <span class="d-block d-sm-inline"><i class="fas fa-phone-alt mr-2"> </i>+63 909 1234 567</span>
                </div>
            <div class="col-md-5 mb-3 mt-2 my-md-3">
                {!! $TopLinks !!}
            </div>
        </div>
    </div>
</div>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-10 col-lg-5 my-3 pr-0">
                <a class="logo" href="/">
                    <img class="float-left float-sm-none mr-1" src="/images/logo2.png" alt="Malaya Elementary School" title="Malaya Elementary School" />
                    <span class="float-left float-sm-none my-2 my-sm-0"><span class="d-block d-sm-inline mb-2 mb-sm-0">Malaya Elementary</span> School</span>
                </a>
            </div>
            <div class="col-2 col-lg-7 my-3 px-0 px-sm-3">
                <nav class="p-0 py-2 navbar navbar-expand-lg navbar-light">
                    <button  onclick="openNav()" class="navbar-toggler" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div id="mainnav"  class="d-none d-lg-block collapse navbar-collapse">
                        {!! $HeaderNav !!}
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    {!! $SidebarNav !!}
</div>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
{!! $Banner !!}
<div class="forthrow mb-0 mb-sm-5">
    <div class="container">
        <div class="row">
            <div class="box col-md-12 pb-0 pb-sm-5">
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