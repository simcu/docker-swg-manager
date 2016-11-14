@extends('admin.layout')

@section('content')
    <div class="panel-body">
        <form method="POST">
            <fieldset>
                <div class="form-group @if ($errors->has('name')) has-error @endif">
                    <label>名称：@if ($errors->has('name')) <font color="red">{{$errors->first('name')}}</font> @endif</label>
                    <input type="text" class="form-control ui-state-error" name="name"
                           value="{{old('name')}}">
                </div>
                {{csrf_field()}}
                <button type="submit" class="btn btn-sm btn-primary m-r-5">添加</button>
            </fieldset>
        </form>
    </div>
@endsection