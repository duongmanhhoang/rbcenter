@extends('admin.layouts.main')



@section('content')
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Danh sách người dùng
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">

                        <div class="col-xl-8 order-2 order-xl-1">

                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-8">
                                    <form method="get" action="" class="row">
                                        <div class="col-md-6">
                                            <div class="m-form__group m-form__group--inline">
                                                <div class="m-form__label">
                                                    <label>Trạng thái:</label>
                                                </div>
                                                <div class="m-form__control">
                                                    <select class="form-control" id="m_form_status"
                                                            name="status" onchange="this.form.submit()">
                                                        <option value="">Tất cả</option>
                                                        <option value="1" @if(isset($_GET['status']) && $_GET['status'] == 1){{'selected'}}@endif>
                                                            Hoạt động
                                                        </option>
                                                        <option value="0" @if(isset($_GET['status']) && $_GET['status'] == '0'){{'selected'}}@endif>
                                                            Xóa tạm
                                                        </option>
                                                        <option value="-1" @if(isset($_GET['status']) && $_GET['status'] == -1){{'selected'}}@endif>
                                                            Ban
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="d-md-none m--margin-bottom-10"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="m-form__group m-form__group--inline">
                                                <div class="m-form__label">
                                                    <label class="m-label m-label--single">Quyền:</label>
                                                </div>
                                                <div class="m-form__control">

                                                    <select class="form-control" id="m_form_type"
                                                            name="role_id" onchange="this.form.submit()">
                                                        <option value="" selected>
                                                            Tất cả
                                                        </option>
                                                        <option value="1" @if(isset($_GET['role_id']) && $_GET['role_id'] == 1){{'selected'}}@endif>
                                                            Admin
                                                        </option>
                                                        <option value="100" @if(isset($_GET['role_id']) && $_GET['role_id'] == 100){{'selected'}}@endif>
                                                            Người điều hành
                                                        </option>
                                                        <option value="200" @if(isset($_GET['role_id']) && $_GET['role_id'] == 200){{'selected'}}@endif>
                                                            Người viết bài
                                                        </option>
                                                        <option value="400" @if(isset($_GET['role_id']) && $_GET['role_id'] == 400){{'selected'}}@endif>
                                                            Giáo viên
                                                        </option>
                                                        <option value="500" @if(isset($_GET['role_id']) && $_GET['role_id'] == 500){{'selected'}}@endif>
                                                            Học sinh
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="d-md-none m--margin-bottom-10"></div>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <form method="get" action="{{route('admin.users.index')}}">
                                            <input type="text" class="form-control m-input" name="keyword"
                                                   placeholder="Tìm kiếm theo email">
                                        </form>
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
															<span>
																<i class="la la-search"></i>
															</span>
														</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{route('admin.users.create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
												<span>
													<i class="la la-user-plus"></i>
													<span>Thêm người dùng</span>
												</span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 50px">STT</th>
                        <th>Email</th>
                        <th>Tên</th>
                        <th>Quyền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($users as $user)
                        <tr>
                            <td style="width: 50px">
                                {{$i}}
                            </td>
                            <td>{{$user->email}}</td>
                            <td>@if(isset($user->full_name)){{$user->full_name}}@endif</td>
                            <td>
                                @if($user->role_id == 1)
                                    Admin
                                @elseif($user->role_id == 100)
                                    Người điều hành
                                @elseif($user->role_id == 200)
                                    Người viết bài
                                @elseif($user->role_id ==400)
                                    Giáo viên
                                @elseif($user->role_id ==500)
                                    Học sinh
                                @endif
                            </td>

                            <td>
                                <span style="width: 100px">
                                @if($user->status == 1)
                                        <span class="m-badge  m-badge--info m-badge--wide">Hoạt động</span>
                                    @elseif($user->status == -1)
                                        <span class="m-badge  m-badge--metal m-badge--wide">Bị Ban</span>
                                    @elseif($user->status == 0)
                                        <span class="m-badge  m-badge--danger m-badge--wide">Xóa tạm</span>
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if($user->status == 1)
                                    <a href="{{route('admin.users.edit' , [$user->id])}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                       title="Chỉnh sửa"><i class="la la-edit"></i> </a>

                                    <a href="javascript:;" linkurl="{{route('admin.users.disable' , [$user->id])}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-disable"
                                       title="Xóa tạm"><i class="la la-trash"></i> </a>

                                    <a href="javascript:;" linkurl="{{route('admin.users.ban' , [$user->id])}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill btn-ban"
                                       title="Ban"><i class="la la-ban"></i> </a>
                                @elseif($user->status == 0)
                                    <a href="javascript:;" linkurl="{{route('admin.users.restore' , [$user->id])}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-restore"
                                       title="Khôi phục"><i class="la la-refresh"></i> </a>
                                @elseif($user->status == -1)
                                    <a href="javascript:;" linkurl="{{route('admin.users.disable' , [$user->id])}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-disable"
                                       title="Xóa tạm"><i class="la la-trash"></i> </a>
                                    <a href="javascript:;" linkurl="{{route('admin.users.restore' , [$user->id])}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-restore"
                                       title="Khôi phục"><i class="la la-refresh"></i> </a>


                                @endif

                            </td>
                        </tr>
                        @php($i++)
                    @endforeach
                    </tbody>
                </table>


            {{$users->links()}}
            </div>


        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(() => {
            $(".btn-disable").click(function (e) {
                var removeUrl = $(this).attr('linkurl');
                swal({
                    title: "Bạn có chắc muốn xóa người dùng này?",
                    text: "Sau 30 ngày người dùng sẽ bị xóa vĩnh viễn",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "Hủy",
                    confirmButtonText: "Tôi chắc chắn"
                }).then(function (e) {
                    e.value && $(location).attr('href', removeUrl)
                })
            });

            $(".btn-restore").click(function (e) {
                var removeUrl = $(this).attr('linkurl');
                swal({
                    title: "Bạn có chắc muốn khôi phục người dùng này?",
                    text: "",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "Hủy",
                    confirmButtonText: "Tôi chắc chắn"
                }).then(function (e) {
                    e.value && $(location).attr('href', removeUrl)
                })
            });

            $(".btn-ban").click(function (e) {
                var removeUrl = $(this).attr('linkurl');
                swal({
                    title: "Bạn có chắc muốn ban người dùng này?",
                    text: "",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "Hủy",
                    confirmButtonText: "Tôi chắc chắn"
                }).then(function (e) {
                    e.value && $(location).attr('href', removeUrl)
                })
            });
        });
        @if(session('store'))
        swal("Thêm người dùng thành công!", "", "success")
        @endif
        @if(session('ban'))
        swal("Ban người dùng thành công!", "", "success")
        @endif
        @if(session('restore'))
        swal("Khôi phục người dùng thành công!", "", "success")
        @endif
        @if(session('disable'))
        swal("Xóa tạm người dùng thành công!", "", "success")
        @endif
        @if(session('is_admin'))
        swal("Không thể thực hiện hành động này với admin!", "", "error")
        @endif
        @if(session('yourself'))
        swal("Bạn không thể thực hiện hành động này với chính tài khoản hiện tại!", "", "error")
        @endif

    </script>
@endsection