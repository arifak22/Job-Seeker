    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
          <div class="row">
            <div class="col-lg-12">
              <!-- Ls widget -->
              <div class="ls-widget">
                <div class="tabs-box">
                  <div class="widget-title">
                    <h4>Ubah Profil</h4>
                  </div>
  
                  <div class="widget-content">
  
                    <form class="default-form">
                        <div class="uploading-outer">
                            <div class="uploadButton">
                                <input class="uploadButton-input" type="file" name="gambar" accept="image/*" id="upload" />
                                <label class="uploadButton-button ripple-effect" for="upload">Gambar</label>
                                <span class="uploadButton-file-name"></span>
                            </div>
                            <div class="text">Maksimal 200kb, Upload Image File.</div>
                        </div>
                      <div class="row">
                        <div class="col-lg-6 col-md-12">
                            {!!Sideveloper::formInput('Nama Lengkap','text','nama', $data->nama)!!}
                            {!!Sideveloper::formInput('Tanggal Lahir','text','tanggal_lahir', $data->tanggal_lahir, 'readonly')!!}
                            {!!Sideveloper::formSelect('Pendidikan Terakhir', $pendidikan_option, 'id_pendidikan', $data->id_pendidikan)!!}
                            {!!Sideveloper::formInput('Nomor HP','text','no_hp', $data->no_hp)!!}
                            {!!Sideveloper::formSelect('Keahlian', $keahlian_option, 'id_keahlian', $profil_keahlian, true)!!}
                        </div>
                        <div class="col-lg-6 col-md-12">
                            {!!Sideveloper::formInput('Pengalaman Kerja','text','pengalaman_kerja', $data->pengalaman_kerja)!!}
                            {!!Sideveloper::formSelect('Jenis Kelamin', array(array('value'=>'Laki-laki', 'name'=>'Laki-laki'), array('value'=>'Perempuan', 'name'=> 'Perempuan')), 'jenis_kelamin', $data->jenis_kelamin)!!}
                            {!!Sideveloper::formInput('Jurusan','text','jurusan', $data->jurusan)!!}
                            {!!Sideveloper::formSelect('Status Menikah', array(array('value'=>'Belum Menikah', 'name'=>'Belum Menikah'), array('value'=>'Menikah', 'name'=> 'Menikah')), 'status_pernikahan', $data->status_pernikahan)!!}
                            {!!Sideveloper::formSelect('Bahasa', $bahasa_option, 'id_bahasa', $profil_bahasa, true)!!}
                        </div>
                        <div class="col-lg-12 col-md-12">
                            {!!Sideveloper::formText('Deskripsi','deskripsi',$data->deskripsi)!!}
                        </div>
                        <!-- About Company -->
                        <div class="form-group col-lg-12 col-md-12" style="margin-bottom:0">
                            <label>Alamat</label>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            {!!Sideveloper::formSelect('Kecamatan', $kecamatan_option, 'id_kecamatan', $data->id_kecamatan)!!}
                        </div>
                        <div class="col-lg-6 col-md-12">
                            {!!Sideveloper::formSelect('Kelurahan', null, 'id_kelurahan', null, false, '')!!}
                        </div>

                        <div class="col-lg-12 col-md-12">
                            {!!Sideveloper::formText('Detil Alamat','alamat',$data->alamat)!!}
                        </div>
                        <!-- Input -->
                        <div class="form-group col-lg-6 col-md-12">
                          <button class="theme-btn btn-style-one" type="submit" id="submit">Simpan</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End Dashboard -->
     
      <script>
       $(document).ready(function(){
            jQuery.datetimepicker.setLocale('id');
            getKelurahan("{{$data->id_kelurahan}}");
            $('#tanggal_lahir').datetimepicker(
                {
                    timepicker:false,
                    format:'Y-m-d'
                }
            );
        })
         $("#id_kecamatan").change(function(){
            getKelurahan();
        });
        function getKelurahan(defaultvalue = '', next = '', next2 = ''){
            console.log('testt');
            var tag  = $("#id_kelurahan");
            var url  = "{{url('option')}}";
            var data = {
                search: 'kelurahaan',
                id    : $("#id_kecamatan").val(),
            };
            getOption(tag, url, data, null, defaultvalue);
        }


        $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
            form.validate({
                rules: {
                    nama: {
                        required : true,
                        maxlength: 200,
                    },
                    tanggal_lahir: {
                        required: true,
                        maxlength: 10,
                        minlength: 10,
                    },
                    id_pendidikan: {
                        required: true,
                    },
                    no_hp: {
                        required: true,
                        maxlength: 13,
                        minlength: 8,
                    },
                    pengalaman_kerja: {
                        required: true,
                        maxlength: 100,
                    },
                    jenis_kelamin: {
                        required: true,
                    },
                    status_pernikahan: {
                        required: true,
                    },
                    jurusan: {
                        required: true,
                        maxlength: 100,
                    },
                    deskripsi: {
                        required: true,
                        maxlength: 2000,
                    },
                    id_kecamatan: {
                        required: true,
                    },
                    id_kelurahan: {
                        required: true,
                    },
                    alamat: {
                        required: true,
                        maxlength: 2000,
                    },
                }
            });
            if (!form.valid()) {
                return;
            }
            apiLoading(true, btn);
            form.ajaxSubmit({
                url    : "{{url('api/pencari-kerja/profil-ubah')}}",
                type   : 'POST',
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('jwt_token')
                },
                success: function(response) {
                    apiLoading(false, btn);
                    apiRespone(
                        response,
                        false,
                        (res) => {
                            if(res.api_status == '1'){
                                $(location).prop('href', "{{url('pencari-kerja/profil')}}")
                            }
                        }
                    );
                    console.log(response)
                },
                error: function(error){
                    apiLoading(false, btn);
                    swal(error.statusText);
                }
            });
        });
      </script>