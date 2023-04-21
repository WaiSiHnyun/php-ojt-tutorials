@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <a href="{{ route('students.create') }}" class="btn btn-primary mt-5 mb-3">Create</a>
            <div class="mt-5 d-flex">
                <div>
                    <a href="{{ route('students.export') }}" class="btn btn-primary">Export</a>
                </div>
                <form action="{{ route('students.import') }}" method="POST" 
                    enctype="multipart/form-data" id="import-form">
                    @csrf
                    <input type="file" name="file" id="file" class="form-control" hidden>
                    <button type="button" id="import-btn" class="btn btn-primary ms-2">Import</button>
                </form>
            </div>
        </div>
        <div class="card rounded mb-5">
            <div class="card-header">
                <h2>Student Lists</h2>
            </div>
            <div class="card-body">
                @if (count($students) > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Major</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <th>{{ $student->id }}</th>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->major->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->address }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('students.edit', $student->id) }}"
                                            class="btn btn-sm btn-success">Edit</a>
                                        <form action="{{ route('students.destroy', $student->id) }}" 
                                            method="POST" onsubmit="return confirmDelete();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ms-2 btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $students->links() }}
                @else
                    <p class="text-danger">There is no data of students</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/script.js') }}"></script>

    @if (session()->has('errors'))
        <script>
            const errors = @json(session('errors')->all());
            window.onload = function() {
                alert(errors);
            }
        </script>
    @endif

    @if (session('success'))
        <script>
            window.onload = function() {
                alert('{{ session("success") }}');
            }
        </script>
    @endif

@endpush