@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="table-basic-5">
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th>角色</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->username}}}</td>
                        <td>@foreach($v->roles as $role) {{$role->name}}<br> @endforeach</td>
                        <td>{{$v->created_at or '-'}}</td>
                        <td><a href="javascript:if(confirm('确实要删除吗?'))location='/admin/users/del?id={{{$v->id}}}'">删除</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection