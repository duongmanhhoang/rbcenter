<?php

namespace App\Http\Controllers\Admin;

use App\Api\Api;
use App\Http\Requests\Admin\CategoriesRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $api = new Api();
        if (isset($_GET['status'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/categories/paginate/10?type=2&status=' . $_GET['status'] . '&page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/categories/paginate/10?type=2&status=' . $_GET['status'])->data;
            }
            $url = route('admin.products.categories.index') . '?status=' . $_GET['status'];
        } elseif (isset($_GET['keyword'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/categories/paginate/10?type=2&name=*' . $_GET['keyword'] . '*&page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/categories/paginate/10?type=2&name=*' . $_GET['keyword'] . '*')->data;
            }
            $url = route('admin.products.categories.index') . '?keyword=' . $_GET['keyword'];
        } else {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/categories/paginate/10?type=2&status=1&page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/categories/paginate/10?type=2&status=1')->data;
            }
            $url = route('admin.products.categories.index');

        }


        $dataPaginate = collect($paginator->data);
        $categories = new LengthAwarePaginator(
            $dataPaginate,
            $paginator->total,
            $paginator->per_page,
            $paginator->current_page,
            ['path' => $url, 'pageName' => 'page']
        );
        return view('admin.products.categories.index', compact('categories'));
    }

    public function create()
    {
        $api = new Api();
        $parent_categories = $api->sendRequest('get', 'api/categories?type=2&status=1&parent_id=0')->data;
        $data = compact('parent_categories');
        return view('admin.products.categories.create', $data);
    }

    public function store(CategoriesRequest $request)
    {
        $api = new Api();
        $data = $request->all();
        $data['slug'] = Str::slug($data['name'], '-');
        $data['type'] = 2;
        if (!$request->parent_id) {
            $data['parent_id'] = 0;
        }
        $api->sendRequest('post', 'api/categories/store', $data);
        $request->session()->flash('store');
        return redirect(route('admin.products.categories.index'));
    }

    public function edit($id)
    {
        $api = new Api();
        $category = $api->sendRequest('get', 'api/categories/' . $id)->data;
        $parent_categories = $api->sendRequest('get', 'api/categories?id!=' . $id . '&type=2&status=1&parent_id=0')->data;
        $data = compact(
            'category',
            'parent_categories'
        );
        return view('admin.products.categories.edit', $data);
    }

    public function update(CategoriesRequest $request, $id)
    {
        $api = new Api();
        $data = $request->all();
        $data['slug'] = Str::slug($data['name'], '-');
        $data['type'] = 2;
        $api->sendRequest('post', 'api/categories/update/' . $id, $data);
        $request->session()->flash('update');
        return redirect()->back();
    }

    public function disable(Request $request, $id)
    {
        $api = new Api();
        $child = $api->sendRequest('get', 'api/categories?status=1&parent_id=' . $id)->data;
        $product = $api->sendRequest('get', 'api/products?status=1&cate_id=' . $id)->data;
        if (count($child) == 0 && count($product) == 0) {
            $api->sendRequest('get', 'api/categories/disable/' . $id);
            $request->session()->flash('disable');
            return redirect()->back();
        } elseif (count($child) > 0) {
            $request->session()->flash('error_has_child');
            return redirect()->back();
        }elseif (count($product) > 0){
            $request->session()->flash('error_has_product');
            return redirect()->back();
        }

    }

    public function restore(Request $request, $id)
    {
        $api = new Api();
        $api->sendRequest('get', 'api/categories/restore/' . $id);
        $request->session()->flash('restore');
        return redirect()->back();
    }
}
