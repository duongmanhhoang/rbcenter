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
                                    {{$class->name}}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-right" method="post"
                          action="{{route('admin.classes.update' , $class->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10">
                                <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                    Vui lòng không bỏ trống các ô có dấu *
                                </div>
                            </div>
                            <div class="form-group m-form__group">

                                <label>Ảnh đại diện</label>
                                <br>
                                <img id="is_image" src="{{$class->image}}"
                                     style="width: 500px; margin-bottom: 30px">
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="select_image" name="image"
                                           accept="image/*">
                                    <label class="custom-file-label" for="selectImage">Chọn ảnh</label>
                                </div>

                                @if($errors->has('image'))
                                    <p class="text-danger">{{$errors->first('image')}}</p>
                                @endif
                            </div>
                            <div class="form-group m-form__group">
                                <label>Tên lớp <b class="text-danger">*</b></label>
                                <input type="text" class="form-control m-input" name="name"
                                       placeholder="Nhập tên đăng nhập" value="{{old('name', $class->name)}}">
                                @if($errors->has('name'))
                                    <p class="text-danger">{{$errors->first('name')}}</p>
                                @endif
                                @if(session('name_taken'))
                                    <p class="text-danger">Tên lớp này đã được sử dụng</p>
                                @endif
                            </div>

                            <div class="form-group m-form__group">
                                <label>Giáo viên</label>

                                <select id="teacher_id" name="teacher_id" class="form-control m-input">
                                    <option></option>
                                    @foreach($teachers as $teacher)
                                        <option @if(isset($class->teacher_id) && $teacher->id == $class->teacher_id){{'selected'}}@endif value="{{$teacher->id}}">{{$teacher->full_name}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group m-form__group">
                                <label>Mô tả</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <textarea class="form-control m-input" id="description"
                                              name="description">{{old('description' , $class->description)}}</textarea>
                                </div>
                            </div>


                            <div class="form-group m-form__group row">
                                <div class="col-lg-6">
                                    <label>Ngày bắt đầu</label>
                                    <input type="text" class="form-control my-datepicker" name="start_day" readonly=""
                                           value="{{old('start_day' , $class->start_day)}}"
                                           placeholder="Nhập ngày bắt đầu lớp học">
                                    @if($errors->has('start_day'))
                                        <p class="text-danger">{{$errors->first('start_day')}}</p>
                                    @endif
                                </div>

                                <div class="col-lg-6">
                                    <label>Ngày kết thúc</label>
                                    <input type="text" class="form-control my-datepicker" name="end_day" readonly=""
                                           value="{{old('end_day' , $class->end_day)}}"
                                           placeholder="Nhập ngày kết thúc lớp học">
                                    @if($errors->has('end_day'))
                                        <p class="text-danger">{{$errors->first('end_day')}}</p>
                                    @endif
                                </div>

                            </div>

                        </div>
                        <input type="hidden" name="old_image" value="{{$class->image}}">

                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <button type="submit" class="btn btn-primary">Lưu</button>
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
        @if(session('update'))
            swal('Cập nhập thành công' , '' , 'success');
        @endif



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

            var BootstrapDatepicker = function () {
                var t;
                t = mUtil.isRTL() ? {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                } : {leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>'};
                return {
                    init: function () {
                        $(".my-datepicker").datepicker({
                            rtl: mUtil.isRTL(),
                            todayHighlight: !0,
                            orientation: "bottom left",
                            format: 'yyyy-mm-dd',
                            templates: t
                        })
                    }
                }
            }();
            jQuery(document).ready(function () {
                BootstrapDatepicker.init()
            });


            $('.my-datetimepicker').datetimepicker({
                todayHighlight: !0,
                autoclose: !0,
                format: "yyyy-mm-dd hh:ii"
            });


            $('#description').summernote({
                height: 500,
                toolbar: [
                    ['style', ['fontname', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture', 'link', 'video', 'table', 'hr']],
                    ['color', ['color']],
                    ['height', ['height']],
                    ['misc', ['codeview', 'undo', 'redo']]
                ]
            });
            $("#teacher_id").select2({placeholder: "Chọn giáo viên", allowClear: !0});

        })
    </script>
@endsection
