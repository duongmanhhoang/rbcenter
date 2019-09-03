<?php

namespace App\Http\Controllers\Admin;

use App\Api\Api;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $api = new Api();
        if (isset($_GET['status']) && isset($_GET['role_id']) && $_GET['status'] != '' && $_GET['role_id'] != '') {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=' . $_GET['page'] . '&status=' . $_GET['status'] . '&role_id=' . $_GET['role_id'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?status=' . $_GET['status'] . '&role_id=' . $_GET['role_id'])->data;

            };
            $url = route('admin.users.index') . '?role_id=' . $_GET['role_id'] . '&status=' . $_GET['status'];
        } elseif (isset($_GET['status']) && isset($_GET['role_id']) && $_GET['status'] == '' && $_GET['role_id'] == '') {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=1')->data;

            };
            $url = route('admin.users.index') . "?role_id=&status=";
        } elseif (isset($_GET['status']) && isset($_GET['role_id']) && $_GET['status'] == '') {

            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=' . $_GET['page'] . '&role_id=' . $_GET['role_id'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=1&role_id=' . $_GET['role_id'])->data;

            };
            $url = route('admin.users.index') . "?role_id=" . $_GET['role_id'] . "&status=";
        } elseif (isset($_GET['status']) && isset($_GET['role_id']) && $_GET['role_id'] == '') {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=' . $_GET['page'] . '&status=' . $_GET['status'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=1&status=' . $_GET['status'])->data;

            };
            $url = route('admin.users.index') . "?status=" . $_GET['status'] . "&role_id=";
        } elseif (isset($_GET['status'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=' . $_GET['page'] . '&status=' . $_GET['status'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=1&status=' . $_GET['status'])->data;

            };
            $url = route('admin.users.index') . "?status=" . $_GET['status'];

        } elseif (isset($_GET['role_id'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=' . $_GET['page'] . '&role_id=' . $_GET['role_id'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=1&role_id=' . $_GET['role_id'])->data;

            };
            $url = route('admin.users.index') . "?role_id=" . $_GET['role_id'];
        } elseif (isset($_GET['page'])) {
            $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=' . $_GET['page'])->data;
            $url = route('admin.users.index');
        } elseif (isset($_GET['keyword'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?email=*' . $_GET['keyword'] . '*&page=' . $_GET['page'])->data;
            } else {
                $paginator = $api->sendRequest('get', 'api/users/paginate/10?page=1&email=*' . $_GET['keyword'] . '*')->data;

            };
            $url = route('admin.users.index') . '?keyword=' . $_GET['keyword'];
        } else {
            $paginator = $api->sendRequest('get', 'api/users/paginate/10')->data;
            $url = route('admin.users.index');
        }

        $data = collect($paginator->data);


        $users = new LengthAwarePaginator(
            $data,
            $paginator->total,
            $paginator->per_page,
            $paginator->current_page,
            ['path' => $url, 'pageName' => 'page']
        );

        $data = compact(
            'users'
        );


        return view('admin.users.index', $data);

    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit($id)
    {
        $api = new Api();
        $user = $api->sendRequest('get', 'api/users/' . $id)->data;
        $data = compact(
            'user'
        );
        return view('admin.users.edit', $data);
    }

    public function store(CreateUserRequest $request)
    {
        $api = new Api();
        $data = $request->all();
        $data['slug'] = Str::slug($data['full_name'] . '-' . uniqid(), '-');
        $data['username'] = preg_replace('([\s]+)', '', $request->username);

        if ($request->hasFile('avatar')) {
            $avatar = $this->uploadImage($request->avatar);
            $data['avatar'] = $avatar->url;
        } else {
            $data['avatar'] = 'http://picture.local/images/default.png';
        }

        $store = $api->sendRequest('post', 'api/users/store', $data);
        if (isset($store->data->email[0]) && $store->data->email[0] == "The email has already been taken.") {
            $request->session()->flash('email_taken');
            return redirect()->back();
        }
        if ($store->data->username[0] && $store->data->username[0] == "The username has already been taken.") {
            $request->session()->flash('username_taken');
            return redirect()->back();
        }
        if ($store->message == "User created successfully") {
            if ($store->data->role_id == 500) {
                $latest_student_code = substr($api->sendRequest('get', 'api/student-info?order_by=id,desc&limit=1')->data[0]->student_code, '2', '5');
                $new_num = $latest_student_code + 1;
                $zero = '';
                for ($i = 0; $i < 5 - strlen($new_num); $i++) {
                    $zero = '0' . $zero;
                }
                $new_code = $zero . $new_num;
                $info['user_id'] = $store->data->id;
                $info['student_code'] = 'RB' . $new_code;

                $api->sendRequest('post', 'api/student-info/store', $info);
            }
        }
        $request->session()->flash('store');
        return redirect(route('admin.users.index'));
    }

    public
    function update(UpdateUserRequest $request, $id)
    {
        $data = $request->all();
        $data['username'] = preg_replace('([\s]+)', '', $request->username);
        if ($request->hasFile('avatar')) {
            $avatar = $this->uploadImage($request->avatar);
            $data['avatar'] = $avatar->url;
        } else {
            $data['avatar'] = $request->old_avatar;
        }
        $api = new Api();
        $update = $api->sendRequest('post', 'api/users/update/' . $id, $data);
        if (isset($update->data->email[0]) && $update->data->email[0] == "The email has already been taken.") {
            $request->session()->flash('email_taken');
            return redirect()->back();
        }
        if ($update->data->username[0] && $update->data->username[0] == "The username has already been taken.") {
            $request->session()->flash('username_taken');
            return redirect()->back();
        }
        $request->session()->flash('update');
        return redirect()->back();
    }

    public function disable(Request $request, $id)
    {
        $api = new Api();
        $user = $api->sendRequest('get', 'api/users/' . $id)->data;
        if ($user->id == session('admin')->id) {
            $request->session()->flash('yourself');
            return redirect()->back();
        }
        $api->sendRequest('get', 'api/users/disable/' . $id);
        $request->session()->flash('disable');
        return redirect()->back();
    }

    public function restore(Request $request, $id)
    {
        $api = new Api();
        $api->sendRequest('get', 'api/users/restore/' . $id);
        $request->session()->flash('restore');
        return redirect()->back();
    }

    public function ban(Request $request, $id)
    {
        $api = new Api();
        $user = $api->sendRequest('get', 'api/users/' . $id)->data;
        if (session('admin') && $user->id == session('admin')->id) {
            $request->session()->flash('yourself');
            return redirect()->back();
        }

        if (Cookie::get('cookie_admin') != null) {
            $cookie = json_decode(Cookie::get('cookie_admin'));
            if ($user->id == $cookie->id) {
                $request->session()->flash('yourself');
                return redirect()->back();
            }
        }
        $api->sendRequest('get', 'api/users/ban/' . $id);
        $request->session()->flash('ban');
        return redirect()->back();
    }

}
