@extends('admin.layout')

@section('content')
    @unless($role->id == 1)
        <legend>权限列表：</legend>
        <div class="panel panel-inverse" data-sortable-id="table-basic-5">
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>名称</th>
                        <th>URL</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($role->acls as $v)
                        <tr>
                            <td>{{{$v->host->id}}}</td>
                            <td>{{{$v->host->name}}}</td>
                            <td>{{{$v->host->url}}}</td>
                            <td>
                                <a href="javascript:if(confirm('确实要删除吗?'))location='/admin/roles/detail/host/del?rid={{{$role->id}}}&hid={{{$v->host->id}}}'">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <form method="POST" action="/admin/roles/detail/host/add">
                    <div class="form-group">
                        <div class="col-md-10">
                            <select class="form-control" name="hid">
                                <option value="" selected="">选择要添加的主机</option>
                                @foreach($hosts as $lh)
                                    <option value="{{{$lh->id}}}">{{{$lh->name}}} - {{{$lh->url}}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{{csrf_field()}}}
                        <input type="hidden" name="rid" value="{{{$role->id}}}">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-primary m-r-5">添加</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endunless

    <legend>用户列表：</legend>
    <div class="panel panel-inverse" data-sortable-id="table-basic-5">
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>用户名称</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($role->users as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->username}}}</td>
                        <td>{{{$v->created_at}}}</td>
                        <td>
                            <a href="javascript:if(confirm('确实要删除吗?'))location='/admin/roles/detail/user/del?rid={{{$role->id}}}&uid={{{$v->id}}}'">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <form method="POST" action="/admin/roles/detail/user/add">
                <div class="form-group">
                    <div class="col-md-10">
                        <select class="form-control" name="uid">
                            <option value="" selected="">选择要添加的用户</option>
                            @foreach($users as $lu)
                                <option value="{{{$lu->id}}}">{{{$lu->username}}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{{csrf_field()}}}
                    <input type="hidden" name="rid" value="{{{$role->id}}}">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary m-r-5">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if(count($errors) > 0)
    <script>
        alert('操作失败，请重试')
    </script>
    @endif
@endsection