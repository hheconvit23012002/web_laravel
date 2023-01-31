<?php

namespace App\Http\Controllers;

use App\Enums\StudentStatusEnum;
use App\Models\Course;
use App\Models\Students;
use App\Http\Requests\StoreStudentsRequest;
use App\Http\Requests\UpdateStudentsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class StudentsController extends Controller
{

    private $model;
    public function __construct(){
        $this->model = new Students();
        $router = Route::currentRouteName();
        $arr = explode('.',$router);
        $arr = array_map('ucfirst',$arr);
        $routerName = implode(' - ',$arr);
        $arrStudentStatus = StudentStatusEnum::getArrayStatus();
        View::share('title', $routerName);
        View::share('arrStudentStatus', $arrStudentStatus);
    }
    public function index()
    {

        return view('student.index');
        //
    }
    public function apiName(Request $request){
        return $this->model::query()->where('name','like','%'.$request->get('q').'%')->get([
            'id',
            'name',
        ]);
    }
    public function api()
    {
        return DataTables::of($this->model::query()->with('course'))
            ->editColumn('birthdate', function ($object) {
                return $object->birthdate;
//                return $object->birthdate->format('Y-m-d');
            })
            ->addColumn('edit', function ($student) {
                return route('student.edit',$student);
            })
            ->addColumn('delete', function ($student) {
                return route('student.destroy',$student);
            })
            ->editColumn('status',function ($object){
                return StudentStatusEnum::getKeyByValue($object->status);
            })
            ->addColumn('course_name',function ($object){
                return $object->course->name;
            })
            ->filterColumn('course_name', function($query, $keyword) {
                $query->whereHas('course',function ($q) use ($keyword){
                    return $q->where('id',$keyword);
                });
            })
//            ->rawColumns(['delete'])
            ->make(true);
    }

    public function create()
    {
        $courses = Course::query()->get();
        return view('student.create',[
            'courses' => $courses,
        ]);
    }


    public function store(StoreStudentsRequest $request)
    {
//        dd($request->file('avatar'));
//        $path = Storage::putFile('avatars', $request->file('avatar')->getFilename());
        $arr           = $request->validated();
//        $arr['avatar'] = $path;
        $this->model->create($arr);

//        $arr['avatar'] = $path;
//        $this->model::query()->create($arr);
//        return redirect()->route('student.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show(Students $students)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit(Students $students)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentsRequest  $request
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentsRequest $request, Students $students)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy(Students $students)
    {
        //
    }
}
