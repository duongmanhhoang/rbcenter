@extends('admin.layouts.main')

@section('content')
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Danh sách lớp học
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
                                        <form method="get" action="{{route('admin.classes.index')}}">
                                            <input type="text" class="form-control m-input" name="keyword"
                                                   placeholder="Tìm kiếm theo tên lớp">
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
                                                        <option value="-1" @if(isset($_GET['status']) && $_GET['status'] == -1){{'selected'}}@endif>
                                                            Đình chỉ
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
                            <a href="{{route('admin.classes.create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
												<span>
													<i class="la la-plus"></i>
													<span>Thêm lớp</span>
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
                        <th>Ảnh</th>
                        <th>Tên lớp</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($classes as $class)
                        <tr>
                            <td>{{$i}}</td>
                            <td><img src="{{$class->image}}" style="width: 300px; object-fit: cover"></td>
                            <td>{{$class->name}}</td>
                            <td>{{$class->start_day}}</td>
                            <td>{{$class->end_day}}</td>
                            <td>

                                @if($class->status == 1)
                                    <a href="{{route('admin.classes.studentList' ,  $class->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                       title="Thêm học viên"><i class="la la-user-plus"></i> </a>

                                    <a href="{{route('admin.classes.studentList' ,  $class->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                       data-toggle="modal" data-target="#m_calendar_modal_{{$class->id}}"
                                       title="Thêm học viên"><i class="la la-calendar"></i> </a>
                                <form method="post" action="{{route('admin.classes.export' ,  $class->id)}}" enctype="multipart/form-data" style="display: contents">
                                    @csrf
                                    <button type="submit" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                       title="Xuất danh sách học sinh"><i class="la la-download"></i> </button>
                                </form>
                                    <a href="{{route('admin.classes.edit' , $class->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                       title="Chỉnh sửa"><i class="la la-edit"></i> </a>

                                    <a href="javascript:;" linkurl="{{route('admin.classes.disable' , $class->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-disable"
                                       title="Xóa tạm"><i class="la la-trash"></i> </a>

                                    <a href="javascript:;" linkurl="{{route('admin.classes.ban' , $class->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-metal m-btn--icon m-btn--icon-only m-btn--pill btn-ban"
                                       title="Đình chỉ"><i class="la la-ban"></i> </a>
                                @elseif($class->status == 0)
                                    <a href="javascript:;" linkurl="{{route('admin.classes.restore' , $class->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-restore"
                                       title="Khôi phục"><i class="la la-refresh"></i> </a>
                                @elseif($class->status == -1)
                                    <a href="javascript:;" linkurl="{{route('admin.classes.ban' , $class->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-disable"
                                       title="Xóa tạm"><i class="la la-trash"></i> </a>
                                    <a href="javascript:;" linkurl="{{route('admin.classes.restore' , $class->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-restore"
                                       title="Khôi phục"><i class="la la-refresh"></i> </a>


                                @endif
                            </td>
                        </tr>

                        <div class="modal fade" id="m_calendar_modal_{{$class->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Thời khóa biểu</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $timetables = explode(',', $class->timetable);
                                        ?>
                                        <form method="post" action="{{route('admin.classes.updateTimetable')}}">
                                            @csrf
                                            <input type="hidden" name="id" class="{{$class->id}}" value="{{$class->id}}">
                                            <div class="form-group m-form__group m_repeater">
                                                <label>Chọn ngày học </label>
                                                <div>
                                                    <div data-repeater-list="" class="col-lg-10">
                                                        @foreach($timetables as $timetable)
                                                            <div data-repeater-item class="row"
                                                                 style="margin-bottom: 20px">
                                                                <div class="col-md-6" style="padding-left: 0">
                                                                    <input type="text"
                                                                           class="form-control m-input my-datetimepicker timetable-{{$class->id}}"
                                                                           placeholder="Chọn thời gian lớp học" value="{{$timetable}}"
                                                                           name="timetable-{{$class->id}}[]">

                                                                    <div class="d-md-none m--margin-bottom-10"></div>
                                                                </div>


                                                                <div class="col-md-4">
                                                                    <div data-repeater-delete=""
                                                                         class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>Xóa</span>
																</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                </div>

                                                <div class="m-form__group form-group row">
                                                    <div data-repeater-create=""
                                                         class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>Thêm</span>
														</span>

                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn btn-primary update-timetable" updateId="{{$class->id}}" type="submit">Lưu</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php($i++)
                    @endforeach
                    </tbody>
                </table>

                {{$classes->links()}}


                <!--end: Datatable -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(() => {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            $(".m_repeater").repeater({
                initEmpty: !1, show: function () {
                    $(this).slideDown();
                    $('.my-datetimepicker').datetimepicker({
                        todayHighlight: !0,
                        autoclose: !0,
                        format: "yyyy-mm-dd hh:ii"
                    });
                }, hide: function (e) {
                    $(this).slideUp(e)
                }
            });

            $('.my-datetimepicker').datetimepicker({
                todayHighlight: !0,
                autoclose: !0,
                format: "yyyy-mm-dd hh:ii"
            });

            $(".btn-disable").click(function (e) {
                var removeUrl = $(this).attr('linkurl');
                swal({
                    title: "Bạn có chắc muốn xóa lớp này?",
                    text: "Sau 30 ngày lớp sẽ bị xóa vĩnh viễn",
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
                    title: "Bạn có chắc muốn khôi phục lớp này?",
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
                    title: "Bạn có chắc muốn ban lớp này?",
                    text: "",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "Hủy",
                    confirmButtonText: "Tôi chắc chắn"
                }).then(function (e) {
                    e.value && $(location).attr('href', removeUrl)
                })
            });


            $('.update-timetable').click(function (e) {
                e.preventDefault();
                var timetable = [];
                var id = $(this).attr('updateId');
                var name_timetable = '"' + 'timetable-' + id + '"';
                var input_timetable ="input[name^=" +name_timetable + "]";
                $(input_timetable).each(function(i) {
                    timetable[i] = $(this).val();
                });
                console.log(timetable);
                var form = new FormData();
                form.append("id", id);
                form.append("timetable" ,  timetable);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    contentType: false,
                    processData: false,
                    url: '{{route('admin.classes.updateTimetable')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: form,
                    success: function (response) {
                        console.log(response.data);
                        if (response.message == 'success') {
                            toastr.success('Cập nhập thành công' , 'Thành công')

                        }

                    }, error: function () {
                        alert("error!!!!");
                    },
                })

            });
        });
        @if(session('store'))
        swal("Thêm lớp thành công!", "", "success")
        @endif
        @if(session('ban'))
        swal("Đình chỉ lớp thành công!", "", "success")
        @endif
        @if(session('restore'))
        swal("Khôi phục lớp thành công!", "", "success")
        @endif
        @if(session('disable'))
        swal("Xóa tạm lớp thành công!", "", "success")
        @endif
        @if(session('is_admin'))
        swal("Không thể thực hiện hành động này với admin!", "", "error")
        @endif
        @if(session('yourself'))
        swal("Bạn không thể thực hiện hành động này với chính tài khoản hiện tại!", "", "error")
        @endif


    </script>
@endsection