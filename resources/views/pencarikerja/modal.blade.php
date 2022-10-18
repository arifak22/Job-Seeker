
<div class="model">
    <!-- Login modal -->
    <div id="default-modal">
      <!-- Login Form -->
      <div class="login-form default-form">
        <div class="form-inner">
          <h3>{{$title}}</h3>
          <!--Login Form-->
          <form>
            {!!Sideveloper::formHidden('id', @$data->id)!!}
            @if($tipe == 1)
            {!!Sideveloper::formSelect('Tingkat', $pendidikan_option, 'id_pendidikan', @$data->id_level)!!}
            @endif
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    {!!Sideveloper::formInput($tempat,'text','tempat',  @$data->tempat)!!}
                    {!!Sideveloper::formInput('Mulai','text','tgl_start', @$data->tgl_start, 'readonly')!!}
                </div>
                <div class="col-lg-6 col-md-12">
                    {!!Sideveloper::formInput($judul,'text','judul',  @$data->judul)!!}
                    {!!Sideveloper::formInput('Selesai','text','tgl_end',  @$data->tgl_end, 'readonly')!!}
                </div>
            </div><br>
            {!!Sideveloper::formText('Detil','detil', @$data->deskripsi)!!}
            <div class="form-group">
              <button class="theme-btn btn-style-one" type="submit" id="submit">Simpan</button>
            </div>
          </form>
        </div>
      </div>
      <!--End Login Form -->
    </div>
    <script>
       $(document).ready(function(){
            $.datetimepicker.setLocale('id');
            $('#tgl_start, #tgl_end').datetimepicker(
                {
                    timepicker:false,
                    format:'Y-m-d'
                }
            );
        });

        $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
            form.validate({
                rules: {
                    tempat: {
                        required : true,
                        maxlength: 200,
                    },
                    judul: {
                        maxlength: 200,
                    },
                    tgl_start: {
                        required: true,
                        maxlength: 10,
                        minlength: 10,
                    },
                    tgl_end: {
                        required: true,
                        maxlength: 10,
                        minlength: 10,
                    },
                    detil: {
                        maxlength: 2000,
                    },
                }
            });
            if (!form.valid()) {
                return;
            }
            apiLoading(true, btn);
            form.ajaxSubmit({
                url    : "{{url('api/pencari-kerja/detil-add')}}",
                type   : 'POST',
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('jwt_token')
                },
                data: { tipe: "{{$tipe}}" },
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
    <!-- End Login Module -->
</div>