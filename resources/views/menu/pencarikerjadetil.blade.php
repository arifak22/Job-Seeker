  <br>
  <br>
  <!-- Candidate Detail Section -->
  <section class="candidate-detail-section">
    <!-- Upper Box -->
    <div class="upper-box">
      <div class="auto-container">
        <!-- Candidate block Five -->
        <div class="candidate-block-five">
          <div class="inner-box">
            <div class="content">
              <figure class="image"><img src="{{$data->foto ? Sideveloper::storageUrl($data->foto) : url('assets/images/resource/company-2.png')}}" alt=""></figure>
              <h4 class="name"><a href="#">{{$data->nama}}</a></h4>
              <ul class="candidate-info">
                <li class="designation">{{$data->pendidikan_terakhir}} - {{$data->jurusan}}</li>
                <li><span class="icon flaticon-map-locator"></span> {{$data->kecamatan}}, {{$data->kelurahan}} </li>
                {{-- <li><span class="icon flaticon-money"></span> $99 / hour</li> --}}
                <li><span class="icon flaticon-clock"></span> Terdaftar pada {{Sideveloper::dateFull($data->created_date)}}</li>
              </ul>
              <ul class="post-tags">
                @foreach($skill as $s)
                <li><a href="#">{{$s->nama_choice}}</a></li>
                @endforeach
              </ul>
            </div>

            <div class="btn-box">
              {{-- <a href="{{url('pencari-kerja/profil-ubah')}}" class="theme-btn btn-style-one"><i class="la la-pencil"></i> &nbsp; &nbsp;Ubah Profil</a> --}}
              {{-- <button class="bookmark-btn"><i class="flaticon-bookmark"></i></button> --}}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="candidate-detail-outer">
      <div class="auto-container">
        <div class="row">
          <div class="content-column col-lg-8 col-md-12 col-sm-12">
            <div class="job-detail">
              <h4>Bio</h4>
              {!!$data->deskripsi ?? '-'!!}
              <!-- Resume / Education -->
              <div class="resume-outer">
                <div class="upper-title">
                  <h4>Pendidikan</h4>
                  {{-- <a href="{{url('pencari-kerja/modal?tipe=1')}}" class="add-info-btn call-modal"><span class="icon flaticon-plus"></span> Tambah Pendidikan</a> --}}
                </div>
                @forelse($pendidikan as $p)
                <!-- Resume BLock -->
                <div class="resume-block">
                    <div class="inner">
                        <span class="name"><i class="la la-graduation-cap"></i></span>
                        <div class="title-box">
                            <div class="info-box">
                                <h3>{{$p->tempat}}</h3>
                                <span>{{$p->judul}}</span>
                            </div>
                            <div class="edit-box">
                                <span class="year">{{Sideveloper::bulanTahun($p->tgl_start)}} - {{Sideveloper::bulanTahun($p->tgl_end)}}</span>
                                <div class="edit-btns">
                                  {{-- <a href="{{url('pencari-kerja/modal?tipe=1&id='.$p->id_profil_multiple_big)}}" class="call-modal"><span class="la la-pencil"></span></a> --}}
                                  {{-- <button onclick="hapusModal(1, '{{$p->id_profil_multiple_big}}')"><span class="la la-trash"></span></button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="text">{{$p->deskripsi}}</div>
                    </div>
                </div>
                @empty
                <div class="resume-block">
                    <div class="inner">
                      <span class="name">-</span>
                    </div>
                </div>
                @endforelse
            </div>
            <!-- Resume / Education -->
            <div class="resume-outer theme-blue">
                <div class="upper-title">
                <h4>Pengalaman Kerja</h4>
                {{-- <a href="{{url('pencari-kerja/modal?tipe=2')}}" class="add-info-btn call-modal"><span class="icon flaticon-plus"></span> Tambah Pengalaman Kerja</a> --}}
                </div>
                @forelse($pengalaman as $p)
                <!-- Resume BLock -->
                <div class="resume-block">
                    <div class="inner">
                        <span class="name"><i class="la la-graduation-cap"></i></span>
                        <div class="title-box">
                            <div class="info-box">
                                <h3>{{$p->judul}}</h3>
                                <span>{{$p->tempat}}</span>
                            </div>
                            <div class="edit-box">
                                <span class="year">{{Sideveloper::bulanTahun($p->tgl_start)}} - {{Sideveloper::bulanTahun($p->tgl_end)}}</span>
                                <div class="edit-btns">
                                  {{-- <a href="{{url('pencari-kerja/modal?tipe=2&id='.$p->id_profil_multiple_big)}}" class="call-modal"><span class="la la-pencil"></span></a>
                                  <button onclick="hapusModal(2, '{{$p->id_profil_multiple_big}}')"><span class="la la-trash"></span></button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="text">{{$p->deskripsi}}</div>
                    </div>
                </div>
                @empty
                <div class="resume-block">
                    <div class="inner">
                    <span class="name">-</span>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Resume / Education -->
            <div class="resume-outer theme-yellow">
                <div class="upper-title">
                <h4>Sertifikasi & Penghargaan</h4>
                {{-- <a href="{{url('pencari-kerja/modal?tipe=3')}}" class="add-info-btn call-modal"><span class="icon flaticon-plus"></span> Tambah Sertifikasi & Penghargaan</a> --}}
                </div>
                @forelse($sertifikasi as $p)
                <!-- Resume BLock -->
                <div class="resume-block">
                    <div class="inner">
                        <span class="name"><i class="la la-graduation-cap"></i></span>
                        <div class="title-box">
                            <div class="info-box">
                                <h3>{{$p->tempat}}</h3>
                                <span>{{$p->judul}}</span>
                            </div>
                            <div class="edit-box">
                                <span class="year">{{Sideveloper::bulanTahun($p->tgl_start)}} - {{Sideveloper::bulanTahun($p->tgl_end)}}</span>
                                <div class="edit-btns">
                                  {{-- <a href="{{url('pencari-kerja/modal?tipe=3&id='.$p->id_profil_multiple_big)}}" class="call-modal"><span class="la la-pencil"></span></a> --}}
                                  {{-- <button onclick="hapusModal(3, '{{$p->id_profil_multiple_big}}')"><span class="la la-trash"></span></button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="text">{{$p->deskripsi}}</div>
                    </div>
                </div>
                @empty
                <div class="resume-block">
                    <div class="inner">
                    <span class="name">-</span>
                    </div>
                </div>
                @endforelse
            </div>



            </div>
          </div>

          <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
            <aside class="sidebar">
              <div class="sidebar-widget">
                <div class="widget-content">
                  <ul class="job-overview">
                    <li>
                      <i class="icon icon-calendar"></i>
                      <h5>Pengalaman:</h5>
                      <span>{{$data->pengalaman_kerja ?? '-'}}</span>
                    </li>

                    <li>
                      <i class="icon icon-expiry"></i>
                      <h5>Umur:</h5>
                      <span>{{$data->umur ?? '-'}} Tahun</span>
                    </li>

                    <li>
                      <i class="icon icon-user-2"></i>
                      <h5>Jenis Kelamin:</h5>
                      <span>{{$data->jenis_kelamin ?? '-'}} </span>
                    </li>

                    <li>
                      <i class="icon icon-language"></i>
                      <h5>Bahasa:</h5>
                      <span>{{$bahasa ?? '-'}}</span>
                    </li>

                    <li>
                      <i class="icon icon-degree"></i>
                      <h5>Pendidikan:</h5>
                      <span>{{$data->pendidikan_terakhir ?? '-'}}</span>
                    </li>

                    <li>
                      <i class="icon la la-ring" style="font-size: 2em;color:#2467D2;"></i>
                      <h5>Status Pernikahan:</h5>
                      <span>{{$data->status_pernikahan ?? '-'}}</span>
                    </li>

                  </ul>
                </div>

              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End candidate Detail Section -->