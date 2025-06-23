@extends('layouts.app', ['page_title' => 'Students'])

@section('css')
    <style>
        .title {
            text-align: center;
            font-size: 2rem;
        }
    </style>
@endsection

@section('title', 'Students List')

@section('content')
    {{-- <div class="title">{{ $user->name }}</div> --}}

    <div class="mb-3">
        <a href="{{ route('students.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            Add Student</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show fs-5" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($isAdmin)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $key => $student)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>
                            <a href="{{ route('students.show', $student) }}">
                                {{ $student->fname }} {{ $student->lname }}
                            </a>
                        </td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->created_date }}</td>
                        <td>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal{{ $student->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>

                    {{-- Delete student modal using bootstrap --}}
                    <div class="modal fade" id="deleteUserModal{{ $student->id }}" tabindex="-1"
                        aria-labelledby="deleteUserModal{{ $student->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteStudentModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete {{ $student->name }} {{ $student->email }}? This
                                    action
                                    cannot
                                    be undone
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <td class="text-center" colspan="5">No Recorded Users.</td>
                @endforelse
            </tbody>
        </table>
    @else
        <div class="text-lg">Not Admin.</div>
    @endif

    {{-- Pagination links --}}
    <div class="mt-4">
        {{ $students->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        // alert("Hello")
    </script>
@endpush
