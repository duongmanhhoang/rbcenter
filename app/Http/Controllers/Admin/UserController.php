<?php

namespace App\Http\Controllers\Admin;

use App\Api\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $api = new Api();
        if (isset($_GET['status']) && isset($_GET['role_id']) && $_GET['role_id'] != '' && $_GET['status'] != '') {
            $users = $api->sendRequest('get', 'users?order_by=id,desc&status=' . $_GET['status'] . '&role_id=' . $_GET['role_id'])->data;
        } elseif (isset($_GET['role_id']) && $_GET['role_id'] == '' && $_GET['status'] != '' && !isset($_GET['keyword'])) {
            $users = $api->sendRequest('get', 'users?order_by=id,desc&status=' . $_GET['status'])->data;
        } elseif (isset($_GET['status']) && $_GET['status'] == '' && $_GET['role_id'] != '' && !isset($_GET['keyword'])) {
            $users = $api->sendRequest('get', 'users?order_by=id,desc&role_id=' . $_GET['role_id'])->data;
        } elseif (isset($_GET['status']) && isset($_GET['role_id']) && $_GET['status'] == '' && $_GET['role_id'] == '' && !isset($_GET['keyword'])) {
            $users = $api->sendRequest('get', 'users?order_by=id,desc')->data;
        } elseif (isset($_GET['keyword'])) {
            $users = $api->sendRequest('get', 'users?order_by=id,desc&email=*' . $_GET['keyword'] . '*')->data;
        } else {
            $users = $api->sendRequest('get', 'users?order_by=id,desc')->data;
        }

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
        $user = $api->sendRequest('get', 'users/' . $id)->data;
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
            $avatar = $this->uploadFile($request->avatar);
            $data['avatar'] = $avatar;
        } else {
            $data['avatar'] = 'https://drive.google.com/uc?id=1wvXU91pKvSpblr0BwoEHNQASlT6VFhsw&export=media';
        }

        $store = $api->sendRequest('post', 'users/store', $data);
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
                $latest_student_code = substr($api->sendRequest('get', 'student-info?order_by=id,desc&limit=1')->data[0]->student_code, '2', '5');
                $new_num = $latest_student_code + 1;
                $zero = '';
                for ($i = 0; $i < 5 - strlen($new_num); $i++) {
                    $zero = '0' . $zero;
                }
                $new_code = $zero.$new_num;
                $info['user_id'] = $store->data->id;
                $info['student_code'] = 'RB'.$new_code;

                $api->sendRequest('post', 'student-info/store', $info);
            }
        }
        $request->session()->flash('store');
        return redirect(route('admin.users.index'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->all();
        $data['username'] = preg_replace('([\s]+)', '', $request->username);
        if ($request->hasFile('avatar')) {
            $avatar = $this->uploadFile($request->avatar);
            $data['avatar'] = $avatar;
        } else {
            $data['avatar'] = $request->old_avatar;
        }
        $api = new Api();
        $update = $api->sendRequest('post', 'users/update/' . $id, $data);
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
        $user = $api->sendRequest('get', 'users/' . $id)->data;
        if ($user->role_id == 1) {
            $request->session()->flash('is_admin');
            return redirect()->back();
        }
        if ($user->id == session('admin')->id) {
            $request->session()->flash('yourself');
            return redirect()->back();
        }
        $api->sendRequest('get', 'users/disable/' . $id);
        $request->session()->flash('disable');
        return redirect()->back();
    }

    public function restore(Request $request, $id)
    {
        $api = new Api();
        $api->sendRequest('get', 'users/restore/' . $id);
        $request->session()->flash('restore');
        return redirect()->back();
    }

    public function ban(Request $request, $id)
    {
        $api = new Api();
        $user = $api->sendRequest('get', 'users/' . $id)->data;
        if ($user->role_id == 1) {
            $request->session()->flash('is_admin');
            return redirect()->back();
        }
        if ($user->id == session('admin')->id) {
            $request->session()->flash('yourself');
            return redirect()->back();
        }
        $api->sendRequest('get', 'users/ban/' . $id);
        $request->session()->flash('ban');
        return redirect()->back();
    }

}
