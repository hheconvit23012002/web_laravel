@extends('layout.master')

@push('css')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/fc-4.2.1/fh-3.3.1/r-2.4.0/rg-1.3.0/sc-2.0.7/sb-1.4.0/sl-1.5.0/datatables.min.css"/>
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <a class="btn btn-success" href="{{ route("course.create") }}">
                Create
            </a>
            <div class="form-group">
                <select id="select-name"></select>
            </div>
            <table class="table table-striped table-centered mb-0" id="table-index">
                <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>created_at</th>
                    <th>student number</th>
                    <th>updated</th>
                    @if(checkSuperAdmin())
                        <th>delete</th>
                    @endif

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
    <script src="vendor/select2/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $("#select-name").select2({
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
                    @if(checkSuperAdmin())
                        { className:'not-export',"targets": [4,5]},
                    @else
                        { className:'not-export',"targets": [4]},
                    @endif
                ],
                // c
                processing: true,
                select: true,
                serverSide: true,
                ajax: '{!! route('course.api') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'students_count', name: 'students_count'},
                    {
                        data: 'edit',
                        targets: 4,
                        "render": function (data, type, row, meta) {
                            return `<a class="btn btn-primary" href="${data}">
                                        edit
                                    </a>`;
                        }
                    },
                    @if(checkSuperAdmin())
                        {
                            data: 'destroy',
                            targets: 5,
                            "render": function (data, type, row, meta) {
                                return `<form action="${data}" method="post">
                                    @csrf
                                    @method('Delete')
                                    <button class="btn btn-danger">Delete</button>
                                </form>`;
                            }
                        }
                    @endif
                ]
            });
            $('#select-name').on( 'change', function () {
                table.columns(0).search( this.value ).draw();
            });
        });
    </script>
@endpush
