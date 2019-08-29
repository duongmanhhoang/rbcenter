<?php

namespace App\Http\Controllers\Admin;

use App\Api\Api;
use App\Exports\ExportStudentList;
use App\Http\Requests\Admin\StoreClassRequest;
use App\Http\Requests\Admin\UpdateClassesRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ClassController extends Controller
{
    public function index()
    {
        $api = new Api();
        if (isset($_GET['status'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/classes/paginate/10?order_by=id,desc&status=' . $_GET['status'] . '&page=' . $_GET['page'])->data;

            } else {
                $paginator = $api->sendRequest('get', 'api/classes/paginate/10?order_by=id,desc&status=' . $_GET['status'])->data;
            }

            $url = route('admin.classes.index') . '?status=' . $_GET['status'];
        } else if (isset($_GET['keyword'])) {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/classes/paginate/10?order_by=id,desc&status=1&name=*' . $_GET['keyword'] . '*&page='.$_GET['page'])->data;

            } else {
                $paginator = $api->sendRequest('get', 'api/classes/paginate/10?order_by=id,desc&status=1&name=*' . $_GET['keyword'] . '*')->data;
            }

            $url = route('admin.classes.index') . '?keyword=' . $_GET['keyword'];

        } else {
            if (isset($_GET['page'])) {
                $paginator = $api->sendRequest('get', 'api/classes/paginate/10?order_by=id,desc&status=1&page=' . $_GET['page'])->data;

            } else {
                $paginator = $api->sendRequest('get', 'api/classes/paginate/10?order_by=id,desc&status=1')->data;
            }

            $url = route('admin.classes.index');
        }



        $dataPaginate = collect($paginator->data);

        $classes = new LengthAwarePaginator(
            $dataPaginate,
            $paginator->total,
            $paginator->per_page,
            $paginator->current_page,
            ['path' => $url, 'pageName' => 'page']

        );
        $data = compact(
            'classes'
        );
        return view('admin.classes.index', $data);
    }

    public function create()
    {
        $api = new Api();
        $teachers = $api->sendRequest('get', 'api/users?role_id=400&status=1')->data;
        $data = compact(
            'teachers'
        );
        return view('admin.classes.create', $data);
    }

    public function store(StoreClassRequest $request)
    {
        $data = $request->all();
        $api = new Api();
//        $data['timetable'] = implode($data['timetable'] , ',');
//        $data['student_code'] = implode($data['student_code'], ',');
        $data['slug'] = Str::slug($data['name'], '-');
        $data['image'] = $this->uploadImage($request->image)->url;

        $api->sendRequest('post', 'api/classes/store', $data);
        $request->session()->flash('store');
        return redirect(route('admin.classes.index'));

    }

    public function studentList($id)
    {
        $api = new Api();
        $students = $api->sendRequest('get', 'api/users?role_id=500&status=1')->data;
        $class = $api->sendRequest('get', 'api/classes/' . $id)->data;
        $current_students = explode(',', $class->student_code);
        $students_notin = $api->sendRequest('get', 'api/classes/' . $id . '/not-in-class')->data;
        $data = compact(
            'students',
            'class',
            'current_students',
            'students_notin'
        );
        return view('admin.classes.studentList', $data);
    }

    public function addStudent($id, Request $request)
    {
        $data = $request->all();
        $api = new Api();
        $class = $api->sendRequest('get', 'api/classes/' . $id)->data;
        if ($class->student_code == '') {
            $student_codes = [];
        } else {
            $student_codes = explode(',', $class->student_code);
        }

        if ($request->has('list_student_code')) {
            $new_arr = array_merge($student_codes, $data['list_student_code']);
            $new = implode(',', $new_arr);
            $data['student_code'] = $new;
            $api->sendRequest('post', 'api/classes/updateStudents/' . $id, $data);
            $request->session()->flash('update');
            return redirect()->back();
        } else {
            array_push($student_codes, $request->student_code);
            $new = implode(',', $student_codes);
            $data['student_code'] = $new;
            $api->sendRequest('post', 'api/classes/updateStudents/' . $id, $data);
            $request->session()->flash('update');
            return redirect()->back();
        }


    }

    public function deleteStudent(Request $request, $id, $student_code)
    {
        $api = new Api();
        $class = $api->sendRequest('get', 'api/classes/' . $id)->data;
        $arr = explode(',', $class->student_code);
        $key = array_search($student_code, $arr);
        unset($arr[$key]);
        $new = implode(',', $arr);
        $data['student_code'] = $new;
        $api->sendRequest('post', 'api/classes/updateStudents/' . $id, $data);
        $request->session()->flash('delete');
        return redirect()->back();
    }

    public function updateTimetable(Request $request)
    {
        $data = $request->all();
        $api = new Api();
        $api->sendRequest('post', 'api/classes/updateTimetable/' . $data['id'], $data);
        return response()->json(['message' => 'success', 'data' => $data['timetable']], 200);
    }

    public function edit($id)
    {
        $api = new Api();
        $class = $api->sendRequest('get', 'api/classes/' . $id)->data;
        $teachers = $api->sendRequest('get', 'api/users?role_id=400&status=1')->data;
        if ($class == []) {
            abort(404);
        }

        $data = compact(
            'class',
            'teachers'
        );
        return view('admin.classes.edit', $data);

    }

    public function update(UpdateClassesRequest $request, $id)
    {
        $api = new Api();
        $data = $request->all();
        $data['slug'] = Str::slug($data['name'], '-');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->image)->url;
        } else {
            $data['image'] = $request->old_image;
        }
        $class = $api->sendRequest('post', 'api/classes/update/' . $id, $data);
        if (isset($class->data->name[0]) && $class->data->name[0] == "The name has already been taken.") {
            $request->session()->flash('name_taken');
            return redirect()->back();
        }
        $request->session()->flash('update');
        return redirect()->back();
    }

    public function export($id)
    {
        $api = new Api();
        $object = new \stdClass();
        $object->student_code = 'Mã sinh viên';
        $object->full_name = 'Tên sinh viên';
        $object->email = 'Email';
        $object->phone = 'Số điện thoại';
        $object->address = 'Địa chỉ';
        $class = $api->sendRequest('get', 'api/classes/' . $id)->data;
        $list = $api->sendRequest('get', 'api/classes/' . $id . '/listExportStudent')->data;
        array_unshift($list, $object);
        $export = new ExportStudentList([
            $list
        ]);

        return Excel::download($export, $class->name . '.xlsx');
    }

    public function disable(Request $request, $id)
    {
        $api = new Api();
        $api->sendRequest('get', 'api/classes/disable/' . $id);
        $request->session()->flash('disable');
        return redirect()->back();
    }

    public function restore(Request $request, $id)
    {
        $api = new Api();
        $api->sendRequest('get', 'api/classes/restore/' . $id);
        $request->session()->flash('restore');
        return redirect()->back();
    }


    public function ban(Request $request, $id)
    {
        $api = new Api();
        $api->sendRequest('get', '/api/classes/ban/' . $id);
        $request->session()->flash('ban');
        return redirect()->back();
    }
}
