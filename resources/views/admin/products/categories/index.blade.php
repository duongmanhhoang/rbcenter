@extends('admin.layouts.main')

@section('content')
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Danh sách danh mục
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">

                        <div class="col-xl-8 order-2 order-xl-1">

                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <form method="get" action="{{route('admin.products.categories.index')}}">
                                            <input type="text" class="form-control m-input" id="search" name="keyword"
                                                   placeholder="Tìm kiếm">
                                        </form>
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
															<span>
																<i class="la la-search"></i>
															</span>
														</span>
                                    </div>
                                </div>
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
                                                        <option value="1">
                                                            Hoạt động
                                                        </option>
                                                        <option value="0" @if(isset($_GET['status']) && $_GET['status'] == 0){{'selected'}}@endif>
                                                            Xóa tạm
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="d-md-none m--margin-bottom-10"></div>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>

                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{route('admin.products.categories.create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
												<span>
													<i class="la la-plus"></i>
													<span>Thêm danh mục</span>
												</span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>

                <!--end: Search Form -->

                <!--begin: Datatable -->
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 50px">STT</th>
                        <th>Tên</th>
                        <th>Danh mục cha</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$category->name}}</td>
                            <td></td>
                            <td>
                                @if($category->status == 1)
                                    <a href="{{route('admin.products.categories.edit' , $category->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                       title="Chỉnh sửa"><i class="la la-edit"></i> </a>

                                    <a href="javascript:;" linkurl="{{route('admin.products.categories.disable' , $category->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-disable"
                                       title="Xóa tạm"><i class="la la-trash"></i> </a>
                                @elseif($category->status == 0)
                                    <a href="javascript:;" linkurl="{{route('admin.products.categories.restore' , $category ->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-restore"
                                       title="Khôi phục"><i class="la la-refresh"></i> </a>
                                @endif
                            </td>

                        </tr>
                        @php($i++)
                    @endforeach
                    </tbody>
                </table>

            {{$categories->links()}}
            <!--end: Datatable -->
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
                    title: "Bạn có chắc muốn xóa danh mục này?",
                    text: "Sau 30 ngày danh mục sẽ bị xóa vĩnh viễn",
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
                    title: "Bạn có chắc muốn khôi phục danh mục này?",
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
        swal("Thêm danh mục thành công!", "", "success")
        @endif
        @if(session('ban'))
        swal("Đình chỉ danh mục thành công!", "", "success")
        @endif
        @if(session('restore'))
        swal("Khôi phục danh mục thành công!", "", "success")
        @endif
        @if(session('disable'))
        swal("Xóa tạm danh mục thành công!", "", "success")
        @endif

        @if(session('error_has_child'))
        swal("Không thể xóa!", "Danh mục này có chứa danh mục con", "error")
        @endif

        @if(session('error_has_product'))
        swal("Không thể xóa!", "Danh mục này có sản phẩm", "error")
        @endif

    </script>
@endsection