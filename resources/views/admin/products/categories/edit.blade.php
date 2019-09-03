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
                                    {{$category->name}}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-right" method="post"
                          action="{{route('admin.products.categories.update' , $category->id)}}">
                        @csrf
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10">
                                <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                    Vui lòng không bỏ trống các ô có dấu *
                                </div>
                            </div>
                            <div class="form-group m-form__group">
                                <label>Tên danh mục <b class="text-danger">*</b></label>
                                <input type="text" class="form-control m-input" name="name"
                                       placeholder="Nhập tên danh mục" value="{{old('name' , $category->name)}}">
                                @if($errors->has('name'))
                                    <p class="text-danger">{{$errors->first('name')}}</p>
                                @endif
                                @if(session('name_taken'))
                                    <p class="text-danger">Tên danh mục này đã được sử dụng</p>
                                @endif
                            </div>


                            <div class="form-group m-form__group">
                                <label>Danh mục cha</label>
                                <select id="parent_id" name="parent_id" class="form-control m-input">
                                    <option></option>
                                    <option @if($category->parent_id == 0){{'selected'}}@endif value="0">Không có
                                    </option>
                                    @foreach($parent_categories as $item)
                                        <option value="{{$item->id}}" @if($category->parent_id == $item->id){{'selected'}}@endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
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
                                <button type="submit" class="btn btn-primary">Sửa</button>
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
            swal('Cập nhập sản phẩm thành công', '' ,'success');
        @endif
        $(document).ready(() => {

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
            $("#parent_id").select2({placeholder: "Chọn danh mục cha"});

        })
    </script>
@endsection
