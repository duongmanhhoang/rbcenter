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
                                    {{ $post->title }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-right" method="post"
                          action="{{route('admin.posts.update', $post->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10">
                                <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                    Vui lòng không bỏ trống các ô có dấu *
                                </div>
                            </div>
                            <div class="form-group m-form__group">

                                <label>Ảnh</label>
                                <br>
                                <img id="is_image" src="{{ $post->image }}"
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
                                <label>Tiêu đề bài viết <b class="text-danger">*</b></label>
                                <input type="text" class="form-control m-input" name="title"
                                       placeholder="Nhập tên bài viết" value="{{old('title', $post->title)}}">
                                @if($errors->has('title'))
                                    <p class="text-danger">{{$errors->first('title')}}</p>
                                @endif
                                @if(session('title_taken'))
                                    <p class="text-danger">Tên bài viết này đã được sử dụng</p>
                                @endif
                            </div>


                            <div class="form-group m-form__group">
                                <label>Danh mục bài viết</label>
                                <select id="cate_id" name="cate_id" class="form-control m-input">
                                    <option></option>
                                    <option value="0" @if($post->cate_id == 0){{ 'selected' }}@endif>Không có</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if($post->cate_id == $category->id){{ 'selected' }}@endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group m-form__group">
                                <label>Mô tả ngắn <b class="text-danger">*</b></label>
                                <textarea class="form-control m-input" id="description" name="description"
                                          rows="10">{{old('description', $post->description)}}</textarea>
                            </div>

                            <div class="form-group m-form__group">
                                <label>Nội dung <b class="text-danger">*</b></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <textarea class="form-control m-input" id="body"
                                              name="body">{{old('body', $post->body)}}</textarea>
                                </div>
                            </div>

                            <div class="form-group m-form__group">
                                <label>Keywords</label>
                                <input type="text" class="form-control m-input" name="keywords"
                                       placeholder="Keywords được phân cách bởi dấu phẩy"
                                       value="{{old('keywords', $post->keywords)}}">
                            </div>
                        </div>
                        <input type="hidden" name="old_image" value="{{ $post->image }}">


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


            $('#body').summernote({
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
            $("#cate_id").select2({placeholder: "Chọn danh mục bài viết"});
        })

        @if(session('update'))
            swal('Cập nhập thành công', '', 'success');
        @endif
    </script>
@endsection
