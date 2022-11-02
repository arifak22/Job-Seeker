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
                <h4>KARTU AK.1 (Kartu Kuning)</h4>
                </div>
                <div class="widget-content">
                @if($data->verified_status=='DONE')
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
                @else
                <form class="default-form">
                    <h5>Lampiran</h5><br>
                    {!!Sideveloper::formFile('Pas Foto', 'foto', "accept=\"image/*\"", "Maksimal 200kb, Upload Pas Foto 3x4. (Image: png / jpg)", $data->pas_foto)!!}
                    {!!Sideveloper::formFile('Ijazah', 'ijazah', "accept=\"image/*\"", "Maksimal 200kb, Upload Ijazah. (Image: png / jpg)", $data->file_ijazah)!!}
                    {!!Sideveloper::formFile('KTP', 'ktp', "accept=\"image/*\"", "Maksimal 200kb, Upload KTP. (Image: png / jpg)", $data->file_ktp)!!}
                    {!!Sideveloper::formFile('Kartu Keluarga', 'kk', "accept=\"image/*\"", "Maksimal 200kb, Upload KK. (Image: png / jpg)", $data->file_kk)!!}
                    @if($data->verified_status=='DONE')
                    {!!Sideveloper::formFile('KARTU AK.1 (Kartu Kuning)', 'KARTU AK.1 (Kartu Kuning)', "accept=\"image/*\"", "Maksimal 200kb, Upload Kartu Kuning. (Image: png / jpg)", $data->file_kartu_kuning)!!}
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
                    {!!Sideveloper::formSelect('Ajukan KARTU AK.1 (Kartu Kuning)', array(array('value'=>'DRAFT', 'name'=>'Draft'), array('value'=>'KIRIM', 'name'=> 'Kirim Pengajuan')), 'verified_status', $data->verified_status)!!}
                    @endif
                    @if($data->verified_status != 'TOLAK')
                    <h4>Langkah - langkah Pengajuan KARTU AK.1 (Kartu Kuning)</h4>
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
                @endif
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

var tableList = $('#table_id').DataTable({
    processing   : true,
    serverSide   : true,
    bLengthChange: false,
    bFilter      : true,
    pageLength   : 50,
    // order        : [[2,'desc']],
    ajax         : {
        url  : "{{url('api/pencari-kerja/kartu-kuning-list')}}",
        type : "get",   
        headers: {
            "Authorization": "Bearer " + localStorage.getItem('jwt_token')
        },
        error: function(){ 
            $(".employee-grid-error").html("");
            $("#data-list").append('<tbody class="employee-grid-error"><tr><th colspan="3"><center>Internal Server Error</center></th></tr></tbody>');
            $("#data-list_processing").css("display","none");
        }
    },
    columns : [
        { "data" : "id", "name" : "kartu_kuning.id" },
        { "data" : "status_text", "name" : "kartu_kuning.verified_status"},
        { "data" : "nik", "name" : "kartu_kuning.nik"},
        { "data" : "nama", "name" : "users.nama" },
    ],
    initComplete: function () {
        this.api().columns().every(function () {
            var column = this;
            if(column[0] != 0){
                var input = '<input class="form-control">';
                if(column[0] == 1){
                    input = `<select class="form-control">
                                <option value=""> -Semua- </option>
                                <option value="TOLAK"> Ditolak </option>
                                <option value="KIRIM"> Pengajuan </option>
                                <option value="DONE"> Selesai </option>
                                <option value="RECIVED"> Dokumen Asli Diterima </option>
                                <option value="APPROVED_ONLINE"> Dokumen Online Terverfikasi </option>
                                <option value="KIRIM"> Pengajuan </option>
                            </select>
                            `;
                    input = '';
                }
                // console.log(column[0]);
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
                });
            }
        });
    },
    // createdRow: function( row, data, dataIndex){
    //     if( data.status ==  `N`){
    //         $(row).addClass('redClass');
    //     }
    //     console.log(data);
    // },
    columnDefs: [
        {
            targets : 0,
            orderable: false, 
            data: "id",
            render: function ( data, type, row, meta ) {
                return `<div class="option-box">
                            <ul class="option-list">
                            <li><button data-text="Detail" onclick="lihat(${data}, '${row.verified_status}')"><span class="la la-eye"></span></button></li>
                            </ul>
                        </div>`;
            }
        },
        {
            targets : 1,
            orderable: false, 
            data: "status_text",
            render: function ( data, type, row, meta ) {
                return `<span style="color:${row.status_color};background:${row.status_color}33; padding:5px 20px;border-radius:50px;">${data}</span>`;
            }
        },
],
});
</script>