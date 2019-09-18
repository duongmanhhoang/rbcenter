<?php

namespace App\Http\Controllers\Admin;

use App\Api\Api;
use App\Http\Controllers\Authenticate\AuthController;
use App\Http\Requests\Admin\CreatePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $api = new Api();
        if (isset($_GET['status'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/posts/paginate/10?order_by=id,desc&status=' . $_GET['status'] . '&page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/posts/paginate/10?order_by=id,desc&status=' . $_GET['status'])->data;
            }
            $url = route('admin.posts.index') . '?status=' . $_GET['status'];
        } elseif (isset($_GET['keyword'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/posts/paginate/10?order_by=id,desc&status=1&title=*' . $_GET['keyword'] . '*&page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/posts/paginate/10?order_by=id,desc&status=1&title=*' . $_GET['keyword'] . '*')->data;
            }
            $url = route('admin.posts.index') . '?keyword=' . $_GET['keyword'];
        } else {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/posts/paginate/10?order_by=id,desc&status=1&page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/posts/paginate/10?order_by=id,desc&status=1')->data;
            }

            $url = route('admin.posts.index');
        }
        $dataPaginate = collect($paginator->data);
        $posts = new LengthAwarePaginator(
            $dataPaginate,
            $paginator->total,
            $paginator->per_page,
            $paginator->current_page,
            ['path' => $url, 'pageName' => 'page']
        );

        $data = compact(
            'posts'
        );
        return view('admin.posts.index', $data);
    }

    public function create()
    {
        $api = new Api();
        $categories = $api->sendRequest('get', 'api/categories?type=1&status=1')->data;
        return view('admin.posts.create', compact('categories'));
    }

    public function store(CreatePostRequest $request)
    {
        $api = new Api();
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $data['created_by'] = AuthController::user()->id;
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->image)->url;
        }
        if (!$request->cate_id) {
            $data['cate_id'] = 0;
        }
        $post = $api->sendRequest('post', 'api/posts/store', $data);
        if ($post->data->title[0] && $post->data->title[0] == "The title has already been taken.") {
            $request->session()->flash('title_taken');
            return redirect()->back();
        }
        $request->session()->flash('store');
        return redirect(route('admin.posts.index'));
    }

    public function edit($id)
    {
        $api = new Api();
        $post = $api->sendRequest('get', 'api/posts/' . $id)->data;
        if ($post == []) {
            abort(404);
        };
        $categories = $api->sendRequest('get', 'api/categories?type=1&status=1')->data;;
        $data = compact(
            'post',
            'categories'
        );
        return view('admin.posts.edit', $data);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $api = new Api();
        $data = $request->all();
        $post = $api->sendRequest('get', 'api/posts/' . $id)->data;
        $editer =AuthController::user()->id;
        $time = now()->toDateTimeString();
        if ($post->edited_by == null) {
            $arr = [$time => $editer];
            $data['edited_by'] = json_encode($arr);
        } else {
            $new = [$time => $editer];
            $arr = json_decode($post->edited_by, true);
            $new_arr = array_merge($arr, $new);
            $data['edited_by'] = json_encode($new_arr);
        }
        $data['slug'] = Str::slug($data['title'], '-');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->image)->url;
        } else {
            $data['image'] = $request->old_image;
        }
        $post = $api->sendRequest('post', 'api/posts/update/'.$id, $data);
        if ($post->data->title[0] && $post->data->title[0] == "The title has already been taken.") {
            $request->session()->flash('title_taken');
            return redirect()->back();
        }
        $request->session()->flash('update');
        return redirect()->back();
    }

    public function disable()
    {

    }
}
