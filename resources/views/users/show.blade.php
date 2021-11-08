@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">{{ __('Show User') }} </span>
                    <span class="float-right"><a href="{{ route('users.index') }}" class="btn btn-sm ">Back to List</a></span>
                </div>

                <div class="card-body">

                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="prefixname" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-6">
                                <img src="{{ $user->avatar }} " alt="" class="img-thumbnail">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="prefixname" class="col-md-4 col-form-label text-md-right">{{ __('Prefix Name') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ $user->prefixname }}" readonly disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname"  value="{{ $user->firstname }}" readonly disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middlename" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>

                            <div class="col-md-6">
                                <input id="middlename" type="text" class="form-control" name="middlename"  value="{{ $user->middlename }}" readonly disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname"  value="{{ $user->lastname }}" readonly disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="suffixname" class="col-md-4 col-form-label text-md-right">{{ __('Suffix Name') }}</label>

                            <div class="col-md-6">
                                <input id="suffixname" type="text" class="form-control" name="suffixname" value="{{ $user->suffixname }}" readonly disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ $user->username }}" readonly disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" value="{{ $user->email }}" readonly disabled>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                            <div class="col-md-6">
                                <input id="type" type="text" class="form-control " required value="{{ ucfirst($user->type) }}" readonly disabled>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
