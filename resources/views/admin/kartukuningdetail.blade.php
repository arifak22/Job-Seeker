<!-- Dashboard -->
<section class="user-dashboard">
    <div class="dashboard-outer">
        <div class="upper-title-box">
            <h3>Verifikasi KARTU AK.1 (Kartu Kuning)</h3>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- Ls widget -->
                <div class="ls-widget">
                    <div class="tabs-box">
                        <div class="widget-title">
                        <h4></h4>
                        </div>
                        <div class="widget-content">
                            <form class="default-form">
                                @if($data->verified_status != 'DONE')
                                {!!Sideveloper::formHidden('id', $data->id)!!}
                                {!!Sideveloper::formSelect('Status Pengajuan', array(array('value'=>'TOLAK', 'name'=>'Tolak Pengajuan'), array('value'=>'KIRIM', 'name'=>'Pengajuan'), array('value'=>'APPROVED_ONLINE', 'name'=> 'Dokumen Online Terverifikasi'), array('value'=>'RECIVED', 'name'=> 'Dokumen Asli Diterima'), array('value'=>'DONE', 'name'=> 'Selesai')), 'verified_status', $data->verified_status)!!}
                                {!!Sideveloper::formText('Alasan Tolak','verified_catatan',$data->verified_catatan)!!}
                                {!!Sideveloper::formFile('KARTU AK.1 (Kartu Kuning)', 'file_kartu_kuning', "accept=\"image/*\"", "Maksimal 200kb, Upload KARTU AK.1 (Kartu Kuning). (Image: png / jpg)", $data->file_kartu_kuning)!!}
                                <button class="theme-btn btn-style-one" type="submit" id="submit" style="margin-bottom:30px">Simpan</button>
                                @endif
                                <div class="table-outer">
                                    <table class="default-table manage-job-table">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>File</th>
                                            </tr>
                                        </thead>
                
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align:top">
                                                    <b>Nama : {{$data->nama}}</b>
                                                </td>
                                                <td>
                                                    <a target="_blank" href="{{Sideveloper::storageUrl($data->pas_foto)}}"><img style="height: 120px;margin-right:10px;" src="{{Sideveloper::storageUrl($data->pas_foto)}}"></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top">
                                                    <b>Nomor NIK : {{$data->nik}}</b>
                                                </td>
                                                <td>
                                                    <a target="_blank" href="{{Sideveloper::storageUrl($data->file_ktp)}}"><img style="height: 120px;margin-right:10px;" src="{{Sideveloper::storageUrl($data->file_ktp)}}"></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top">
                                                    <b>Nomor KK : {{$data->no_kk}}</b>
                                                </td>
                                                <td>
                                                    <a target="_blank" href="{{Sideveloper::storageUrl($data->file_kk)}}"><img style="height: 120px;margin-right:10px;" src="{{Sideveloper::storageUrl($data->file_kk)}}"></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top">
                                                    <b>Nomor Ijazah : {{$data->no_ijazah}}</b>
                                                    <br>Tanggal : {{$data->tgl_ijazah}}
                                                </td>
                                                <td>
                                                    <a target="_blank" href="{{Sideveloper::storageUrl($data->file_ijazah)}}"><img style="height: 120px;margin-right:10px;" src="{{Sideveloper::storageUrl($data->file_ijazah)}}"></a>
                                                </td>
                                            </tr>
                                            @if($data->verified_status == 'DONE')
                                                <tr>
                                                    <td style="vertical-align:top">
                                                        <b>KARTU AK.1 (Kartu Kuning)</b>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="{{Sideveloper::storageUrl($data->file_kartu_kuning)}}"><img style="height: 120px;margin-right:10px;" src="{{Sideveloper::storageUrl($data->file_kartu_kuning)}}"></a>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $("#form-verified_catatan").hide();
        $("#form-file_kartu_kuning").hide();
    })
    $("#verified_status").change(function(){
        if($(this).val() == 'TOLAK'){
            $("#form-verified_catatan").show();
            $("#form-file_kartu_kuning").hide();
        }else if($(this).val() == 'DONE'){
            $("#form-file_kartu_kuning").show();
            $("#form-verified_catatan").hide();
        }else{
            $("#form-verified_catatan").hide();
            $("#form-file_kartu_kuning").hide();
        }
    });

    $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
            form.validate({
                rules: {
                    verified_status: {
                        required : true,
                    },
                    verified_catatan: {
                        maxlength: 200,
                    },
                }
            });
            if (!form.valid()) {
                return;
            }
            apiLoading(true, btn);
            form.ajaxSubmit({
                url    : "{{url('api/admin/kartu-kuning-verifikasi')}}",
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
                                $(location).prop('href', "{{url('admin/kartu-kuning-verifikasi')}}")
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