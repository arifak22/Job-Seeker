<!-- Dashboard -->
<section class="user-dashboard">
    <div class="dashboard-outer">
        <div class="upper-title-box">
        <h3>Selamat Datang, {{Auth::user()->nama}}!</h3>
        {{-- <div class="text">Ready to jump back in?</div> --}}
        </div>
        <div class="row">
            <div class="ui-block col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="ui-item">
                <div class="left">
                    <i class="icon flaticon-briefcase"></i>
                </div>
                <div class="right">
                    <h4>{{$loker}}</h4>
                    <p>Lowongan Kerja</p>
                </div>
                </div>
            </div>
            <div class="ui-block col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="ui-item ui-red">
                <div class="left">
                    <i class="icon la la-file-invoice"></i>
                </div>
                <div class="right">
                    <h4>{{$lamaran}}</h4>
                    <p>Lamaran Kerja</p>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Dashboard -->