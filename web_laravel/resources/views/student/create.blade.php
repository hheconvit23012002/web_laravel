@extends('layout.master')
@section('content')

<form action="{{ route("student.store") }}" method="post" enctype="multipart/form-data">
    @csrf
    Name
    <input type="text" name="name" value="{{ old('name') }}" >
    <br>
    Gender
    <br>
    <input type="radio" value="0" name="gender" checked> Nam
    <br>
    <input type="radio" value="1" name="gender"> Nu
    <br>
    BirthDate
    <input type="date" name="birthdate">
    <br>
    Status
    @foreach($arrStudentStatus as $option => $value)
        <input type="radio" name="status" value="{{ $value }}"
           @if ($loop->first)
               checked
            @endif
        > {{ $option }}
    @endforeach
    <br>
{{--    Avatar--}}
{{--    <input type="file" name="avatar" >--}}
{{--    <br>--}}
    <select name="course_id">
        @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->name }}</option>
        @endforeach
    </select>
    <br>
    <button>Add</button>
</form>
@endsection
