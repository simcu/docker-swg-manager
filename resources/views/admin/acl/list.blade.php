@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="table-basic-5">
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>角色名称</th>
                    <th>资源名称</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->role->name}}}</td>
                        <td>{{{$v->host->name}}} （ http://{{{$v->host->url}}} ）</td>
                        <td>删除</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection