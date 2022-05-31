<!DOCTYPE html>
<html lang="en">

@include('front.layouts.head')

<body>
<div id="wpf-loader-two">
    <div class="wpf-loader-two-inner">
        <span>Loading</span>
    </div>
</div>
<!-- / wpf loader Two -->
<!-- SCROLL TOP BUTTON -->
<a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
<!-- END SCROLL TOP BUTTON -->
<div>

    @include('front.layouts.header')
    <!-- menu -->
        <section id="menu">
            <div class="container">
                <div class="menu-area">
                    <!-- Navbar -->
                    <div class="navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse">
                            <!-- Left nav -->
                            {!! getTopNavCategory() !!}
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>
        </section>
        <!-- / menu -->

    <div>
        @yield('content')
    </div>
</div>
@php
    if(isset($_COOKIE['login_email']) && isset($_COOKIE['login_pwd']))
        {
            $login_email=$_COOKIE['login_email'];
            $login_pwd=$_COOKIE['login_pwd'];
            $is_remember = "checked='checked'";
        }
        else
            {
                $login_email='';
                $login_pwd='';
                $is_remember='';
            }
@endphp
<!-- Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div id="popup_login">
                    <h4>Login or Register</h4>
                    <form class="aa-login-form" action="" id="frmLogin">
                        @csrf
                        <label for="">Email address<span>*</span></label>
                        <input type="email" placeholder="email" name="str_login_email" required
                               value="{{$login_email}}">
                        <label for="">Password<span>*</span></label>
                        <input type="password" placeholder="Password" name="str_login_password" value="{{$login_pwd}}">
                        <button id="btnLogin" class="aa-browse-btn" type="submit">Login</button>

                        <label for="rememberme" class="rememberme"><input type="checkbox"
                                                                          {{$is_remember}} name="rememberme"
                                                                          id="rememberme">
                            Remember me
                        </label>

                        <div id="login_msg"></div>

                        <p class="aa-lost-password"><a href="javascript:void(0)" onclick="forgot_password()">Lost your
                                password?</a></p>
                        <div class="aa-register-now">
                            Don't have an account?<a href="{{url('registration')}}">Register now!</a>
                        </div>

                    </form>
                </div>
                <div id="popup_forget" style="display: none;">
                    <h4>Forgot password</h4>
                    <form class="aa-login-form" action="" id="frmForget">
                        @csrf
                        <label for="">Email<span>*</span></label>
                        <input type="email" placeholder="email" name="str_forget_email" required
                        >
                        <button id="btnForget" class="aa-browse-btn" type="submit">Login</button>
                        <div id="forget_msg"></div>
                        <br><br>
                        <div class="aa-register-now">
                            login?<a href="javascript:void(0)" onclick="show_login_popup()">Login now!</a>
                        </div>

                    </form>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@include('front.layouts.footer')
<!-- End Page Wrapper -->
</div>



@include('front.layouts.scripts')

</body>
</html>


