 <br>
 <br>
 <!-- Job Detail Section -->
 <section class="job-detail-section">
    <!-- Upper Box -->
    <div class="upper-box">
      <div class="auto-container">
        <!-- Job Block -->
        <div class="job-block-seven">
          <div class="inner-box">
            <div class="content">
              <span class="company-logo"><img src="{{Sideveloper::storageUrl($data->foto_perusahaan)}}" alt=""></span>
              <h4><a href="{{url('menu/loker-detil?id='.$data->id)}}">{{$data->judul}}</a></h4>
              <ul class="job-info">
                <li><span class="icon flaticon-map-locator"></span> {{$data->kecamatan}}, {{$data->kelurahan}}</li>
                <li><span class="icon flaticon-clock-3"></span> Batas Akhir Lamaran: {{Sideveloper::date($data->tanggal_kadaluarsa)}}</li>
                <li><span class="icon flaticon-money"></span> {{Sideveloper::gaji_show($data)}}</li>
              </ul>
              <ul class="job-other-info">
                <li class="{{$data->class_jenis}}">{{$data->jenis_pekerjaan}}</li>
                <li class="required">Min. {{$data->pendidikan}}</li>
              </ul>
            </div>

            <div class="btn-box">
              @auth
                @if(Auth::user()->id_privilege == 1)
                  @if(in_array(Auth::user()->id, $pelamar))
                    <button type="button" class="theme-btn btn-style-four"><i class="la la-check"></i> &nbsp; &nbsp;Applied</button>
                  @else
                    <span id="lamar-button"><button type="button" onclick="lamar()" class="theme-btn btn-style-one">Lamar Pekerjaan</button></span>
                  @endif
                @endif
              @endauth
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
              <h4>Deskripsi Pekerjaan</h4>
              {!!$data->deskripsi!!}
              @foreach($deskripsi as $d)
              <h4>{{$d->judul_deskripsi}}</h4>
              <ul class="list-style-three">
                @foreach(DB::table('loker_deskripsi_detil')->where('id_loker_deskripsi', $d->id)->get() as $dd)
                <li>{{$dd->keterangan}}</li>
                @endforeach
              </ul>
              @endforeach
              {{-- <h4>Skill & Experience</h4>
              <ul class="list-style-three">
                <li>You have at least 3 years’ experience working as a Product Designer.</li>
                <li>You have experience using Sketch and InVision or Framer X</li>
                <li>You have some previous experience working in an agile environment – Think two-week sprints.</li>
                <li>You are familiar using Jira and Confluence in your workflow</li>
              </ul> --}}
            </div>

            <!-- Other Options -->
            <div class="other-options">
              <div class="social-share">
                <h5>Share this job</h5>
                <a href="#" class="facebook"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a href="#" class="twitter"><i class="fab fa-twitter"></i> Twitter</a>
                <a href="#" class="google"><i class="fab fa-google"></i> Google+</a>
              </div>
            </div>

            <!-- Related Jobs -->
            {{-- <div class="related-jobs">
              <div class="title-box">
                <h3>Related Jobs</h3>
                <div class="text">2020 jobs live - 293 added today.</div>
              </div>

              <!-- Job Block -->
              <div class="job-block">
                <div class="inner-box">
                  <div class="content">
                    <span class="company-logo"><img src="images/resource/company-logo/1-1.png" alt=""></span>
                    <h4><a href="#">Software Engineer (Android), Libraries</a></h4>
                    <ul class="job-info">
                      <li><span class="icon flaticon-briefcase"></span> Segment</li>
                      <li><span class="icon flaticon-map-locator"></span> London, UK</li>
                      <li><span class="icon flaticon-clock-3"></span> 11 hours ago</li>
                      <li><span class="icon flaticon-money"></span> $35k - $45k</li>
                    </ul>
                    <ul class="job-other-info">
                      <li class="time">Full Time</li>
                      <li class="privacy">Private</li>
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
                    <span class="company-logo"><img src="images/resource/company-logo/1-2.png" alt=""></span>
                    <h4><a href="#">Recruiting Coordinator</a></h4>
                    <ul class="job-info">
                      <li><span class="icon flaticon-briefcase"></span> Segment</li>
                      <li><span class="icon flaticon-map-locator"></span> London, UK</li>
                      <li><span class="icon flaticon-clock-3"></span> 11 hours ago</li>
                      <li><span class="icon flaticon-money"></span> $35k - $45k</li>
                    </ul>
                    <ul class="job-other-info">
                      <li class="time">Full Time</li>
                      <li class="privacy">Private</li>
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
                    <h4><a href="#">Product Manager, Studio</a></h4>
                    <ul class="job-info">
                      <li><span class="icon flaticon-briefcase"></span> Segment</li>
                      <li><span class="icon flaticon-map-locator"></span> London, UK</li>
                      <li><span class="icon flaticon-clock-3"></span> 11 hours ago</li>
                      <li><span class="icon flaticon-money"></span> $35k - $45k</li>
                    </ul>
                    <ul class="job-other-info">
                      <li class="time">Full Time</li>
                      <li class="privacy">Private</li>
                      <li class="required">Urgent</li>
                    </ul>
                    <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
                  </div>
                </div>
              </div>

            </div> --}}
          </div>

          <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
            <aside class="sidebar">
              <div class="sidebar-widget">
                <!-- Job Overview -->
                <h4 class="widget-title">Informasi Lain</h4>
                <div class="widget-content">
                  <ul class="job-overview">
                    <li>
                      <i class="icon icon-calendar"></i>
                      <h5>Diposting pada:</h5>
                      <span>{{Sideveloper::date($data->tanggal_dibuat)}}</span>
                    </li>
                    <li>
                      <i class="icon icon-expiry"></i>
                      <h5>Batas Akhir Lamaran:</h5>
                      <span>{{Sideveloper::date($data->tanggal_kadaluarsa)}}</span>
                    </li>
                    <li>
                      <i class="icon icon-location"></i>
                      <h5>Lokasi:</h5>
                      <span>{{$data->kecamatan}}, {{$data->kelurahan}}</span>
                    </li>
                    <li>
                      <i class="icon icon-salary"></i>
                      <h5>Gaji:</h5>
                      <span>{{Sideveloper::gaji_show($data)}}</span>
                    </li>
                  </ul>
                </div>

                <!-- Job Skills -->
                <h4 class="widget-title">Keahlian</h4>
                <div class="widget-content">
                  <ul class="job-skills">
                    @foreach($keahlian as $k)
                    <li><a href="#">{{$k->nama_choice}}</a></li>
                    @endforeach
                  </ul>
                </div>
