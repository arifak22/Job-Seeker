    <!-- Job Detail Section -->
    <section class="job-detail-section" style="margin-left: 300px">
      <!-- Upper Box -->
      <div class="upper-box">
        <div class="auto-container">
          <!-- Job Block -->
          <div class="job-block-seven">
            <div class="inner-box">
              <div class="content">
                <span class="company-logo"><img src="{{$data->foto ? Sideveloper::storageUrl($data->foto) : url('assets/images/resource/company-2.png')}}" alt=""></span>
                <h4><a href="#">{{$data->nama}}</a></h4>
                <ul class="job-info">
                  <li><span class="icon flaticon-map-locator"></span> {{$data->nama_kecamatan}}, {{$data->nama_kelurahan}} </li>
                  {{-- <li><span class="icon flaticon-money"></span> $99 / hour</li> --}}
                  <li><span class="icon flaticon-clock"></span> Terdaftar pada {{Sideveloper::dateFull($data->created_date)}}</li>
                </ul>
                <ul class="job-other-info">
                  <li class="time">{{$data->nama_bidang}}</li>
                </ul>
              </div>

              <div class="btn-box">
                <a href="{{url('perusahaan/profil-ubah')}}" class="theme-btn btn-style-one"><i class="la la-pencil"></i> &nbsp; &nbsp;Ubah Profil</a>
                {{-- <button class="bookmark-btn"><i class="flaticon-bookmark"></i></button> --}}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="job-detail-outer">
        <div class="auto-container">
          <div class="row">
            <div class="content-column col-lg-8 col-md-12 col-sm-12">
              <div class="job-detail">
                <h4>Deskripsi</h4>
                {!!$data->deskripsi!!}
              </div>

              <!-- Related Jobs -->
              {{-- <div class="related-jobs">
                <div class="title-box">
                  <h3>3 jobs at Invision</h3>
                  <div class="text">2020 jobs live - 293 added today.</div>
                </div>

                <!-- Job Block -->
                <div class="job-block">
                  <div class="inner-box">
                    <div class="content">
                      <span class="company-logo"><img src="images/resource/company-logo/1-3.png" alt=""></span>
                      <h4><a href="#">Senior Full Stack Engineer, Creator Success</a></h4>
                      <ul class="job-info">
                        <li><span class="icon flaticon-briefcase"></span> Segment</li>
                        <li><span class="icon flaticon-map-locator"></span> London, UK</li>
                        <li><span class="icon flaticon-clock-3"></span> 11 hours ago</li>
                        <li><span class="icon flaticon-money"></span> $35k - $45k</li>
                      </ul>
                      <ul class="job-other-info">
                        <li class="time">Full Time</li>
                        <li class="required">Urgent</li>
                      </ul>
                      <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
                    </div>
                  </div>
                </div>

                <!-- Job Block -->
                <div class="job-block">
                  <div class="inner-box">
                    <div class="content">
                      <span class="company-logo"><img src="images/resource/company-logo/1-3.png" alt=""></span>
                      <h4><a href="#">Web Developer</a></h4>
                      <ul class="job-info">
                        <li><span class="icon flaticon-briefcase"></span> Segment</li>
                        <li><span class="icon flaticon-map-locator"></span> London, UK</li>
                        <li><span class="icon flaticon-clock-3"></span> 11 hours ago</li>
                        <li><span class="icon flaticon-money"></span> $35k - $45k</li>
                      </ul>
                      <ul class="job-other-info">
                        <li class="time">Part Time</li>
                        <li class="required">Urgent</li>
                      </ul>
                      <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
                    </div>
                  </div>
                </div>

                <!-- Job Block -->
                <div class="job-block">
                  <div class="inner-box">
                    <div class="content">
                      <span class="company-logo"><img src="images/resource/company-logo/1-3.png" alt=""></span>
                      <h4><a href="#">Sr. Full Stack Engineer</a></h4>
                      <ul class="job-info">
                        <li><span class="icon flaticon-briefcase"></span> Segment</li>
                        <li><span class="icon flaticon-map-locator"></span> London, UK</li>
                        <li><span class="icon flaticon-clock-3"></span> 11 hours ago</li>
                        <li><span class="icon flaticon-money"></span> $35k - $45k</li>
                      </ul>
                      <ul class="job-other-info">
                        <li class="time">Part Time</li>
                      </ul>
                      <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
                    </div>
                  </div>
                </div>

              </div> --}}
            </div>

            <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
              <aside class="sidebar">
                <div class="sidebar-widget company-widget">
                  <div class="widget-content">

                    <ul class="company-info mt-0">
                      <li>Bidang Usaha: <span>{{$data->nama_bidang}}</span></li>
                      <li>Total Pegawai: <span>{{$data->total_pegawai}}</span></li>
                      <li>Berdiri Tahun: <span>{{$data->tahun_berdiri}}</span></li>
                      <li>Nomor HP: <span>{{$data->no_hp}}</span></li>
                      <li>E-mail: <span>{{$data->email}}</span></li>
                      {{-- <li>Social media:
                        <div class="social-links">
                          <a href="#"><i class="fab fa-facebook-f"></i></a>
                          <a href="#"><i class="fab fa-twitter"></i></a>
                          <a href="#"><i class="fab fa-instagram"></i></a>
                          <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                      </li> --}}
                    </ul>

                    <div class="btn-box"><a href="http://{{$data->website}}" class="theme-btn btn-style-three">{{$data->website}}</a></div>
                  </div>
                </div>

                {{-- <div class="sidebar-widget">
                  <!-- Map Widget -->
                  <h4 class="widget-title">Job Location</h4>
                  <div class="widget-content">
                    <div class="map-outer mb-0">
                      <div class="map-canvas" data-zoom="12" data-lat="-37.817085" data-lng="144.955631" data-type="roadmap" data-hue="#ffc400" data-title="Envato" data-icon-path="images/resource/map-marker.png" data-content="Melbourne VIC 3000, Australia<br><a href='mailto:info@youremail.com'>info@youremail.com</a>">
                      </div>
                    </div>
                  </div>
                </div> --}}


              </aside>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Job Detail Section -->
