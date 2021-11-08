@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">{{ __('Trashed User') }} </span>
                    <span class="float-right"><a href="{{ route('users.index') }}" class="btn btn-sm ">Back to List</a></span>
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
                                    <th>Deleted At</th>
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
                                            <td>{{ $user->deleted_at->format('m-d-y h:i:sA') }}</td>
                                            <td>
                                                <button type="button" onclick="event.preventDefault();if(confirm('Are you sure to restore?'))
                                                document.getElementById('restoreRecord{{$user->id}}').submit();" class="btn btn-sm btn-outline-success text-dark">
                                                    Restore
                                                </button>
                                                {{ Form::open(array('url' => route('users.restore', $user->id), 'method' => 'PATCH', 'id'=> 'restoreRecord'.$user->id)) }}

                                                {{ Form::close() }}
                                                |
                                                <button type="button" onclick="event.preventDefault();if(confirm('Are you sure to delete?'))
                                                document.getElementById('deleteRecord{{$user->id}}').submit();" class="btn btn-sm btn-outline-danger text-dark">
                                                    Delete
                                                </button>
                                                {{ Form::open(array('url' => route('users.delete', $user->id), 'method' => 'DELETE', 'id'=> 'deleteRecord'.$user->id)) }}

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
            </div>
        </div>
    </div>
</div>
@endsection