<br>
                <!-- Job Skills -->
                <h4 class="widget-title">Bahasa</h4>
                <div class="widget-content">
                  <ul class="job-skills">
                    @foreach($bahasa as $k)
                    <li><a href="#">{{$k->nama_choice}}</a></li>
                    @endforeach
                  </ul>
                </div>
              </div>

              <div class="sidebar-widget company-widget">
                <div class="widget-content">
                  <div class="company-title">
                    <div class="company-logo"><img src="{{Sideveloper::storageUrl($profile->foto)}}" alt=""></div>
                    <h5 class="company-name">{{$profile->nama}}</h5>
                    <a href="{{url('menu/perusahaan-detil?id='.$profile->id)}}" class="profile-link">Lihat Profile Perusahaan</a>
                  </div>

                  <ul class="company-info">
                    <li>Bidang Usaha: <span>{{$profile->nama_bidang}}</span></li>
                    <li>Total Pegawai: <span>{{$profile->total_pegawai}}</span></li>
                    <li>Berdiri Tahun: <span>{{$profile->tahun_berdiri}}</span></li>
                    <li>Nomor HP: <span>{{$profile->no_hp}}</span></li>
                    <li>E-mail: <span>{{$profile->email}}</span></li>
                  </ul>

                <div class="btn-box"><a href="http://{{$profile->website}}" class="theme-btn btn-style-three">{{$profile->website}}</a></div>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Job Detail Section -->
  <script>
    function lamar(){
        swal({
            title: "Apakah anda yakin?",
            text: "Melamar Pekerjaan ini!",
            icon: "warning",
            buttons: true,
            // dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                apiLoading(true);
                $.ajax({
                    method: "POST",
                    url:  "{{url('api/pencari-kerja/lamar')}}",
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem('jwt_token')
                    },
                    data: { id: "{{$data->id}}", _token: "{{ csrf_token() }}" }
                })
                .done(function(res) {
                    apiRespone(res,
						null,
						() => {
              $("#lamar-button").html(` <button type="button" class="theme-btn btn-style-four"><i class="la la-check"></i> &nbsp; &nbsp;Applied</button>`);
						}
					);
                })
                .fail(function(err) {
                    alert("error");
                })
                .always(function() {
                    apiLoading(false);
                });
            }
        });
    }
  </script>