<?php

namespace App\Http\Controllers\Admin;

use App\Api\Api;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $api = new Api();
        if (isset($_GET['status'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/products/paginate/10?order_by=id,desc&status=' . $_GET['status'] . '&page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/products/paginate/10?order_by=id,desc&status=' . $_GET['status'])->data;
            }
            $url = route('admin.products.index') . '?status=' . $_GET['status'];
        } elseif (isset($_GET['keyword'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/products/paginate/10?order_by=id,desc&status=1&name=*' . $_GET['keyword'] . '*&page='.$_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/products/paginate/10?order_by=id,desc&status=1&name=*' . $_GET['keyword'] . '*')->data;
            }
            $url = route('admin.products.index').'?keyword='.$_GET['keyword'];
        } else {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/products/paginate/10?order_by=id,desc&status=1&page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/products/paginate/10?order_by=id,desc&status=1')->data;
            }

            $url = route('admin.products.index');
        }

        $dataPaginate = collect($paginator->data);
        $products = new LengthAwarePaginator(
            $dataPaginate,
            $paginator->total,
            $paginator->per_page,
            $paginator->current_page,
            ['path' => $url, 'pageName' => 'page']
        );

        $data = compact(
            'products'
        );
        return view('admin.products.index', $data);
    }

    public function create()
    {
        $api = new Api();
        $categories = $api->sendRequest('get', 'api/categories?type=2&status=1')->data;
        $data = compact(
            'categories'
        );
        return view('admin.products.create', $data);
    }

    public function edit($id)
    {
        $api = new Api();
        $product = $api->sendRequest('get', 'api/products/' . $id)->data;
        if ($product == []) {
            abort(404);
        };
        $categories = $api->sendRequest('get', 'api/categories?type=2&status=1')->data;;
        $data = compact(
            'product',
            'categories'
        );
        return view('admin.products.edit', $data);
    }

    public function store(CreateProductRequest $request)
    {
        if ($request->price != null && $request->sale_price != null) {
            $messages = array(
                'sale-price.lt' => 'Gía khuyến mãi phải nhỏ hơn giá gốc'
            );
            $rules = array(
                'sale_price' => 'lt:price'
            );
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect(route('admin.products.create'))->withErrors($validator)->withInput();
            }
        } elseif ($request->price == null && $request->sale_price != null) {
            $messages = array(
                'price.required' => 'Vui lòng nhập giá gốc nếu có giá khuyến mãi'
            );
            $rules = array(
                'price' => 'required'
            );
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect(route('admin.products.create'))->withErrors($validator)->withInput();
            }
        }


        $api = new Api();
        $data = $request->all();
        $data['slug'] = Str::slug($data['name'], '-');
        $data['created_by'] = Auth::custom()->id;
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request->image);
            $data['image'] = $image->url;
        };

        $product = $api->sendRequest('post', 'api/products/store', $data);
        if ($product->data->name[0] && $product->data->name[0] == "The name has already been taken.") {
            $request->session()->flash('name_taken');
            return redirect()->back();
        }

        $request->session()->flash('store');
        return redirect(route('admin.products.index'));

    }

    public function uploadVideo(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'video' => 'required|mimes:mp4,mov,ogg,qt,mp3',
            'name' => 'required|max:191'
        );

        $messages = array(
            'video.required' => 'Bạn chưa chọn video để tải lên',
            'video.mimes' => 'Chỉ chấp nhận những file định dạng mp4,mov,ogg,qt,mp3',
            'name.required' => 'Vui lòng nhập tên',
            'name.max' => 'Vui lòng không nhập quá 191 ký tự'
        );
        $validator = Validator::make($data, $rules,$messages);
        if ($validator->fails()) {
            return response()->json(['errors' => 'validation_errors', 'messages' => $validator->messages()], 200);
        }
        $api = new Api();
        $videos = $api->sendRequest('get' , 'api/videos')->data;
        foreach ($videos as $video){
            if($video->name == $data['name']){
                return response()->json(['errors' => 'name_used', 'messages' => 'Tên này đã được sử dụng'], 200);
            }
        }
        $video = $this->uploadFile($request->video);
        $data['video'] = $video['url'];
        $data['file_name'] = $video['file_name'];
        $data['slug'] = Str::slug($data['name'], '-');
        $data_video = $api->sendRequest('post' , 'api/videos/store' , $data)->data;
        return response()->json(['message' => 'success', 'data' => $data_video], 200);
    }

    public function deleteVideo(Request $request)
    {
        $data = $request->all();
        $api = new Api();
        $video = $api->sendRequest('get' , 'api/videos/delete/'.$data['id'])->data;
        $this->deleteFile($video->file_name);
        return response()->json(['message' => 'success'], 200);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        if ($request->price != null && $request->sale_price != null) {
            $messages = array(
                'sale-price.lt' => 'Gía khuyến mãi phải nhỏ hơn giá gốc'
            );
            $rules = array(
                'sale_price' => 'lt:price'
            );
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect(route('admin.products.edit', $id))->withErrors($validator)->withInput();
            }
        } elseif ($request->price == null && $request->sale_price != null) {
            $messages = array(
                'price.required' => 'Vui lòng nhập giá gốc nếu có giá khuyến mãi'
            );
            $rules = array(
                'price' => 'required'
            );
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect(route('admin.products.edit', $id))->withErrors($validator)->withInput();
            }
        }

        $data = $request->all();

        $api = new Api();
        $p = $api->sendRequest('get', 'api/products/' . $id)->data;
        $time = now()->toDateTimeString();
        $editer = Auth::custom()->id;

        if ($p->edited_by == null) {
            $arr = [$time => $editer];
            $data['edited_by'] = json_encode($arr);
        } else {
            $new = [$time => $editer];
            $arr = json_decode($p->edited_by, true);
            $new_arr = array_merge($arr, $new);
            $data['edited_by'] = json_encode($new_arr);
        }
        $data['slug'] = Str::slug($data['name'], '-');
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request->image);
            $data['image'] = $image->url;
        } else {
            $data['image'] = $data['old_image'];
        };
        if ($request->sale_status && $request->sale_status == 1) {
            $data['sale_status'] = 1;
        } else {
            $data['sale_status'] = 0;
        }

        $product = $api->sendRequest('post', 'api/products/update/' . $id, $data);
        if ($product->data->name[0] && $product->data->name[0] == "The name has already been taken.") {
            $request->session()->flash('name_taken');
            return redirect()->back();
        }

        $request->session()->flash('update');
        return redirect()->back();

    }

    public function disable(Request $request, $id)
    {
        $api = new Api();
        $api->sendRequest('get', 'api/products/disable/' . $id);
        $request->session()->flash('disable');
        return redirect()->back();
    }

    public function restore(Request $request, $id)
    {
        $api = new Api();
        $api->sendRequest('get', 'api/products/restore/' . $id);
        $request->session()->flash('restore');
        return redirect()->back();
    }
}
