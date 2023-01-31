@extends('layout.master')

@push('css')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/fc-4.2.1/fh-3.3.1/r-2.4.0/rg-1.3.0/sc-2.0.7/sb-1.4.0/sl-1.5.0/datatables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <a class="btn btn-success" href="{{ route("student.create") }}">
                Create
            </a>
            <div class="form-group flex-column">
                <select id="select-course-name" ></select>
            </div>
            <div class="form-group">
                <select class="select2-container" id="select-status">
                    <option value="0">Tất cả</option>
                    @foreach($arrStudentStatus as $key => $value)
                        <option value="{{ $value }} ">{{ $key }}</option>
                    @endforeach
                </select>
            </div>
            <table class="table table-striped table-centered mb-0" id="table-index">
                <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>age</th>
                    <th>status</th>
                    <th>course</th>
                    <th>updated</th>
                    <th>delete</th>
                </tr>
                </thead>
            </table>

        </div> <!-- end card body-->
    </div>

@endsection
@push('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/fc-4.2.1/fh-3.3.1/r-2.4.0/rg-1.3.0/sc-2.0.7/sb-1.4.0/sl-1.5.0/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $("#select-course-name").select2({
                ajax: {
                    url: "{{ route('course.api.name') }}",
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term,
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    // cache: true
                },
                placeholder: 'Search for a name',
                allowClear: true,
            });
            var buttonCommon = {
                exportOptions: {
                    columns: `:visible :not(.not-export)`
                }
            };
            var table = $('#table-index').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    $.extend( true, {}, buttonCommon, {
                        extend: 'copyHtml5'
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'excelHtml5'
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'pdfHtml5'
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'csvHtml5'
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'print'
                    } ),
                    'colvis'
                ],
                columnDefs: [
                    { className:'not-export',"targets": [5,6]},
                ],
                processing: true,
                select: true,
                serverSide: true,
                ajax: '{!! route('student.api') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'birthdate', name: 'birthdate'},
                    {data: 'status', name: 'status'},
                    {data: 'course_name', name: 'course_name'},
                    {
                        data: 'edit',
                        targets: 5,
                        "render": function (data, type, row, meta) {
                            return `<a class="btn btn-primary" href="${data}">
                                        edit
                                    </a>`;
                        }
                    },
                    {
                        data: 'delete',
                        targets: 6,
                        "render": function (data, type, row, meta) {
                            return `<form action="${data}" method="post">
                                @csrf
                                @method('Delete')
                                <button class="btn btn-danger">Delete</button>
                            </form>`;
                        }
                    }
                ]
            });
            $('#select-course-name').on( 'change', function () {
                table.columns(4).search( this.value ).draw();
            } );
            $('#select-status').on( 'change', function () {
                let value = this.value;
                if(value === "0"){
                    table.columns(3).search('').draw();
                }else{
                    table.columns(3).search( this.value ).draw();
                }

            } );
        });
    </script>
@endpush
