<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8">
  <title>SIAPNARI | Sistem Aplikasi Tenaga Kerja & Perindustrian</title>

  <!-- Stylesheets -->
  <link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet">
  {{-- https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css --}}
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"> --}}

  <link href="{{url('assets/master/css/plugin/datatable.css')}}" rel="stylesheet">
  <link href="{{url('assets/css/style.css')}}" rel="stylesheet">
  <link href="{{url('assets/css/responsive.css')}}" rel="stylesheet">
  <link href="{{url('assets/master/css/plugin/jquery.datetimepicker.css')}}" rel="stylesheet">

  <link rel="shortcut icon" href="{{url('assets/master/images/icon.png')}}" type="image/x-icon">
  <link rel="icon" href="{{url('assets/master/images/icon.png')}}" type="image/x-icon">


  <!-- Responsive -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <!--[if lt IE 9]><script src="{{url('assets/https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js')}}"></script><![endif]-->
  <!--[if lt IE 9]><script src="{{url('assets/js/respond.js')}}"></script><![endif]-->
  <script src="{{url('assets/js/jquery.js')}}"></script>
  <script src="{{url('assets/js/popper.min.js')}}"></script>
  <script src="{{url('assets/js/chosen.min.js')}}"></script>
  <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
  <script src="{{url('assets/js/jquery-ui.min.js')}}"></script>
  <script src="{{url('assets/js/jquery.fancybox.js')}}"></script>
  <script src="{{url('assets/js/jquery.modal.min.js')}}"></script>

    <!-- Plugin Tambahan -->
  <script src="{{url('assets/master/js/plugin/jquery.form.min.js')}}"></script>
  <script src="{{url('assets/master/js/plugin/jquery.validate.min.js')}}"></script>
  <script src="{{url('assets/master/js/plugin/sweetalert.min.js')}}"></script>
  <script src="{{url('assets/master/js/plugin/jquery.datetimepicker-full.js')}}"></script>

  <script src="{{url('assets/master/js/plugin/datatables.min.js')}}"  type="text/javascript" charset="utf8"></script>
  
  {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script> --}}
  <!-- Script Tambahan -->
  <script src="{{url('assets/master/js/script.js')}}"></script>

  <style>
    .tox-notifications-container{
      display: none;
    }
    .modal{
      max-width: 1000px;
    }

    #default-modal{
        max-width: 1000px;
        padding: 30px 40px 20px;
        overflow: visible;
        background: #fff;
        border-radius: 8px;
        box-shadow: none;
    }
    .resume-block .edit-btns a {
      position: relative;
      width: 30px;
      height: 30px;
      line-height: 30px;
      text-align: center;
      background: rgba(25, 103, 210, 0.07);
      border-radius: 8px;
      margin-right: 10px;
      min-width: auto;
      color: #1967d2;
    }

  .paginate_button{
    position: relative;
    margin: 0 5px;
    font-size: 14px;
    color: #696969;
    /* line-height: 45px; */
    min-width: 45px;
    font-weight: 400;
    text-align: center;
  }
  .dataTables_paginate span .current{
    position: relative;
    display: block;
    color: #696969;
    border-radius: 50%;
    transition: all 300ms ease;
    ackground: #1967D2;
    color: #ffffff;
  }

  .dataTables_paginate span .current{
    position: relative;
    display: block;
    color: #696969;
    border-radius: 50%;
    transition: all 300ms ease;
  }
  </style>
</head>

<body>
  <div class="page-wrapper {{last(request()->segments()) == 'profil' ? '' : 'dashboard'}}">

    <!-- Preloader -->
    <div class="preloader"></div>

    <!-- Header Span -->
    <span class="header-span"></span>

    <!-- Main Header-->
    <header class="main-header header-shaddow">
      <div class="container-fluid">
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

            {{-- <button class="menu-btn">
              <span class="count">1</span>
              <span class="icon la la-heart-o"></span>
            </button> --}}

            {{-- <button class="menu-btn">
              <span class="icon la la-bell"></span>
            </button> --}}

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
                <li><button type="button" onclick="logout()"><i class="la la-sign-out"></i>Logout</button></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile Header -->
      <div class="mobile-header">
        <div class="logo"><a href="{{url('home')}}"><img src="{{url('assets/master/images/icon.png')}}" alt="" title=""></a></div>

        <!--Nav Box-->
        <div class="nav-outer clearfix">

          <div class="outer-box">
            <div class="login-box">
              <a href="{{url('home')}}" class="mobile-nav-toggler" style="transform: none;margin-left:0px;">
                <span style="font-size: 10px;text-decoration: underline;text-underline-offset: 4px;" id="text-menu"> HOME </span>
              </a>
            </div>
            <span style="font-size: 10px;font-weight:bold;margin:0 5px;">/</span>

            <button id="toggle-user-sidebar" style="font-size: 10px;margin-left:0px;">
              <span style="font-size: 10px;text-decoration: underline;text-underline-offset: 4px;" > MENU </span>
              </button>
          </div>
        </div>

      </div>

      <!-- Mobile Nav -->
      <div id="nav-mobile"></div>
    </header>
    <!--End Main Header -->

    <!-- Sidebar Backdrop -->
    <div class="sidebar-backdrop"></div>

    <!-- User Sidebar -->
    <div class="user-sidebar">

      <div class="sidebar-inner">
        <ul class="navigation">
          @foreach($menus as $key => $mn)
          <li><a href="{{url($mn->link)}}"><i class="{{$mn->ikon}}"></i>{{$mn->nama}}</a></li>
          @endforeach
          <li><button type="button" onclick="logout()"><i class="la la-sign-out"></i>Logout</button></li>
        </ul>
      </div>
    </div>
    <!-- End User Sidebar -->

    {!!$contents!!}

    <br>
    <!-- Copyright -->
    <div class="copyright-text" style="position: absolute;
  right: 0;
  bottom: 0;
  /* left: 0; */
  padding: 1rem;
  /* margin-top: 20px; */
  text-align: center;">
      <p>© 2022 <a href="#">IT Disnaker Balai Karimun</a>. All Right Reserved.</p>
    </div>

  </div><!-- End Page Wrapper -->

  <script src="{{url('assets/js/mmenu.polyfills.js')}}"></script>
  <script src="{{url('assets/js/mmenu.js')}}"></script>
  <script src="{{url('assets/js/appear.js')}}"></script>
  <script src="{{url('assets/js/ScrollMagic.min.js')}}"></script>
  <script src="{{url('assets/js/rellax.min.js')}}"></script>
  <script src="{{url('assets/js/owl.js')}}"></script>
  <script src="{{url('assets/js/wow.js')}}"></script>
  <script src="{{url('assets/js/script.js')}}"></script>

  <!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
  <script src="{{url('assets/js/chart.min.js')}}"></script>
  <script>
    $(document).ready(function(){
      $("#table_id_filter").hide();
      $(".tox-notifications-container").hide();
    })

    function logout(){
      localStorage.removeItem('jwt_token');
      window.location = "{{url('auth/logout')}}";
    }
  </script>
</body>


</html>