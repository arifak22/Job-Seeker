<div class="model">
    <!-- Login modal -->
    <div id="login-modal">
        <!-- Login Form -->
        <div class="login-form default-form">
            <div class="form-inner">
                <h3>Mendaftar di SIAPNARI <br> <span style="font-size: 18px"> Sistem Aplikasi Tenaga Kerja & Perindustrian</span></h3>
                <!--Login Form-->
                <form>
                    <div class="form-group">
                        <div class="btn-box row">
                            <div class="col-lg-6 col-md-12">
                                <button type="button" id="btnPencari" class="theme-btn btn-style-seven"><i class="la la-user"></i> Pencari Kerja </button>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <button type="button"" id="btnPerusahaan" class="theme-btn btn-style-four"><i class="la la-briefcase"></i> Perusahaan </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="tipe" id="tipe" value="1">
                    <div class="form-group">
                        <label>Alamat Email</label>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama_pemilik" placeholder="Nama" required>
                    </div>

                    <div class="form-group" id="formPerusahaan">
                        <label>Nama Perusahaan</label>
                        <input type="text" name="nama" placeholder="Nama Perusahaan">
                    </div>

                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <input type="password" id="password" name="password" placeholder="Kata Sandi" required>
                    </div>

                    <div class="form-group">
                        <label>Ulangi Kata Sandi</label>
                        <input type="password" name="password_again" placeholder="Ulangi Kata Sandi" required>
                    </div>

                    <div class="form-group">
                        <button class="theme-btn btn-style-one " type="submit" id="submit-register" name="Register">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--End Login Form -->
    </div>
    <!-- End Login Module -->
    <script type="text/javascript">
        
        $(document).ready(function(){
            $("#formPerusahaan").hide();
        })
        $("#btnPencari").click(function(){
            $("#tipe").val('1');
            $('#btnPencari').attr('class', 'theme-btn btn-style-seven');
            $('#btnPerusahaan').attr('class', 'theme-btn btn-style-four');
            $("#formPerusahaan").hide();
        });
        $("#btnPerusahaan").click(function(){
            $("#tipe").val('2');
            $('#btnPerusahaan').attr('class', 'theme-btn btn-style-seven');
            $('#btnPencari').attr('class', 'theme-btn btn-style-four');
            $("#formPerusahaan").show();
        });
        $('#submit-register').click(function(e) {
            // console.log(requiredNama);
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
            form.validate({
                rules: {
                    email: {
                        required : true,
                        email    : true,
                        minlength: 0,
                        maxlength: 200,
                    },
                    nama_pemilik: {
                        required: true,
                        minlength: 0,
                        maxlength: 200,
                    },
                    nama: {
                        required: function() {
                            return $('#tipe').val() == '2';
                        },
                        minlength: 0,
                        maxlength: 200,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 200,
                    },
                    password_again: {
                        equalTo: "#password"
                    },
                }
            });
            if (!form.valid()) {
                return;
            }
            apiLoading(true, btn);
            form.ajaxSubmit({
                url    : "{{url('api/auth/register')}}",
                type: 'POST',
                success: function(response) {
                    apiLoading(false, btn);
                    apiRespone(
                        response,
                        false,
                        (res) => {
                            if(res.api_status == '1'){
                                $(location).prop('href', "{{url('auth/register-status')}}")
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
</div>

