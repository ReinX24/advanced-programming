@extends('layouts.app', ['page_title' => 'Users'])

@section('css')
    <style></style>
@endsection

@section('title', 'Manage Users')

@section('content')
    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            Add New User</a>
    </div>

    @session('success')
        <div class="alert alert-success alert-dismissible fade show" role="alert" {{ session('success') }} <button type="button"
            class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession

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
            @forelse ($users as $key => $user)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>
                        <a href="{{ route('users.show', $user) }}">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                    {{-- <td>{{ \Carbon\Carbon::parse($user->created_at)->format('F d, Y h:i A (T)') }}</td> --}}
                    <td>{{ $user->created_date }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary btn-sm">Edit</a>

                        @if ($user->id !== Auth::user()->id)
                            <button onclick="removeUser({{ $user->id }})" class="btn btn-danger btn-sm">Delete</button>

                            {{-- <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal{{ $user->id }}">
                            Delete
                        </button> --}}
                        @endif
                    </td>
                </tr>

                {{-- Delete student modal using bootstrap --}}
                <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1"
                    aria-labelledby="deleteUserModal{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteStudentModalLabel">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete {{ $user->name }} {{ $user->email }}? This action
                                cannot
                                be undone
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
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

    {{-- Pagination links --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        function removeUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('client/users') }}/" + id,
                    dataType: "json",
                    success: function(response) {
                        alert('User deleted successfully!');
                        location.reload();
                    }
                });
            }
        }
    </script>
@endpush
