<!-- Dashboard -->
<section class="user-dashboard">
    <div class="dashboard-outer">
        <div class="upper-title-box">
        <h3>Selamat Datang, {{Auth::user()->nama}}!</h3>
        {{-- <div class="text">Ready to jump back in?</div> --}}
        </div>
        <div class="row">
        <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
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
        <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
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
        <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="ui-item ui-yellow">
            <div class="left">
                <i class="icon la la-building"></i>
            </div>
            <div class="right">
                <h4>{{$perusahaan}}</h4>
                <p>Perusahaan</p>
            </div>
            </div>
        </div>
        <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="ui-item ui-green">
            <div class="left">
                <i class="icon la la-user-tie"></i>
            </div>
            <div class="right">
                <h4>{{$pencari_kerja}}</h4>
                <p>Pencari Kerja</p>
            </div>
            </div>
        </div>
        </div>
    </div>
</section>
<!-- End Dashboard -->