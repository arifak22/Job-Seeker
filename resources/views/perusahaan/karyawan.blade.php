 <!-- Dashboard -->
 <section class="user-dashboard">
    <div class="dashboard-outer">
      <div class="upper-title-box">
        <h3>{{$title}}</h3>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="ls-widget" id="form-page">
            <div class="tabs-box">
              <div class="widget-title">
                <h4 id="form-title">Tambah</h4>
              </div>
              <div class="widget-content">
                <span id="alert"></span>
                
                <form class="default-form" id="myform">
                    {!!Sideveloper::formHidden('id', '')!!}
                    {!!Sideveloper::formInput('Nama','text','nama')!!}
                    {!!Sideveloper::formSelect('Jenis Kelamin', array(array('value'=>'Laki-laki', 'name'=>'Laki-laki'), array('value'=>'Perempuan', 'name'=> 'Perempuan')), 'jenis_kelamin')!!}
                    {!!Sideveloper::formInput('Tanggal Lahir','text','tanggal_lahir', null, 'readonly')!!}
                    {!!Sideveloper::formSelect('Jenis Tenaga Kerja', array(array('value'=>'Lokal', 'name'=>'Lokal'), array('value'=>'Asing', 'name'=> 'Asing')), 'jenis')!!}
                    <div class="form-group col-lg-6 col-md-12">
                        <button class="theme-btn btn-style-one" type="submit" id="submit">Tambah</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <!-- Ls widget -->
          <div class="ls-widget">
            <div class="tabs-box">
              <div class="widget-title">
                <h4>Data</h4>

                <div class="chosen-outer">
                  <!--Tabs Box-->
                  {{-- <select class="chosen-select" name="verified_status" id="verified_status">
                    <option value="">-- Semua --</option>
                    <option value="KIRIM">Status Pengajuan</option>
                    <option value="APPROVED_ONLINE">Dokumen Online Terverifikasi (Menunggu Dokumen Asli)</option>
                    <option value="RECIVED">Dokumen Asli Diterima</option>
                    <option value="DONE">Selesai</option>
                  </select> --}}
                </div>
              </div>

              <div class="widget-content">
                <div class="table-outer">
                  <table class="default-table manage-job-table" id="table_id">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Tenaga Kerja</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>
                            {{-- <span class="pull-right"><i class="las la-search"></i></span> --}}
                          </th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Tenaga Kerja</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                  </table>
                </div>
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
    $('#tanggal_lahir').datetimepicker(
        {
            timepicker:false,
            format:'Y-m-d'
        }
    );
    var tableList = $('#table_id').DataTable({
        processing   : true,
        serverSide   : true,
        bLengthChange: false,
        bFilter      : true,
        pageLength   : 50,
        // order        : [[2,'desc']],
        ajax         : {
            url  : "{{url('api/perusahaan/karyawan')}}",
            type : "get",   
            headers: {
                "Authorization": "Bearer " + localStorage.getItem('jwt_token')
            },
            error: function(){ 
                $(".employee-grid-error").html("");
                $("#data-list").append('<tbody class="employee-grid-error"><tr><th colspan="5"><center>Internal Server Error</center></th></tr></tbody>');
                $("#data-list_processing").css("display","none");
            }
        },
        columns : [
            { "data" : "id" },
            { "data" : "nama"},
            { "data" : "jenis_kelamin"},
            { "data" : "tanggal_lahir"},
            { "data" : "jenis"},
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if(column[0] != 0){
                    var input = '<input class="form-control">';
                    $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                }
            });
        },
        columnDefs: [
            {
                targets : 0,
                orderable: false, 
                data: "id",
                render: function ( data, type, row, meta ) {
                    return `<div class="option-box">
                              <ul class="option-list">
                                <li><button data-text="Hapus" onclick="hapus(${data})"><span class="la la-trash"></span></button></li>
                                <li><button data-text="Ubah" onclick="ubah(${data})"><span class="la la-pencil"></span></button></li>
                              </ul>
                            </div>`;
                }
            },
        ],
    });

    function hapus(id){
        swal({
            title: "Apakah anda yakin?",
            text: "Menghapus data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                apiLoading(true);
                $.ajax({
                    method: "POST",
                    url:  "{{url('api/perusahaan/karyawan-hapus')}}",
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem('jwt_token')
                    },
                    data: { id: id, _token: "{{ csrf_token() }}" }
                })
                .done(function(res) {
                    apiRespone(res,
						null,
						() => {
                            tableList.ajax.reload();
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

    function ubah(id){
        apiLoading(true);
        $.ajax({
            method: "GET",
            url:  "{{url('api/perusahaan/karyawan-detil')}}",
            headers: {
                "Authorization": "Bearer " + localStorage.getItem('jwt_token')
            },
            data: { id: id, _token: "{{ csrf_token() }}" }
        })
        .done(function(res) {
            // alert(res.data.jenis_kelamin);
            window.scrollTo({ top: 0, behavior: 'smooth' });
            $("#form-page").css('background', '#ffe9d5');
            $("#form-title").text('Ubah');
            $("#submit").text('Ubah');
            $("#id").val(res.data.id);
            $("#nama").val(res.data.nama);
            $("#jenis_kelamin").val(res.data.jenis_kelamin);
            $("#tanggal_lahir").val(res.data.tanggal_lahir);
            $("#jenis").val(res.data.jenis);
        })
        .fail(function(err) {
            alert("error");
        })
        .always(function() {
            apiLoading(false);
        });
}

    $('#submit').click(function(e) {
        console.log('run')
        e.preventDefault();
        var btn = $(this);
        var form = $(this).closest('form');
        form.validate({
            rules: {
                nama: {
                    required : true,
                    maxlength: 200,
                },
                jenis_kelamin: {
                    required : true,
                },
                tanggal_lahir: {
                    required : true,
                },
                jenis: {
                    required : true,
                },
            }
        });
        if (!form.valid()) {
            $('body, html').animate({scrollTop:$('form').offset().top}, 'slow');
            return;
        }
        apiLoading(true, btn);
        form.ajaxSubmit({
            url    : "{{url('api/perusahaan/karyawan-post')}}",
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
                        $("#myform").trigger("reset");
                        $("#id").val('');
                        $("#form-page").css('background', '#ffffff');
                        $("#form-title").text('Tambah');
                        $("#submit").text('Tambah');
                        tableList.ajax.reload();
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