<?php
// echo "<pre>";
// echo Auth::user()->status;
// print_r($menus);
// die();
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8">
  <title>SIAPNARI | Sistem Aplikasi Tenaga Kerja & Perindustrian</title>

  <!-- Stylesheets -->
  <link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet">
  <link href="{{url('assets/css/style.css')}}" rel="stylesheet">
  <link href="{{url('assets/css/responsive.css')}}" rel="stylesheet">

  <link rel="shortcut icon" href="{{url('assets/master/images/icon.png')}}" type="image/x-icon">
  <link rel="icon" href="{{url('assets/master/images/icon.png')}}" type="image/x-icon">

  <!-- Responsive -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <!--[if lt IE 9]><script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js')}}"></script><![endif]-->
  <!--[if lt IE 9]><script src="{{url('js/respond.js')}}"></script><![endif]-->

  <script src="{{url('assets/js/jquery.js')}}"></script>
  <script src="{{url('assets/js/popper.min.js')}}"></script>
  <script src="{{url('assets/js/jquery-ui.min.js')}}"></script>
  <script src="{{url('assets/js/chosen.min.js')}}"></script>
  <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
  <script src="{{url('assets/js/jquery.fancybox.js')}}"></script>
  <script src="{{url('assets/js/jquery.modal.min.js')}}"></script>
  <script src="{{url('assets/js/mmenu.polyfills.js')}}"></script>
  <script src="{{url('assets/js/mmenu.js')}}"></script>
  <script src="{{url('assets/js/appear.js')}}"></script>

  <!-- Plugin Tambahan -->
  <script src="{{url('assets/master/js/plugin/jquery.form.min.js')}}"></script>
  <script src="{{url('assets/master/js/plugin/jquery.validate.min.js')}}"></script>
  <script src="{{url('assets/master/js/plugin/sweetalert.min.js')}}"></script>

  <!-- Script Tambahan -->
  <script src="{{url('assets/master/js/script.js')}}"></script>

  <style>
    footer {
      position: relative;
      clear: both;
  }
  </style>
</head>

