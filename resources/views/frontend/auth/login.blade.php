@extends('frontend.layouts.master')

@section('content')
    <section class="heading-banner-area pt-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-banner">
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="index.html">Trang chủ</a><span class="breadcome-separator">></span></li>
                                <li>Đăng nhập</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="my-account-area mt-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3"></div>
                <div class="col-lg-6 col-md-6">
                    <div class="customer-login-register">
                        <div class="login-form">
                            <form action="{{ route('login.store') }}" method="post">
                                @csrf
                                <div class="form-fild">
                                    <p><label>Email <span class="required">*</span></label></p>
                                    <input type="text" name="email" value>

                                    @error('email')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-fild">
                                    <p><label>Mật khẩu <span class="required">*</span></label></p>
                                    <input type="password" name="password" value>

                                    @error('password')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="login-submit">
                                    <button type="submit" class="form-button">Đăng nhập</button>
                                    @error('login')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="lost-password">
                                    <a href="#">Quên mật khẩu?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3"></div>
            </div>
        </div>
    </section>
@endsection
