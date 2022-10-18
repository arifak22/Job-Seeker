<style>
    .title-form{
        font-size: 15px;
        line-height: 20px;
        color: #202124;
        font-weight: 500;
        margin-bottom: 10px;
    }
</style>
<!-- Dashboard -->
<section class="user-dashboard">
    <div class="dashboard-outer">
        <div class="upper-title-box">
            <h3>Posting Lowongan Pekerjaan</h3>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- Ls widget -->
                <div class="ls-widget">
                    <div class="tabs-box">
                        <div class="widget-content" style="padding-top: 30px">
                            <form class="default-form">
                                {!!Sideveloper::formHidden('id', $data->id ?? '')!!}
                                {!!Sideveloper::formInput('Judul Lowongan Pekerjaan','text','judul', $data->judul ?? '')!!}
                                {!!Sideveloper::formText('Deskripsi','deskripsi',$data->deskripsi ?? '', "class='freetext'")!!}
                                <table class="default-table manage-job-table" id="detil-deskripsi">
                                    <thead>
                                        <tr>
                                            <th width="2%"></th>
                                            <th>
                                                DETIL DESKRIPSI TAMBAHAN
                                            </th>
                                            <th width="5%">
                                                <button type="button" class="btn btn-info pull-right" onclick="addDeskripsi()" data-text="Tambah Detil Deskripsi" style="color: white"><span class="la la-plus"></span></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($deskripsi as $key => $d)
                                        <tr data-id="{{$key}}">
                                            <td>
                                                <i class="la la-list"></i>
                                            </td>
                                            <td class="form-group">
                                                <input type="text" name="judul_multiple[{{$key}}]" value="{{$d->judul_deskripsi}}" placeholder="Syarat &amp; Ketentuan">
                                                <div class="body-row">
                                                    @foreach(DB::table('loker_deskripsi_detil')->where('id_loker_deskripsi',$d->id)->get() as $dd)
                                                    <div class="row" style="margin-top:10px;">
                                                        <div class="col-md-11">
                                                            <input type="text" name="deskripsi_multiple[{{$key}}][]" value="{{$dd->keterangan}}" placeholder="Deskripsi">
                                                        </div>
                                                        <div class="col-md-1" style="margin: auto;">
                                                            <div class="option-box">
                                                                <ul class="option-list">
                                                                    <li><button type="button" class="hapusDetil" data-text="Hapus Deskripsi"><span class="la la-trash"></span></button></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                <div class="option-box">
                                                    <ul class="option-list">
                                                        <li><button type="button" class="addDetil" data-text="Tambah Deskripsi"><span class="la la-plus"></span></button></li>
                                                        <li><button type="button" onclick="hapusDeskripsi(this)" data-text="Hapus Detil Deskripsi"><span class="la la-trash"></span></button></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr data-id="0">
                                            <td>
                                                <i class="la la-list"></i>
                                            </td>
                                            <td class="form-group">
                                                <input type="text" name="judul_multiple[0]" value="" placeholder="Syarat &amp; Ketentuan">
                                                <div class="body-row">
                                                    <div class="row" style="margin-top:10px;">
                                                        <div class="col-md-11">
                                                            <input type="text" name="deskripsi_multiple[0][]" placeholder="Deskripsi">
                                                        </div>
                                                        <div class="col-md-1" style="margin: auto;">
                                                            <div class="option-box">
                                                                <ul class="option-list">
                                                                    <li><button type="button" class="hapusDetil" data-text="Hapus Deskripsi"><span class="la la-trash"></span></button></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="option-box">
                                                    <ul class="option-list">
                                                        <li><button type="button" class="addDetil" data-text="Tambah Deskripsi"><span class="la la-plus"></span></button></li>
                                                        <li><button type="button" onclick="hapusDeskripsi(this)" data-text="Hapus Detil Deskripsi"><span class="la la-trash"></span></button></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {!!Sideveloper::formInput('Batas Akhir Melamar','text','tanggal_kadaluarsa', $data->tanggal_kadaluarsa ?? '', 'readonly')!!}
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        {!!Sideveloper::formSelect('Jenis Kelamin', array(array('value'=>'', 'name'=>'-Semua-'), array('value'=>'Laki-laki', 'name'=>'Laki-laki'), array('value'=>'Perempuan', 'name'=> 'Perempuan')), 'jenis_kelamin', $data->jenis_kelamin ?? '')!!}
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        {!!Sideveloper::formSelect('Jenis Pekerjaan', $jenis_option, 'id_jenis_pekerjaan', $data->id_jenis_pekerjaan ?? '')!!}
                                    </div>
                                </div>
                                <span class="title-form">LOKASI</span>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        {!!Sideveloper::formSelect('Kecamatan', $kecamatan_option, 'id_kecamatan', $data->id_kecamatan ?? '')!!}
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        {!!Sideveloper::formSelect('Kelurahan', null, 'id_kelurahan', null, false, '')!!}
                                    </div>
                                </div>
                                <span class="title-form">TAMBAHAN</span>
                                {!!Sideveloper::formSelect('Minimal Pendidikan', $pendidikan_option, 'id_pendidikan', $data->id_pendidikan ?? '')!!}
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        {!!Sideveloper::formSelect('Keahlian', $keahlian_option, 'id_keahlian', $profil_keahlian, true)!!}
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        {!!Sideveloper::formSelect('Bahasa', $bahasa_option, 'id_bahasa', $profil_bahasa, true)!!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        {!!Sideveloper::formSelect('Show Gaji', array(array('value'=>'T', 'name'=>'Sembunyikan'), array('value'=>'Y', 'name'=>'Perlihatkan Gaji')), 'show_gaji', $data->show_gaji ?? '')!!}
                                    </div>
                                    <div class="col-lg-6 col-md-12" class="show-gaji">
                                        {!!Sideveloper::formSelect('Jenis Gaji', array( array('value'=>'fix', 'name'=>'Fix'), array('value'=>'over', 'name'=>'Over'), array('value'=>'range', 'name'=>'Range')), 'jenis_gaji', $data->jenis_gaji ?? '')!!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12" class="show-gaji">
                                        {!!Sideveloper::formInput('Gaji','text','gaji', $data->gaji ?? '')!!}
                                    </div>
                                    <div class="col-lg-6 col-md-12" id="showGajiMax">
                                        {!!Sideveloper::formInput('Gaji Maksimum','text','gaji_max', $data->gaji_max ?? '')!!}
                                    </div>
                                </div>
                                {!!Sideveloper::formSelect('Status Loker', array(array('value'=>'DRAFT', 'name'=>'Draft'), array('value'=>'POST', 'name'=>'Posting')), 'status_loker', $data->status_loker ?? '')!!}
                                <!-- Input -->
                                <div class="form-group col-lg-6 col-md-12">
                                    <button class="theme-btn btn-style-one" type="submit" id="submit">Simpan</button>
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

var i = "{{$i}}";
function makeDeskripsi(value=''){
    var valueDetil = makeDetil(i);
    var valueDeskripsi = `
        <tr data-id="${i}">
            <td>
                <i class="la la-list"></i>
            </td>
            <td class="form-group">
                <input type="text" name="judul_multiple[${i}]" value="${value}" placeholder="Syarat & Ketentuan">
                <div class="body-row">
                    ${valueDetil}
                </div>
            </td>
            <td>
                <div class="option-box">
                    <ul class="option-list">
                        <li><button type="button" class="addDetil" data-text="Tambah Deskripsi"><span class="la la-plus"></span></button></li>
                        <li><button type="button" onclick="hapusDeskripsi(this)" data-text="Hapus Detil Deskripsi"><span class="la la-trash"></span></button></li>
                    </ul>
                </div>
            </td>
        </tr>`;
    i++;
    return valueDeskripsi;
}

function makeDetil(keyStart){
    var valueDetil = `<div class="row" style="margin-top:10px;">
                        <div class="col-md-11">
                            <input type="text" name="deskripsi_multiple[${keyStart}][]" placeholder="Deskripsi">
                        </div>
                        <div class="col-md-1" style="margin: auto;">
                            <div class="option-box">
                                <ul class="option-list">
                                    <li><button type="button" class="hapusDetil" data-text="Hapus Deskripsi"><span class="la la-trash"></span></button></li>
                                </ul>
                            </div>
                        </div>
                    </div>`;
    return valueDetil;
}
function addDeskripsi(){
    var valueDeskripsi = makeDeskripsi();
    $("#detil-deskripsi tbody").append(valueDeskripsi)
}

$("#detil-deskripsi").on("click", ".addDetil", function() {
    var key = $(this).closest("tr").data('id');
    var valueDetil = makeDetil(key);
   $(this).closest("tr").find('.form-group div.body-row').append(valueDetil);
});



$("#detil-deskripsi").on("click", ".hapusDetil", function() {
    var total = $(this).closest(".body-row").children('.row').length;
    if(total > 1)
    $(this).closest(".row").remove();
});

function hapusDeskripsi(el){
    el.closest("tr").remove();
}
$(document).ready(function(){
    // addDeskripsi();
    @if(@$data->jenis_gaji == 'range')
    $("#showGajiMax").show();
    @else
    $("#showGajiMax").hide();
    @endif
    getKelurahan("{{$data->id_kelurahan ?? ''}}");
})
$("#jenis_gaji").change(function(){
    if($(this).val() == 'range')
    $("#showGajiMax").show();
    else
    $("#showGajiMax").hide();
});
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
jQuery.datetimepicker.setLocale('id');
$('#tanggal_kadaluarsa').datetimepicker(
    {
        timepicker:false,
        format:'Y-m-d'
    }
);
tinymce.init({
    selector: 'textarea.freetext',
    height: 400,
    removed_menuitems: 'fontformats',
    paste_data_images: false,
    images_upload_credentials: false,
    content_style: "body {font-size: 10pt;}"
});

$('#submit').click(function(e) {
    console.log('run')
    e.preventDefault();
    var btn = $(this);
    var form = $(this).closest('form');
    // console.log('run 2')
    var tinyx = tinymce.get("deskripsi").getContent();
    var tinyx = tinyx.replace(/<script>/g, "");
    var tinyx = tinyx.replace(/<\/script>/g, "");
    tinymce.get("deskripsi").setContent(tinyx);
    
    tinyMCE.get('deskripsi').save();
    form.validate({
        rules: {
            judul: {
                required : true,
                maxlength: 200,
            },
            deskripsi: {
                required: true,
                maxlength: 2000,
            },
            tanggal_kadaluarsa: {
                required: true,
            },
            jenis_kelamin: {
                required: true,
            },
            id_jenis_pekerjaan: {
                required: true,
            },
            id_kecamatan: {
                required: true,
            },
            id_kelurahan: {
                required: true,
            },
            show_gaji: {
                required: true,
            },
            jenis_gaji: {
                required: true,
            },
            gaji: {
                required: true,
                number: true
            },
            gaji_max: {
                number: true
            },
        }
    });
    if (!form.valid()) {
        $('body, html').animate({scrollTop:$('form').offset().top}, 'slow');
        return;
    }
    apiLoading(true, btn);
    form.ajaxSubmit({
        url    : "{{url('api/perusahaan/loker-add')}}",
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
                        $(location).prop('href', "{{url('perusahaan/loker-kelola')}}")
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