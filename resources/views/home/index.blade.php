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

  <div class="tab-menu__wrapper">
    <section class="tab-menu -horiz js-tab-menu">
      <div class="auto-container">
        <div class="tab-menu__content">
          <div class="row justify-content-center">

            <div class="col-xl-auto col-md-4 col-auto">
              <a href="#section-1" class="tab-menu__item js-scroll-to-id">
                <div class="icon text-dark-4 icon-case"></div>
                <div class="title text-dark-4">Layanan Disnaker Karimun</div>
              </a>
            </div>

            <div class="col-xl-auto col-md-4 col-auto">
              <a href="#section-2" class="tab-menu__item js-scroll-to-id">
                <div class="icon text-dark-4 icon-contact"></div>
                <div class="title text-dark-4">Informasi Pelatihan</div>
              </a>
            </div>

            <div class="col-xl-auto col-md-4 col-auto">
              <a href="#section-3" class="tab-menu__item js-scroll-to-id">
                <div class="icon text-dark-4 icon-doc"></div>
                <div class="title text-dark-4">Tata Cara Pengaduan Ketenagakerjaan</div>
              </a>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section id="section-1" class="about-section-two style-two layout-pt-150 layout-pb-60 js-tab-menu-content">
      <div class="auto-container">
        <div class="row grid-base justify-content-between align-items-center">
          <!-- Content Column -->
          <div class="content-column col-xl-4 col-lg-5 col-md-12 col-sm-12 order-2 order-lg-1">
            <div class="inner-column -no-padding wow fadeInLeft">
              <div class="sec-title">
                <h2 class="fw-700">Layanan<br> Disnaker Karimun</h2>
                <div class="text mt-30">Kantor Disnaker Karimun selalu memberikan layanan terbaik ..........</div>
              </div>
              <ul class="list-style-one mt-24 mb-24">
                <li>Lowongan Pekerjaan</li>
                <li>Pencari Kerja</li>
                <li>Pengaduan Ketenagakerjaan, Regulasi, <br> Sertifikasi & Sistem layanan K3</li>
              </ul>
              {{-- <a href="#" class="theme-btn -blue">Discover More</a> --}}
            </div>
          </div>

          <!-- Image Column -->
          <div class="image-column -no-margin col-lg-6 col-md-12 col-sm-12 order-1 order-lg-2 wow fadeInRight">
            <figure class="image-box"><img src="{{url('assets/images/index-12/images/1.png')}}" alt=""></figure>
          </div>
        </div>
      </div>
    </section>
    <!-- End About Section -->

    <section id="section-2" class="job-section style-two js-tab-menu-content">
      <div class="auto-container wow fadeInUp">
        <div class="sec-title text-center">
          <h2>Informasi Pelatihan</h2>
          <div class="text">Berikut beberapa pelatihan yang mungkin anda dapat ikuti</div>
        </div>

        <div class="job-carousel owl-carousel owl-theme default-dots">
          <!-- Job Block -->
          <div class="job-block-three">
            <div class="inner-box">
              <div class="content" style="padding-left:0px">
                {{-- <span class="company-logo"><img src="images/resource/company-logo/2-1.png" alt=""></span> --}}
                <h4><a href="#">Judul Pelatihan</a></h4>
                <ul class="job-info">
                  <li><span class="icon flaticon-briefcase"></span> Segment</li>
                  <li><span class="icon flaticon-map-locator"></span> London, UK</li>
                </ul>
              </div>
              <ul class="job-other-info">
                <li class="time">Full Time</li>
                <li class="required">Urgent</li>
              </ul>
              <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="section-3" class="layout-pt-120 layout-pb-60 testimonial-section style-two js-tab-menu-content">
      <div class="auto-container">
        <!-- Sec Title -->
        <div class="sec-title text-center">
          <h2 class="fw-700">Tata Cara Pengaduan Ketenagakerjaan</h2>
          <div class="text">Jika menemukan kendala atau blabla, tenaga kerja dapat melakukan pengaduan dengan tata cara berikut:</div>
        </div>

        <div class="row grid-base">

          <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="step-item text-center">
              {{-- <div class="image">
                <img src="images/index-12/steps/1.png" alt="image">
              </div> --}}
              <h3 class="title"><span class="text-red">01</span> Judul</h3>
              <p class="text">Keterangan ......... ...... ...... .....</p>
            </div>
          </div>

          <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="step-item text-center">
              {{-- <div class="image">
                <img src="images/index-12/steps/2.png" alt="image">
              </div> --}}
              <h3 class="title"><span class="text-red">02</span> Judul</h3>
              <p class="text">Keterangan ......... ...... ...... .....</p>
            </div>
          </div>

          <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="step-item text-center">
              {{-- <div class="image">
                <img src="images/index-12/steps/3.png" alt="image">
              </div> --}}
              <h3 class="title"><span class="text-red">03</span> Judul</h3>
              <p class="text">Keterangan ......... ...... ...... .....</p>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
  <!-- App Section -->
  <section class="app-section">
    <div class="auto-container">
      <div class="row">
        <!-- Image Column -->
        <div class="image-column col-lg-6 col-md-12 col-sm-12">
          <div class="bg-shape"></div>
          <figure class="image wow fadeInLeft"><img src="{{url('assets/images/resource/mobile-app.png')}}" alt=""></figure>
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