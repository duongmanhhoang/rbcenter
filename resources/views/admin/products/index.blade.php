@extends('admin.layouts.main')

@section('content')
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Danh sách sản phẩm
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
                                        <form method="get" action="{{route('admin.products.index')}}">
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
                            <a href="{{route('admin.products.create')}}"
                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
												<span>
													<i class="la la-plus"></i>
													<span>Thêm sản phẩm</span>
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
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($products as $product)
                        <tr>
                            <td>{{$i}}</td>
                            <td><img src="{{$product->image}}" style="width: 200px"></td>
                            <td>{{$product->name}}</td>
                            <td>

                                @if($product->price == null)
                                    <p class="text-danger">Miễn phí</p>
                                @elseif($product->sale_status == 0)
                                    <p class="price text-success">{{$product->price}} VNĐ</p>
                                @elseif($product->sale_status == 1)
                                    <p class="text-danger price">{{$product->sale_price}} VNĐ</p>
                                    <del class="price text-success">{{$product->price}} VNĐ</del>
                                @endif

                            </td>
                            <td>

                                <?php
                                if($product->cate_id != 0){
                                $api = new App\Api\Api();
                                $category = $api->sendRequest('get', 'api/categories/' . $product->cate_id)->data;
                                ?>

                                {{$category->name}}

                                <?php }else {
                                    echo 'Không có';
                                }
                                ?>
                            </td>
                            <td>
                                @if($product->status == 1)
                                    <a href="{{route('admin.products.edit' , $product->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                       title="Chỉnh sửa"><i class="la la-edit"></i> </a>

                                    <a href="javascript:;"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                       data-toggle="modal" data-target="#m_upload_videos_modal_{{$product->id}}"
                                       title="Upload Videos"><i class="la la-upload"></i> </a>

                                    <a href="javascript:;" linkurl="{{route('admin.products.disable' , $product->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-disable"
                                       title="Xóa tạm"><i class="la la-trash"></i> </a>

                                @elseif($product->status == 0)
                                    <a href="javascript:;" linkurl="{{route('admin.products.restore' , $product ->id)}}"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-restore"
                                       title="Khôi phục"><i class="la la-refresh"></i> </a>
                                @endif
                            </td>

                        </tr>
                        @php($i++)
                        <div class="modal fade" id="m_upload_videos_modal_{{$product->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tải videos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body row">
                                        <div class="col-6 border-right">
                                            <?php
                                            $api = new \App\Api\Api();
                                            $videos = $api->sendRequest('get', 'api/videos?product_id=' . $product->id)->data;
                                            ?>

                                            <ul id="list-videos-{{$product->id}}">
                                                @if(count($videos) > 0)
                                                    @foreach($videos as $video)
                                                        <li class="video-{{$video->id}}"><a href="{{$video->video}}">{{$video->name}}</a>
                                                            <span>
                                                                <a href="javascript:;" id="{{$video->id}}"
                                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-delete-video"
                                                                   title="Xóa"><i class="la la-trash"></i> </a>
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>

                                        </div>

                                        <div class="col-6 m--padding-left-30">
                                            <form enctype="multipart/form-data">
                                                <input type="hidden" id="product-id-{{$product->id}}"
                                                       value="{{$product->id}}">
                                                <div class="form-group m-form__group row">
                                                    <label>Chọn video</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                               id="video-{{$product->id}}"
                                                               name="video"
                                                               accept="video/*">
                                                        <label class="custom-file-label" for="selectImage">Chọn
                                                            video</label>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label>Tên video</label>
                                                    <input type="text" name="name" id="name-{{$product->id}}"
                                                           class="form-control"
                                                           autocomplete="off">
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <button class="btn btn-primary upload-video"
                                                            id="{{$product->id}}">Tải lên
                                                    </button>
                                                </div>
                                            </form>

                                            <b class="text-danger" id="status-{{$product->id}}"></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>

                {{$products->links()}}

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


            $(".btn-disable").click(function (e) {
                var removeUrl = $(this).attr('linkurl');
                swal({
                    title: "Bạn có chắc muốn xóa sản phẩm này?",
                    text: "Sau 30 ngày sản phẩm sẽ bị xóa vĩnh viễn",
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
                    title: "Bạn có chắc muốn khôi phục sản phẩm này?",
                    text: "",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "Hủy",
                    confirmButtonText: "Tôi chắc chắn"
                }).then(function (e) {
                    e.value && $(location).attr('href', removeUrl)
                })
            });

            $('.upload-video').click(function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                $('#status-' + id).text('Đang tải videos, vui lòng chờ giây lát...');
                var name = $('#name-' + id).val();
                var video = $('#video-' + id)[0].files[0];
                var form = new FormData();
                form.append("product_id", id);
                form.append("name", name);
                form.append("video", video);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    contentType: false,
                    processData: false,
                    url: '{{route('admin.products.video.upload')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: form,
                    success: function (response) {
                        $('#status-' + id).text('');
                        console.log(response);
                        if (response.message == 'success') {
                            $('#list-videos-'+id).prepend("<li class='video-"+response.data.id+"'><a href='"+response.data.video+"'>"+response.data.name+"</a></li>");
                            toastr.success('Tải lên thành công', 'Thành công')
                        }
                        else if (response.errors == 'name_used') {
                            toastr.error(response.messages, 'Cảnh báo!!')
                        }
                        else if(response.errors == 'validation_errors'){
                            if(response.messages.video){
                                toastr.error(response.messages['video'], 'Cảnh báo!!')
                            }else if(response.messages.name){
                                toastr.error(response.messages['name'], 'Cảnh báo!!')
                            }

                        }

                    }, error: function () {
                        $('#status-' + id).text('');
                        toastr.error('Đã có lỗi xảy ra', 'Cảnh báo')
                    },
                })


            });

            $('.btn-delete-video').click(function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var form = new FormData();
                form.append('id' , id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    contentType: false,
                    processData: false,
                    url: '{{route('admin.products.video.delete')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: form,
                    success: function (response) {
                        console.log(response);
                        $('.video-'+id).remove();
                        toastr.success('Xóa thành công', 'Thành công')

                    }, error: function () {
                        toastr.error('Đã có lỗi xảy ra', 'Cảnh báo')
                    },
                })


            });
        });

        @if(session('store'))
        swal("Thêm sản phẩm thành công!", "", "success")
        @endif

        @if(session('ban'))
        swal("Đình chỉ sản phẩm thành công!", "", "success")
        @endif

        @if(session('restore'))
        swal("Khôi phục sản phẩm thành công!", "", "success")
        @endif

        @if(session('disable'))
        swal("Xóa tạm sản phẩm thành công!", "", "success")
        @endif

        function numberWithCommas(number) {
            var parts = number.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(".");
        }

        $(document).ready(function () {
            $(".price").each(function () {
                var num = $(this).text();
                var commaNum = numberWithCommas(num);
                $(this).text(commaNum);
            });
        });


    </script>
@endsection