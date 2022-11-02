 <!-- Dashboard -->
 <section class="user-dashboard">
    <div class="dashboard-outer">
      <div class="upper-title-box">
        <h3>KARTU AK.1 (Kartu Kuning)</h3>
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
                  <select class="chosen-select" name="verified_status" id="verified_status">
                    <option value="">-- Semua --</option>
                    <option value="KIRIM">Status Pengajuan</option>
                    <option value="APPROVED_ONLINE">Dokumen Online Terverifikasi (Menunggu Dokumen Asli)</option>
                    <option value="RECIVED">Dokumen Asli Diterima</option>
                    <option value="DONE">Selesai</option>
                  </select>
                </div>
              </div>

              <div class="widget-content">
                <div class="table-outer">
                  <table class="default-table manage-job-table" id="table_id">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>Status</th>
                            <th>NIK</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>
                            {{-- <span class="pull-right"><i class="las la-search"></i></span> --}}
                          </th>
                          <th>Status</th>
                          <th>NIK</th>
                          <th>Nama</th>
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
            url  : "{{url('api/admin/kartu-kuning-list')}}",
            type : "get",   
            headers: {
                "Authorization": "Bearer " + localStorage.getItem('jwt_token')
            },
            data: function(d) {
                d.verified_status  = $("#verified_status").val();
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
    $("#verified_status").change(function(){
      tableList.ajax.reload();
      console.log($("#verified_status").val());
    });
    function lihat(id, status){
      var url = "{{url('admin/kartu-kuning-detail?')}}id="+id+"&verified_status="+status;
      window.open(url,'_blank');
    }
  </script>