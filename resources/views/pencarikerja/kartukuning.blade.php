<style>
    .status-list li:before {
        background: #32a852;
    }
</style>
<!-- Dashboard -->
<section class="user-dashboard">
    <div class="dashboard-outer">
        <div class="row">
        <div class="col-lg-12">
            <!-- Ls widget -->
            <div class="ls-widget">
            <div class="tabs-box">
                <div class="widget-title">
                <h4>Kartu Kuning</h4>
                </div>
                <div class="widget-content">
                <form class="default-form">
                    <h5>Lampiran</h5><br>
                    {!!Sideveloper::formFile('Pas Foto', 'foto', "accept=\"image/*\"", "Maksimal 200kb, Upload Pas Foto 3x4. (Image: png / jpg)", $data->pas_foto)!!}
                    {!!Sideveloper::formFile('Ijazah', 'ijazah', "accept=\"image/*\"", "Maksimal 200kb, Upload Ijazah. (Image: png / jpg)", $data->file_ijazah)!!}
                    {!!Sideveloper::formFile('KTP', 'ktp', "accept=\"image/*\"", "Maksimal 200kb, Upload KTP. (Image: png / jpg)", $data->file_ktp)!!}
                    {!!Sideveloper::formFile('Kartu Keluarga', 'kk', "accept=\"image/*\"", "Maksimal 200kb, Upload KK. (Image: png / jpg)", $data->file_kk)!!}
                    @if($data->verified_status=='DONE')
                    {!!Sideveloper::formFile('Kartu Kuning', 'Kartu Kuning', "accept=\"image/*\"", "Maksimal 200kb, Upload Kartu Kuning. (Image: png / jpg)", $data->file_kartu_kuning)!!}
                    @endif
                    <div class="row">
                    <div class="col-lg-6 col-md-12">
                        {!!Sideveloper::formInput('Nomor Ijazah','text','no_ijazah', $data->no_ijazah)!!}
                    </div>
                    <div class="col-lg-6 col-md-12">
                        {!!Sideveloper::formInput('Tanggal Ijazah','text','tgl_ijazah', $data->tgl_ijazah, 'readonly')!!}
                    </div>
                    <div class="col-lg-12 col-md-12">
                        {!!Sideveloper::formInput('NIK','text','nik', $data->nik)!!}
                        {!!Sideveloper::formInput('Nomor KK','text','no_kk', $data->no_kk)!!}
                    </div>
                    <?php
                    $passStatus = ['DRAFT', 'KIRIM', 'TOLAK'];
                    ?>
                    @if(in_array($data->verified_status,$passStatus))
                    {!!Sideveloper::formSelect('Ajukan Kartu Kuning', array(array('value'=>'DRAFT', 'name'=>'Draft'), array('value'=>'KIRIM', 'name'=> 'Kirim Pengajuan')), 'verified_status', $data->verified_status)!!}
                    @endif
                    @if($data->verified_status != 'TOLAK')
                    <h4>Langkah - langkah Pengajuan Kartu Kuning</h4>
                    @endif
                    <ul class="list-style-four" style="margin-top: 10px;">
                        <?php
                        $number = 0;
                        if($data->verified_status == 'DRAFT')
                        $number = 1;
                        if($data->verified_status == 'KIRIM')
                        $number = 2;
                        if($data->verified_status == 'APPROVED_ONLINE')
                        $number = 3;
                        if($data->verified_status == 'RECIVED')
                        $number = 4;
                        if($data->verified_status == 'DONE')
                        $number = 5;
                        if($data->verified_status == 'TOLAK'):
                        ?>
                        <span class="status-list"><li style="margin-bottom: 10px;">Ditolak, coba ajukan ulang (Alasan: {{$data->verified_catatan}})</li></span>
                        <?php else: ?>
                        <span <?=$number > 0 ? 'class="status-list"' : ''?>><li style="margin-bottom: 10px;">Upload dokumen-dokumen dan isi form</li></span>
                        <span <?=$number > 1 ? 'class="status-list"' : ''?>><li style="margin-bottom: 10px">Kirim pengajuan dokumen dan form</li></span>
                        <span <?=$number > 2 ? 'class="status-list"' : ''?>><li style="margin-bottom: 10px">Dokumen terverifikasi online</li></span>
                        <span <?=$number > 3 ? 'class="status-list"' : ''?>><li style="margin-bottom: 10px">Mengumpulkan dokumen cetak</li></span>
                        <span <?=$number > 4 ? 'class="status-list"' : ''?>><li style="margin-bottom: 10px">Berhasil terverifikasi</li></span>
                        <?php endif;?>
                    </ul>
                    <br>
                    @if(in_array($data->verified_status,$passStatus))
                    <div class="form-group col-lg-6 col-md-12">
                        <button class="theme-btn btn-style-one" type="submit" id="submit">Simpan</button>
                    </div>
                    @endif
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
        
        jQuery.datetimepicker.setLocale('id');
        $('#tgl_ijazah').datetimepicker({
            timepicker:false,
            format:'Y-m-d'
        });
        $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
            form.validate({
                rules: {
                    no_ijazah: {
                        required : true,
                        maxlength: 100,
                    },
                    nik: {
                        required : true,
                        maxlength: 100,
                    },
                    no_kk: {
                        required : true,
                        maxlength: 100,
                    },
                    tgl_ijazah: {
                        required: true,
                        maxlength: 10,
                        minlength: 10,
                    },
                }
            });
            if (!form.valid()) {
                return;
            }
            apiLoading(true, btn);
            form.ajaxSubmit({
                url    : "{{url('api/pencari-kerja/kartu-kuning-pengajuan')}}",
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
                                $(location).prop('href', "{{url('pencari-kerja/kartu-kuning')}}")
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