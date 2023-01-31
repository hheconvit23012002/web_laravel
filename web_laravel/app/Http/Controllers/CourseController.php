<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\StoreRequest;
use App\Http\Requests\Course\UpdateRequest;
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
//use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    private $model;
    public function __construct(){
        $this->model = new Course();
        $router = Route::currentRouteName();
        $arr = explode('.',$router);
        $arr = array_map('ucfirst',$arr);
        $routerName = implode(' - ',$arr);

        View::share('title', $routerName);
    }
    public function index(Request $request)
    {
        return view('course.index');

    }
    public function apiName(Request $request){
        return $this->model::query()->where('name','like','%'.$request->get('q').'%')->get([
            'id',
            'name',
        ]);
    }
    public function api()
    {
        return DataTables::of($this->model::query()->withCount('students')->get())
            ->editColumn('created_at', function ($object) {
                return $object->created_at->format('Y-m-d');
            })
            ->addColumn('edit', function ($course) {
                return route('course.edit',$course);
            })
            ->addColumn('destroy', function ($course) {
                if(checkSuperAdmin()){
                    return route('course.destroy',$course);
                }else{
                    return "#";                }
            })
//            ->addColumn('students_count')
//            ->rawColumns(['delete'])
            ->make(true);
    }

    public function create()
    {
        return view('course.create');
        //
    }


    public function store(StoreRequest $request)
    {
        //
//        $object = new Course();
//        $object->fill($request->validated());
//        $object->save();
        $this->model::query()->create($request->validated());
        return redirect()->route('course.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }


    public function edit(Course $course)
    {
        return view('course.edit', [
            'course' => $course
        ]);
    }


    public function update(UpdateRequest $request, $course)
    {

        $object = $this->model->where('id',$course)->first()->update($request->validated());

        return redirect()->route('course.index');
//        $course->update(
//          $request->validated(),
//        );
//        Course::where('id',$course->id)->update($request->except('_token','_method'));

    }


    public function destroy( $course)
    {
//        $course->delete();
        $this->model::query()->where('id', $course)->delete();
        return redirect()->route('course.index');
//        Course::destroy($course);
//        Course::where('id', $course)->delete();
    }
}
