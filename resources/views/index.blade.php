<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from creativelayers.net/themes/superio/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Sep 2022 03:10:27 GMT -->
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
  <script src="{{url('assets/js/chosen.min.js')}}"></script>
  <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
  <script src="{{url('assets/js/jquery.fancybox.js')}}"></script>
  <script src="{{url('assets/js/jquery.modal.min.js')}}"></script>
  <script src="{{url('assets/js/mmenu.polyfills.js')}}"></script>
  <script src="{{url('assets/js/mmenu.js')}}"></script>
  <script src="{{url('assets/js/appear.js')}}"></script>


</head>

<body data-anm=".anm">


  <div class="page-wrapper">

    <!-- Preloader -->
    <div class="preloader"></div>

    <!-- Main Header-->
    <header class="main-header">

      <!-- Main box -->
      <div class="main-box">
        <!--Nav Outer -->
        <div class="nav-outer">
          <div class="logo-box">
            <div class="logo"><a href="index-2.html"><img src="{{url('assets/master/images/logo.png')}}" width="180px" alt="" title=""></a></div>
          </div>

          <nav class="nav main-menu">
            <ul class="navigation" id="navbar">
              {{-- <li><a href="index-2.html">Home Page 01</a></li> --}}
              <li><a href="index-2.html">Lowongan Pekerjaan</a></li>
              <li><a href="index-2.html">Perusahaan</a></li>
              <li><a href="index-2.html">Pencari Kerja</a></li>
              <li class="dropdown">
                <span>Blog</span>
                <ul>
                  <li><a href="blog-list-v1.html">Pelatihan</a></li>
                  <li><a href="blog-list-v2.html">Event</a></li>
                </ul>
              </li>
              <li><a href="index-2.html">FAQ's</a></li>
            </ul>
          </nav>
          <!-- Main Menu End-->
        </div>

        <div class="outer-box">
          <!-- Add Listing -->
          {{-- <a href="candidate-dashboard-cv-manager.html" class="upload-cv"> Upload CV Anda</a> --}}
          <!-- Login/Register -->
          <div class="btn-box">
            {{-- <a href="login-popup.html" class="theme-btn btn-style-three call-modal">Login / Register</a> --}}
            <a href="login-popup.html" class="theme-btn btn-style-one">Login / Register</a>
            {{-- <a href="dashboard-post-job.html" class="theme-btn btn-style-one">Job Post</a> --}}
          </div>
        </div>
      </div>

      <!-- Mobile Header -->
      <div class="mobile-header">
        <div class="logo"><a href="index-2.html"><img src="{{url('assets/master/images/icon.png')}}" alt="" title=""></a></div>

        <!--Nav Box-->
        <div class="nav-outer clearfix">

          <div class="outer-box">
            <!-- Login/Register -->
            <div class="login-box">
              <a href="login-popup.html" class="call-modal"><span class="icon-user"></span></a>
            </div>

            <a href="#nav-mobile" class="mobile-nav-toggler"><span class="flaticon-menu-1"></span></a>
          </div>
        </div>
      </div>

      <!-- Mobile Nav -->
      <div id="nav-mobile"></div>
    </header>
    <!--End Main Header -->

    <!-- Banner Section Three-->
    <section class="banner-section-three">
      <div class="auto-container">
        <div class="row">
          <div class="content-column col-lg-7 col-md-12 col-sm-12">
            <div class="inner-column">
              <div class="title-box wow fadeInUp">
                <h3>Cari Pekerjaan lebih mudah <br>dengan Siapnari</h3>
                {{-- <div class="text">Cari Pekerjaan lebih mudah dengan Siapnari</div> --}}
              </div>

              <!-- Job Search Form -->
              <div class="job-search-form-two wow fadeInUp" data-wow-delay="500ms">
                <form method="post" action="https://creativelayers.net/themes/superio/job-list-v10.html">
                  <div class="row">
                    <div class="form-group col-lg-5 col-md-12 col-sm-12">
                      <label class="title">Keywords</label>
                      <span class="icon flaticon-search-1"></span>
                      <input type="text" name="field_name" placeholder="Job title, keywords, or company">
                    </div>
                    <!-- Form Group -->
                    <div class="form-group col-lg-4 col-md-12 col-sm-12 location">
                      <label class="title">Lokasi</label>
                      <span class="icon flaticon-map-locator"></span>
                      <input type="text" name="field_name" placeholder="City or postcode">
                    </div>
                    <!-- Form Group -->
                    <div class="form-group col-lg-3 col-md-12 col-sm-12 btn-box">
                      <button type="submit" class="theme-btn btn-style-one"><span class="btn-title">Cari Pekerjaan</span></button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- Job Search Form -->

            </div>
          </div>

          <div class="image-column col-lg-5 col-md-12">
            <div class="image-box">
              <figure class="main-image wow fadeInRight" data-wow-delay="1500ms"><img src="{{url('assets/images/resource/banner-img-3.png')}}" alt=""></figure>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Banner Section Three-->

    <!-- App Section -->
    <section class="app-section">
      <div class="auto-container">
        <div class="row">
          <!-- Image Column -->
          <div class="image-column col-lg-6 col-md-12 col-sm-12">
            <div class="bg-shape"></div>
            <figure class="image wow fadeInLeft"><img src="images/resource/mobile-app.png" alt=""></figure>
          </div>

          <div class="content-column col-lg-6 col-md-12 col-sm-12">
            <div class="inner-column wow fadeInRight">
              <div class="sec-title">
                <span class="sub-title">SIAPNARI - MOBILE VERSION</span>
                <h2>Download SIAPNARI <br>(Sistem Aplikasi Tenaga Kerja & Perindustrian)</h2>
                <div class="text">Lebih mudah mencari pekerjaan dengan SIAPNARI versi mobile.</div>
              </div>
              <div class="download-btn">
                <a href="#"><img src="{{url('assets/images/icons/google.png')}}" alt=""></a>
                <a href="#"><img src="{{url('assets/images/icons/apple.png')}}" alt=""></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End App Section -->

    <!-- Main Footer -->
    <footer class="main-footer alternate">
      <div class="auto-container">
        <!--Widgets Section-->
        <div class="widgets-section">
          <div class="row">
            <div class="big-column col-xl-4 col-lg-3 col-md-12">
              <div class="footer-column about-widget">
                <div class="logo"><a href="#"><img src="{{url('assets/master/images/logo.png')}}" width="200px" alt=""></a></div>
                <p class="phone-num"><span>Telepon</span><a href="thebeehost%40support.html">123 456 7890</a></p>
                <p class="address">329 Queensberry Street, North Melbourne VIC<br> 3051, Australia. <br><a href="mailto:support@superio.com" class="email">support@superio.com</a></p>
              </div>
            </div>

            <div class="big-column col-xl-8 col-lg-9 col-md-12">
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
            </div>
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

</body>


<!-- Mirrored from creativelayers.net/themes/superio/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Sep 2022 03:12:31 GMT -->
</html>