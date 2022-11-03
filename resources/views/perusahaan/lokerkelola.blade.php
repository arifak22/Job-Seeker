 <!-- Dashboard -->
 <section class="user-dashboard">
    <div class="dashboard-outer">
      <div class="upper-title-box">
        <h3>{{$title}}</h3>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <!-- Ls widget -->
          <div class="ls-widget">
            <div class="tabs-box">
              <div class="widget-title">
                <h4></h4>

                <div class="chosen-outer">
                  <!--Tabs Box-->
                  @if($tipe == 'admin')
                  <select class="chosen-select" name="perusahaan" id="perusahaan">
                    @foreach($perusahaan as $p)
                    <option value="{{$p->id}}"> {{$p->nama}} </option>
                    @endforeach
                  </select>
                  @else
                  <select class="chosen-select" name="status_loker" id="status_loker">
                    <option value="">-- Semua --</option>
                    <option value="DRAFT">DRAFT</option>
                    <option value="POST">POSTING</option>
                  </select>
                  @endif
                </div>
              </div>

              <div class="widget-content">
                <div class="table-outer">
                  <table class="default-table manage-job-table" id="table_id">
                    <thead>
                        <tr>
                          <th>Aksi</th>
                          <th>Status</th>
                          <th>Judul</th>
                          <th>Pelamar</th>
                          <th>Dibuat & Kadaluarsa</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th></th>
                          <th>Status</th>
                          <th>Judul</th>
                          <th>Pelamar</th>
                          <th>Dibuat & Kadaluarsa</th>
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
    var tableList = $('#table_id').DataTable({
        processing   : true,
        serverSide   : true,
        bLengthChange: false,
        bFilter      : true,
        pageLength   : 50,
        // order        : [[2,'desc']],
        ajax         : {
            url  : "{{url('api/perusahaan/loker-kelola')}}",
            type : "get",   
            headers: {
                "Authorization": "Bearer " + localStorage.getItem('jwt_token')
            },
            data: function(d) {
                d.status_loker = $("#status_loker").val();
                d.perusahaan   = $("#perusahaan").val();
            },
            error: function(){ 
                $(".employee-grid-error").html("");
                $("#data-list").append('<tbody class="employee-grid-error"><tr><th colspan="4"><center>Internal Server Error</center></th></tr></tbody>');
                $("#data-list_processing").css("display","none");
            }
        },
        columns : [
            { "data" : "id", "name" : "loker.id" },
            { "data" : "status_loker" },
            { "data" : "judul"},
            { "data" : "jumlah_pelamar"},
            { "data" : "tanggal_dibuat"},
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if(column[0] != 0){
                    var input = '<input class="form-control">';
                    if(column[0] == 1 || column[0] == 3 || column[0] == 4){
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
                visible: <?php if($tipe == 'admin') echo 'false'; else echo 'true';?>,
                render: function ( data, type, row, meta ) {
                    return `<div class="option-box">
                              <ul class="option-list">
                                <li><button data-text="Detail" onclick="lihat(${data})"><span class="la la-eye"></span></button></li>
                                <li><a data-text="Ubah" href="{{url('perusahaan/loker-posting?id=')}}${data}"><span class="la la-pencil"></span></a></li>
                                <li><button data-text="Hapus" onclick="hapus(${data})"><span class="la la-trash"></span></button></li>
                              </ul>
                            </div>`;
                }
            },
            {
                targets : 1,
                orderable: false, 
                data: "status_loker",
                render: function ( data, type, row, meta ) {
                    return `<span style="color:${row.status_color};background:${row.status_color}33; padding:5px 20px;border-radius:50px;">${data}</span>`;
                }
            },
            {
                targets : 2,
                orderable: true, 
                data: "judul",
                render: function ( data, type, row, meta ) {
                    return ` <h6>${data}</h6>
                            <span class="info"><i class="icon flaticon-map-locator"></i> ${row.kecamatan}, ${row.kelurahan}</span>`;
                }
            },
            {
                targets : 3,
                orderable: true, 
                data: "jumlah_pelamar",
                render: function ( data, type, row, meta ) {
                    return `<span class="applied"><a href="{{url('perusahaan/loker-applicant?id=')}}${row.id}">${data} Applied</a></span>`;
                }
            },
            {
                targets : 4,
                orderable: true, 
                data: "tanggal_dibuat",
                render: function ( data, type, row, meta ) {
                    return `${data} <br> ${row.tanggal_kadaluarsa}`;
                }
            },
        ],
    });
    $("#status_loker").change(function(){
      tableList.ajax.reload();
    });
    function lihat(id){
      var url = "{{url('menu/loker-detil?')}}id="+id;
      window.open(url,'_blank');
    }

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
                    url:  "{{url('api/perusahaan/loker-hapus')}}",
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
  </script>