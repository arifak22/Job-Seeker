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
                        {!!Sideveloper::formFile('Gambar', 'foto', "accept=\"image/*\"", "Maksimal 200kb, Upload Gambar. (Image: png / jpg)", $data->foto)!!}
                      <div class="row">
                        <div class="col-lg-6 col-md-12">
                            {!!Sideveloper::formInput('Nama Lengkap','text','nama', $data->nama)!!}
                            {!!Sideveloper::formInput('Nomor HP','text','no_hp', $data->no_hp)!!}
                            {!!Sideveloper::formSelect('Bidang Usaha', $bidang_option, 'id_bidang', $data->id_bidang)!!}
                        </div>
                        <div class="col-lg-6 col-md-12">
                            {!!Sideveloper::formSelect('Tahun Berdiri', $tahun_option, 'tahun_berdiri', $data->tahun_berdiri)!!}
                            {!!Sideveloper::formInput('Website','text','website', $data->website)!!}
                            {!!Sideveloper::formInput('Pegawai Lokal','number','pegawai_lokal', $data->pegawai_lokal)!!}
                            {!!Sideveloper::formInput('Pegawai Asing','number','pegawai_asing', $data->pegawai_asing)!!}
                        </div>
                        <div class="col-lg-12 col-md-12">
                            {!!Sideveloper::formText('Deskripsi','deskripsi',$data->deskripsi, "class='freetext'")!!}
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
      <script src="https://cdn.tiny.cloud/1/6bnyu9es2n9s02rnhy2ixhvcu4312ktw5mwmr8ay8fp5e25i/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
      <script>
        tinymce.init({
            selector: 'textarea.freetext',
            height: 400,
            removed_menuitems: 'fontformats',
            paste_data_images: false,
            images_upload_credentials: false,
            content_style: "body {font-size: 10pt;}"
        });
       $(document).ready(function(){
            getKelurahan("{{$data->id_kelurahan}}");
        })
         $("#id_kecamatan").change(function(){
            getKelurahan();
        });
        function getKelurahan(defaultvalue = '', next = '', next2 = ''){
            console.log('testt');
            var tag  = $("#id_kelurahan");
            var url  = "{{url('option')}}";
            var data = {
                search: 'kelurahan',
                id    : $("#id_kecamatan").val(),
            };
            getOption(tag, url, data, null, defaultvalue);
        }


        $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
            var tinyx = tinymce.get("deskripsi").getContent();
            var tinyx = tinyx.replace(/<script>/g, "");
            var tinyx = tinyx.replace(/<\/script>/g, "");
            tinymce.get("deskripsi").setContent(tinyx);
            
            tinyMCE.get('deskripsi').save();
            form.validate({
                rules: {
                    nama: {
                        required : true,
                        maxlength: 200,
                    },
                    id_bidang: {
                        required: true,
                    },
                    no_hp: {
                        required: true,
                        maxlength: 13,
                        minlength: 8,
                    },
                    tahun_berdiri: {
                        required: true,
                    },
                    website: {
                        required: true,
                        maxlength: 200,
                    },
                    pegawai_lokal: {
                        required: true,
                        min     : 0,
                    },
                    pegawai_asing: {
                        required: true,
                        min     : 0,
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
                url    : "{{url('api/perusahaan/profil-ubah')}}",
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
                                $(location).prop('href', "{{url('perusahaan/profil')}}")
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