<body data-anm=".anm">


  <div class="page-wrapper">

    <!-- Preloader -->
    <div class="preloader"></div>

    <!-- Main Header-->
    <header class="main-header header-shaddow">

      <!-- Main box -->
      <div class="main-box">
        <!--Nav Outer -->
        <div class="nav-outer">
          <div class="logo-box">
            <div class="logo"><a href="{{url('home')}}"><img src="{{url('assets/master/images/logo.png')}}" width="180px" alt="" title=""></a></div>
          </div>

          <nav class="nav main-menu">
            <ul class="navigation" id="navbar">
              {{-- <li><a href="index-2.html">Home Page 01</a></li> --}}
              <li><a href="{{url('menu/loker')}}">Lowongan Pekerjaan</a></li>
              <li><a href="{{url('menu/perusahaan')}}">Perusahaan</a></li>
              <li><a href="{{url('menu/pencari-kerja')}}">Pencari Kerja</a></li>
              <li class="dropdown">
              <span>Blog</span>
              <ul>
                  <li><a href="{{url('menu/blog?tipe=pelatihan')}}">Pelatihan</a></li>
                  <li><a href="{{url('menu/blog?tipe=event')}}">Event</a></li>
              </ul>
              </li>
              <li><a href="{{url('menu/faq')}}">FAQ's</a></li>
            </ul>
          </nav>
          <!-- Main Menu End-->
        </div>

        <div class="outer-box">
          <!-- Add Listing -->
          <?php if(@Auth::user()->status): ?>
            <!-- Dashboard Option -->
            <div class="dropdown dashboard-option">
              <a class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
                {{-- <img src="{{url('assets/images/resource/company-6.png')}}" alt="avatar" class="thumb"> --}}
                <img src="{{Auth::user()->foto ? Sideveloper::storageUrl(Auth::user()->foto) : url('assets/images/resource/company-2.png')}}"  alt="avatar" class="thumb">
                <span class="name">{{Auth::user()->nama}}</span>
              </a>
              <ul class="dropdown-menu">
                @foreach($menus as $key => $mn)
                  <li><a href="{{url($mn->link)}}"><i class="{{$mn->ikon}}"></i>{{$mn->nama}}</a></li>
                @endforeach
                {{-- <li><a href="{{url('auth/logout')}}"><i class="la la-sign-out"></i>Logout</a></li> --}}
                <li><button type="button" onclick="logout()"><i class="la la-sign-out"></i>Logout</a></li>
              </ul>
            </div>
          <?php else: ?>
            <!-- Login/Register -->
            <div class="btn-box">
              <a href="{{url('auth/login')}}" class="theme-btn btn-style-one call-modal">Login / Daftar</a>
            </div>
          <?php endif; ?>

        </div>
      </div>

      <!-- Mobile Header -->
      <div class="mobile-header">
        <div class="logo"><a href="{{url('home')}}"><img src="{{url('assets/master/images/icon.png')}}" alt="" title=""></a></div>

        <!--Nav Box-->
        <div class="nav-outer clearfix">

          <div class="outer-box">
            <?php if(@Auth::user()->status): ?>

              <div class="login-box">
                <a href="{{url('menu/dashboard')}}" style="font-size: 10px;">
                <span style="font-size: 10px;text-decoration: underline;text-underline-offset: 4px;" > DASHBOARD </span>
                </a>
              </div>
            <?php else: ?>
              <!-- Login/Register -->
              <div class="login-box">
                <a href="{{url('auth/login')}}" class="call-modal" style="font-size: 10px;">
                <span style="font-size: 10px;text-decoration: underline;text-underline-offset: 4px;" >LOGIN & DAFTAR </span>
                </a>
              </div>
            <?php endif; ?>
            <span style="font-size: 10px;font-weight:bold;margin:0 5px;">/</span>
            <a href="#nav-mobile" class="mobile-nav-toggler" style="transform: none;margin-left:0px;">
              <span style="font-size: 10px;text-decoration: underline;text-underline-offset: 4px;" id="text-menu"> MENU </span>
            </a>
          </div>
        </div>
      </div>
    <!-- Mobile Nav -->
    <div id="nav-mobile"></div>
    </header>
    <!--End Main Header -->
    
    {!!$contents!!}

    <!-- Main Footer -->
    <footer class="main-footer alternate">
      <div class="auto-container">
        <!--Widgets Section-->
        <div class="widgets-section">
          <div class="row">
            <div class="big-column col-xl-4 col-lg-3 col-md-12">
              <div class="footer-column about-widget">
                <div class="logo"><a href="#"><img src="{{url('assets/master/images/logo.png')}}" width="200px" alt=""></a></div>
                <p class="phone-num"><span>Telepon</span><a href="https://disnakerprind.info">(0777) 7366053</a></p>
                <p class="address">Kompl. Perkant. Gedung B Lt. II, JL. Jend. Sudirman, Pamak, <br> Kec. Karimun, Kabupaten Karimun, Kepulauan Riau 29664 <br><a href="mailto:siapnari@disnakerprind.info" class="email">siapnari@disnakerprind.info</a></p>
              </div>
            </div>

            {{-- <div class="big-column col-xl-8 col-lg-9 col-md-12">
              <div class="row">
                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">For Candidates</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="#">Browse Jobs</a></li>
                        <li><a href="#">Browse Categories</a></li>
                        <li><a href="#">Candidate Dashboard</a></li>
                        <li><a href="#">Job Alerts</a></li>
                        <li><a href="#">My Bookmarks</a></li>
                      </ul>
                    </div>
                  </div>
                </div>


                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">For Employers</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="#">Browse Candidates</a></li>
                        <li><a href="#">Employer Dashboard</a></li>
                        <li><a href="#">Add Job</a></li>
                        <li><a href="#">Job Packages</a></li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">About Us</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="#">Job Page</a></li>
                        <li><a href="#">Job Page Alternative</a></li>
                        <li><a href="#">Resume Page</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                      </ul>
                    </div>
                  </div>
                </div>


                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">Helpful Resources</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="#">Site Map</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Center</a></li>
                        <li><a href="#">Security Center</a></li>
                        <li><a href="#">Accessibility Center</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}
          </div>
        </div>
      </div>


      <!--Bottom-->
      <div class="footer-bottom">
        <div class="auto-container">
          <div class="outer-box">
            <div class="copyright-text">© 2022 <a href="#">IT Disnaker Balai Karimun</a>. All Right Reserved.</div>
            <div class="social-links">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Scroll To Top -->
      <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
    </footer>
    <!-- End Main Footer -->
  </div><!-- End Page Wrapper -->

  <script src="{{url('assets/js/anm.min.js')}}"></script>
  <script src="{{url('assets/js/ScrollMagic.min.js')}}"></script>
  <script src="{{url('assets/js/rellax.min.js')}}"></script>
  <script src="{{url('assets/js/owl.js')}}"></script>
  <script src="{{url('assets/js/wow.js')}}"></script>
  <script src="{{url('assets/js/script.js')}}"></script>
<script>
  function logout(){
      // localStorage.setItem("jwt_token", res.jwt_token);
      localStorage.removeItem('jwt_token');
      window.open("{{url('auth/logout')}}");
    }
    var menu = true;
    function clickNav(){
        // menu = !menu;
        // console.log(menu);
        // if(menu){
        //   $('#text-menu').html('MENU');
        // }else{
        //   $('#text-menu').html('CLOSE');
        // }
    }
</script>
</body>


</html>