@extends('admin.layout')

@section('content')
    <div class="panel-body">
        <form method="POST">
            <fieldset>
                <div class="form-group @if ($errors->has('name')) has-error @endif">
                    <label>显示名称：@if ($errors->has('name')) <font color="red">{{$errors->first('name')}}</font> @endif</label>
                    <input type="text" class="form-control ui-state-error" name="name"
                           value="{{old('name')}}">
                </div>
                <div class="form-group @if ($errors->has('url')) has-error @endif">
                    <label>URL地址 （不包含 http:// , 不支持 https）@if ($errors->has('url')) <font color="red">{{$errors->first('url')}}</font> @endif</label>
                    <input type="text" class="form-control" name="url" value="{{old('url')}}">
                </div>
                <div class="form-group @if ($errors->has('proxy')) has-error @endif">
                    <label>代理地址：(完整的proxy pass 地址) @if ($errors->has('proxy')) <font color="red">{{$errors->first('proxy')}}</font> @endif</label>
                    <input type="text" class="form-control" name="proxy" value="{{old('proxy')}}">
                </div>
                {{csrf_field()}}
                <button type="submit" class="btn btn-sm btn-primary m-r-5">添加</button>
            </fieldset>
        </form>
    </div>
@endsection