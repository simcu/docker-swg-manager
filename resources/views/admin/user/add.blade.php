@extends('admin.layout')

@section('content')
    <div class="panel-body">
        <form method="POST">
            <fieldset>
                <div class="form-group @if ($errors->has('username')) has-error @endif">
                    <label>用户名称：@if ($errors->has('username')) <font color="red">{{$errors->first('username')}}</font> @endif</label>
                    <input type="text" class="form-control ui-state-error" name="username"
                           value="{{old('username')}}">
                </div>
                <div class="form-group @if ($errors->has('password')) has-error @endif">
                    <label>登录密码： @if ($errors->has('password')) <font color="red">{{$errors->first('password')}}</font> @endif</label>
                    <input type="text" class="form-control" name="password" value="{{old('password') ?: 'ufenqi@123'}}">
                </div>
                {{csrf_field()}}
                <button type="submit" class="btn btn-sm btn-primary m-r-5">添加</button>
            </fieldset>
        </form>
    </div>
@endsection