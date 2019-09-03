@extends('admin.layouts.main')

@section('content')
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Danh sách học viên: {{$class->name}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-4">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Danh sách học viên hiện tại
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="m-portlet__body">
                            @if($current_students[0] != "")
                                <table>
                                    @foreach($current_students as $current_student)
                                        <?php
                                        $api = new App\Api\Api();
                                        $student_id = $api->sendRequest('get', 'api/student-info?student_code=' . $current_student)->data[0]->user_id;
                                        $student_name = $api->sendRequest('get', 'api/users/' . $student_id)->data->full_name;
                                        ?>
                                        <tr>
                                            <td class="current-student-td">{{$current_student}} - {{$student_name}}</td>
                                            <td class="current-student-td-delete">
                                                <a href="javascript:;"
                                                   linkurl="{{route('admin.classes.deleteStudent' , [$class->id, $current_student])}}"
                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-delete"
                                                   title="Xóa khỏi danh sách"><i class="la la-trash"></i></a>
                                            </td>
                                        </tr>
                                        </p>



                                    @endforeach
                                </table>

                            @endif

                        </div>
                    </div>
                    <div class="col-7">
                        <!--begin: Search Form -->
                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                            <div class="row align-items-center">

                                <div class="col-xl-8 order-2 order-xl-1">

                                    <div class="form-group m-form__group row align-items-center">
                                        <div class="col-md-8">
                                            <div class="m-input-icon m-input-icon--left">
                                                <form method="get" action="{{route('admin.classes.index')}}">
                                                    <input type="text" class="form-control m-input" name="keyword"
                                                           placeholder="Tìm kiếm" id="generalSearch">
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

                                <div class="col-xl-4 order-2 order-xl-1">
                                    <form id="form1" method="post"
                                          action="{{route('admin.classes.addStudent' , $class->id)}}">
                                        @csrf

                                        <div id="list_hidden_checkbox">

                                        </div>
                                        <button type="submit" class="btn btn-dark" id="add_student_btn">Thêm vào danh
                                            sách
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>

                        <!--end: Search Form -->

                        <!--begin: Datatable -->
                        <table class="m-datatable" id="html_table" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>Mã số sinh viên</th>
                                <th>Tên sinh viên</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students_notin as $student)
                                <tr>
                                    <td>
                                        <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                            <input type="checkbox" name="students[]" value="{{$student->student_code}}"
                                                   class="m-checkable checkbox_student_codes">
                                            <span></span>
                                        </label>
                                    </td>

                                    <td>{{$student->student_code}}</td>
                                    <td>{{$student->full_name}}</td>
                                    <td>
                                        <form method="post" action="{{route('admin.classes.addStudent' , $class->id)}}">
                                            @csrf
                                            <input type="hidden" name="student_code" value="{{$student->student_code}}">
                                            <button type="submit"
                                                    class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                                    title="Thêm vào danh sách"><i class="la la-plus"></i></button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>


                        <!--end: Datatable -->
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(() => {
            $(".m-datatable").mDatatable({
                data: {saveState: {cookie: !1}},
                search: {input: $("#generalSearch")},
            }),
                $('#add_student_btn').attr("disabled", true);
            jQuery('.checkbox_student_codes').change(function () {
                if ($(".checkbox_student_codes").is(":checked")) {
                    var value = this.value;
                    $('#list_hidden_checkbox').append("  <input type=\"hidden\" name=\"list_student_code[]\" id=\"list_student_code\" value=" + this.value + ">");
                    $('#add_student_btn').attr("disabled", false);
                    $('#add_student_btn').removeClass('btn-dark').addClass('btn-primary');

                }
                else {
                    $('#add_student_btn').attr("disabled", true);
                    $('#add_student_btn').removeClass('btn-primary').addClass('btn-dark');
                }
            });


            $(".btn-delete").click(function (e) {
                var removeUrl = $(this).attr('linkurl');
                swal({
                    title: "Bạn có chắc muốn xóa học sinh này ra khỏi lớp học?",
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

        @if(session('update'))
        swal('Cập nhập danh sách học sinh thành công', '', 'success');
        @endif

        @if(session('delete'))
        swal('Xóa học sinh thành công', '', 'success');
        @endif


    </script>
@endsection