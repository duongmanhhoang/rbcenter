@extends('admin.layouts.main')

@section('content')
    <div class="m-content" style="width: 100%">
        <div class="row">
            <div class="col-10 offset-1">

                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                                <h3 class="m-portlet__head-text">
                                    Thêm người dùng
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-right" method="post"
                          action="{{route('admin.users.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10">
                                <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                    Vui lòng không bỏ trống các ô có dấu *
                                </div>
                            </div>
                            <div class="form-group m-form__group">

                                <label for="exampleInputEmail1">Avatar</label>
                                <br>
                                <img id="is_image" src="{{asset('images/default-avatar.png')}}"
                                     style="width: 150px; margin-bottom: 30px">
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="select_image" name="avatar"
                                           accept="image/*">
                                    <label class="custom-file-label" for="selectImage">Chọn ảnh</label>
                                </div>

                                @if($errors->has('avatar'))
                                    <p class="text-danger">{{$errors->first('avatar')}}</p>
                                @endif
                            </div>
                            <div class="form-group m-form__group">
                                <label>Tên đăng nhập <b class="text-danger">*</b></label>
                                <input type="text" class="form-control m-input" name="username"
                                       placeholder="Nhập tên đăng nhập" value="{{old('username')}}">
                                @if($errors->has('username'))
                                    <p class="text-danger">{{$errors->first('username')}}</p>
                                @endif
                                @if(session('username_taken'))
                                    <p class="text-danger">Tên đăng nhập này đã được sử dụng</p>
                                @endif
                            </div>
                            <div class="form-group m-form__group">
                                <label>Email <b class="text-danger">*</b></label>
                                <input type="text" class="form-control m-input" name="email" placeholder="Nhập email"
                                       value="{{old('email')}}">
                                @if($errors->has('email'))
                                    <p class="text-danger">{{$errors->first('email')}}</p>
                                @endif
                                @if(session('email_taken'))
                                    <p class="text-danger">Email này đã được sử dụng</p>
                                @endif
                            </div>
                            <div class="form-group m-form__group">
                                <label>Mật khẩu <b class="text-danger">*</b></label>
                                <input type="password" class="form-control m-input" name="password"
                                       placeholder="Nhập mật khẩu">
                                @if($errors->has('password'))
                                    <p class="text-danger">{{$errors->first('password')}}</p>
                                @endif
                            </div>

                            <div class="form-group m-form__group">
                                <label>Nhập lại mật khẩu <b class="text-danger">*</b></label>
                                <input type="password" class="form-control m-input" name="password_confirmation"
                                       placeholder="Nhập lại mật khẩu">
                                @if($errors->has('password_confirmation'))
                                    <p class="text-danger">{{$errors->first('password_confirmation')}}</p>
                                @endif
                            </div>

                            <div class="form-group m-form__group">
                                <label>Quyền</label>
                                <select name="role_id" class="form-control m-input">
                                    <option value="1">Admin</option>
                                    <option value="100"> Người điều hành</option>
                                    <option value="200"> Người viết bài</option>
                                    <option value="400"> Giáo viên</option>
                                    <option value="500"> Học sinh</option>
                                </select>
                            </div>

                            <div class="form-group m-form__group">
                                <label>Họ và tên <b class="text-danger">*</b></label>
                                <input type="text" class="form-control m-input" name="full_name"
                                       placeholder="Nhập họ và tên" value="{{old('full_name')}}">

                                @if($errors->has('full_name'))
                                    <p class="text-danger">{{$errors->first('full_name')}}</p>
                                @endif
                            </div>

                            <div class="form-group m-form__group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control m-input" name="phone"
                                       placeholder="Nhập số điện thoại" value="{{old('phone')}}">
                                @if($errors->has('phone'))
                                    <p class="text-danger">{{$errors->first('phone')}}</p>
                                @endif
                            </div>

                            <div class="form-group m-form__group">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control m-input" name="address"
                                       placeholder="Nhập địa chỉ" value="{{old('address')}}">
                                @if($errors->has('address'))
                                    <p class="text-danger">{{$errors->first('address')}}</p>
                                @endif
                            </div>

                            <div class="m-form__group form-group">
                                <label>Giới tính</label>
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="radio" name="gender" value="1"> Nam
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="gender" value="2"> Nữ
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <button type="submit" class="btn btn-primary">Thêm</button>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->
                </div>

            </div>

        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(() => {
            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#is_image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#select_image").change(function () {
                readURL(this);
            });

        })
    </script>
@endsection