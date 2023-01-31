@extends('layout.master')
@section('content')
<form action="{{ route("course.update",$course) }}" method="post">
    @csrf
    @method('put')
    Name
    <input type="text" name="name" value="{{$course->name}}">
    @if($errors->has('name'))
        <span>
            {{ $errors->first('name') }}
       </span>
    @endif
    <br>
    <button>edit</button>
</form>
@endsection
