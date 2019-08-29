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
                                    Thêm sản phẩm
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-right" method="post"
                          action="{{route('admin.products.store')}}" enctype="multipart/form-data">
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
                                <img id="is_image" src="{{asset('images/default-image.png')}}"
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
                                <label>Tên sản phẩm <b class="text-danger">*</b></label>
                                <input type="text" class="form-control m-input" name="name"
                                       placeholder="Nhập tên sản phẩm" value="{{old('name')}}">
                                @if($errors->has('name'))
                                    <p class="text-danger">{{$errors->first('name')}}</p>
                                @endif
                                @if(session('name_taken'))
                                    <p class="text-danger">Tên sản phẩm này đã được sử dụng</p>
                                @endif
                            </div>


                            <div class="form-group m-form__group">
                                <label>Danh mục sản phẩm <b class="text-danger">*</b></label>

                                <select id="cate_id" name="cate_id" class="form-control m-input">
                                    <option></option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>

                                @if($errors->has('cate_id'))
                                    <p class="text-danger">{{$errors->first('cate_id')}}</p>
                                @endif

                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-md-5">
                                    <label>Giá sản phẩm</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="price" value="{{old('price')}}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>

                                    @if($errors->has('price'))
                                        <p class="text-danger">{{$errors->first('price')}}</p>
                                    @endif
                                </div>

                                <div class="col-md-5 offset-md-1">
                                    <label>Giá khuyến mãi (<span class="text-danger">tick vào ô bên cạnh nếu muốn áp dụng giá khuyến mãi</span>)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
														<span class="input-group-text">
															<label class="m-checkbox m-checkbox--single m-checkbox--state m-checkbox--state-success">
																<input type="checkbox" id="sale_status"
                                                                       name="sale_status" value="1">
																<span></span>
															</label>
														</span>
                                        </div>
                                        <input type="text" class="form-control" name="sale_price"
                                               value="{{old('sale_price')}}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>

                                    @if($errors->has('sale_price'))
                                        <p class="text-danger">{{$errors->first('sale_price')}}</p>
                                    @endif

                                    <p class="error-sale-price text-danger"></p>
                                </div>

                            </div>

                            <div class="form-group m-form__group">

                            </div>

                            <div class="form-group m-form__group">
                                <label>Mô tả</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <textarea class="form-control m-input" id="description"
                                              name="description">{{old('description')}}</textarea>
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
            $("#cate_id").select2({placeholder: "Chọn danh mục sản phẩm"});


            jQuery('#sale_status').change(function () {
                if ($("#sale_status").is(":checked")) {
                    $('form').on('submit',function (e) {
                        var sale_price = $('input[name=sale_price]').val();
                        if(sale_price.length == 0){
                            e.preventDefault();
                            $('.error-sale-price').text('Vui lòng nhập giá khuyến mãi khi đã bật khuyến mãi');
                        }
                    });
                }
            });
        })
    </script>
@endsection
