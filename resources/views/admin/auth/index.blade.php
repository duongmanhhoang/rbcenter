@extends('admin.layouts.login')

@section('content')
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3"
             id="m_login" style="background-image: url({{asset('bower_components/bower-rbcenter/admin/metronic/app/media/img//bg/bg-2.jpg')}});">
            <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="#">
                            <img src="{{asset('bower_components/bower-rbcenter/admin/metronic/app/media/img/logos/logo-1.png')}}">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Sign In To Admin</h3>
                            @if(session('role_error'))
                                <p class="text-danger text-center">Bạn không đủ quyền đăng nhập</p>
                            @endif

                            @if(session('login_error'))
                                <p class="text-danger text-center">Tên đăng nhập hoặc mật khẩu không đúng</p>
                            @endif
                        </div>
                        <form class="m-login__form m-form" action="{{route('admin.login.submit')}}" method="post">
                            @csrf
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Email" name="email">
                                @if($errors->has('email'))
                                    <p class="text-danger">{{$errors->first('email')}}</p>
                                @endif

                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" type="password"
                                       placeholder="Password" name="password">
                                @if($errors->has('password'))
                                    <p class="text-danger">{{$errors->first('password')}}</p>
                                @endif
                            </div>
                            <div class="row m-login__form-sub">
                                <div class="col m--align-left m-login__form-left">
                                    <label class="m-checkbox  m-checkbox--light">
                                        <input type="checkbox" name="remember"> Remember me
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col m--align-right m-login__form-right">
                                    <a href="javascript:;" id="m_login_forget_password" class="m-link">Forget Password
                                        ?</a>
                                </div>
                            </div>
                            <div class="m-login__form-action">
                                <button id="m_login_signin_submit"
                                        class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
                                    Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection