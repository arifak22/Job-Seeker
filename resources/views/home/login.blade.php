<div class="model">
    <!-- Login modal -->
    <div id="login-modal">
      <!-- Login Form -->
      <div class="login-form default-form">
        <div class="form-inner">
          <h3>Login di SIAPNARI <br> <span style="font-size: 18px"> Sistem Aplikasi Tenaga Kerja & Perindustrian</span></h3>
          <!--Login Form-->
          <form>
            <div class="form-group">
              <label>E-mail</label>
              <input type="text" name="email" placeholder="E-mail" required>
            </div>
  
            <div class="form-group">
              <label>Kata Sandi</label>
              <input id="password-field" type="password" name="password" value="" placeholder="Kata Sandi">
            </div>
  
            <div class="form-group">
              <div class="field-outer">
                {{-- <div class="input-group checkboxes square">
                  <input type="checkbox" name="remember-me" value="" id="remember">
                  <label for="remember" class="remember"><span class="custom-checkbox"></span> Remember me</label>
                </div> --}}
                <a href="#" class="pwd">Lupa Kata Sandi?</a>
              </div>
            </div>
  
            <div class="form-group">
              <button class="theme-btn btn-style-one" type="submit" id="submit" name="log-in">Login</button>
            </div>
          </form>
  
          <div class="bottom-box">
            <div class="text">Belum mempunyai akun? <a href="{{url('auth/register')}}" class="call-modal signup">Daftar</a></div>
            {{-- <div class="divider"><span>or</span></div>
            <div class="btn-box row">
              <div class="col-lg-6 col-md-12">
                <a href="#" class="theme-btn social-btn-two facebook-btn"><i class="fab fa-facebook-f"></i> Log In via Facebook</a>
              </div>
              <div class="col-lg-6 col-md-12">
                <a href="#" class="theme-btn social-btn-two google-btn"><i class="fab fa-google"></i> Log In via Gmail</a>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
      <!--End Login Form -->
    </div>
    <!-- End Login Module -->
  
    <script type="text/javascript">
      // Open modal in AJAX callback
      jQuery('.call-modal.signup').on('click', function(event) {
        event.preventDefault();
        this.blur();
        jQuery.get(this.href, function(html) {
          jQuery(html).appendTo('body').modal({
            fadeDuration: 300,
            fadeDelay: 0.15
          });
        });
      });

      $('#submit').click(function(e) {
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
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 200,
                    },
                }
            });
            if (!form.valid()) {
                return;
            }
            apiLoading(true, btn);
            form.ajaxSubmit({
                url : "{{url('auth/login')}}",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    apiLoading(false, btn);
                    apiRespone(
                        response,
                        false,
                        (res) => {
                            if(res.api_status == '1'){
                                // $window.sessionStorage.accessToken = res.jwt_token;
                                localStorage.setItem("jwt_token", res.jwt_token);
                                $(location).prop('href', "{{url('home')}}")
                            }
                        }
                    );
                },
                error: function(error){
                    apiLoading(false, btn);
                    swal(error.statusText);
                }
            });
        });
    </script>
  </div>