@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">{{ __('Users') }} </span>
                    <span class="float-right"><a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Add User</a></span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($users) > 0)
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ $user->username ? $user->username : 'n/a' }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ Str::ucfirst($user->type) }}</td>
                                            <td>{{ $user->created_at->format('m-d-y h:i:sA') }}</td>
                                            <td>
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-secondary text-dark">
                                                    Show
                                                </a>
                                                |
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning text-dark">
                                                    Edit
                                                </a>
                                                |
                                                <button type="button" onclick="event.preventDefault();if(confirm('Are you sure to delete?'))
                                                document.getElementById('deleteRecord{{$user->id}}').submit();" class="btn btn-sm btn-outline-danger text-dark">
                                                    Delete
                                                </button>
                                                {{ Form::open(array('url' => route('users.destroy', $user->id), 'method' => 'DELETE', 'id'=> 'deleteRecord'.$user->id)) }}

                                                {{ Form::close() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <div class="alert alert-warning">No Record Found!</div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('users.trashed') }}">Trashed</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
