<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->
<head>
    <base href="">
    <meta charset="utf-8" />
    <title>User login</title>
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500">

    <!--end::Fonts -->

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="assets/css/pages/login/login-5.css" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v5 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile" style="background-image: url(assets/media/bg/bg-3.jpg);">
            <div class="kt-login__left">
                <div class="kt-login__wrapper">
                    <div class="kt-login__content">
                        <a class="kt-login__logo" href="#">
                            <img src="assets/media/logos/logo-5.png">
                        </a>
                        <h3 class="kt-login__title">JOIN OUR GREAT COMMUNITY</h3>
                        <span class="kt-login__desc">
									The ultimate Bootstrap & Angular 6 admin theme framework for next generation web apps.
								</span>
                        <div class="kt-login__actions">
                            <a href="{{ route('register') }}" class="btn btn-outline-brand btn-pill">Get An Account</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-login__divider">
                <div></div>
            </div>
            <div class="kt-login__right">
                <div class="kt-login__wrapper">
                    <div class="kt-login__signin">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">Login To Your Account</h3>
                        </div>
                        <div class="kt-login__form">
                            <form class="kt-form" method="POST" action="{{ route('login') }}">
                                @csrf



                                <div class="form-group">
                                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" placeholder="Password" class="form-control form-control-last @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="row kt-login__extra">
                                    <div class="col kt-align-left">
                                        <label class="kt-checkbox">
                                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                                            <span></span>
                                        </label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <div class="col kt-align-right">
                                            <a href="javascript:;" id="kt_login_forgot" class="kt-link">Forget Password ?</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="kt-login__actions">
                                    <button type="submit" class="btn btn-brand btn-pill btn-elevate">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="kt-login__signup">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">Sign Up</h3>
                            <div class="kt-login__desc">Enter your details to create your account:</div>
                        </div>
                        <div class="kt-login__form">
                            <form class="kt-form" method="POST" action="{{ route('register') }}">
                                @csrf


                                <div class="form-group">
                                    <input placeholder="Fullname"  id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control form-control-last" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="row kt-login__extra">
                                    <div class="col kt-align-left">
                                        <label class="kt-checkbox">
                                            <input type="checkbox" name="agree">I Agree the <a href="#" class="kt-link kt-login__link kt-font-bold">terms and conditions</a>.
                                            <span></span>
                                        </label>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                </div>
                                <div class="kt-login__actions">
                                    <button id="" class="btn btn-brand btn-pill btn-elevate" type="submit">Sign Up</button>&nbsp;&nbsp;
                                    <button id="kt_login_signup_cancel" class="btn btn-outline-brand btn-pill">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="kt-login__forgot">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">Forgotten Password ?</h3>
                            <div class="kt-login__desc">Enter your email to reset your password:</div>
                        </div>
                        <div class="kt-login__form">
                            <form class="kt-form" action="">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
                                </div>
                                <div class="kt-login__actions">
                                    <button id="kt_login_forgot_submit" class="btn btn-brand btn-pill btn-elevate">Request</button>
                                    <button id="kt_login_forgot_cancel" class="btn btn-outline-brand btn-pill">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/custom/login/login-general.js" type="text/javascript"></script>

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
