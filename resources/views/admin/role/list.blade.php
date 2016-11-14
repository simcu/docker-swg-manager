@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="table-basic-5">
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>角色名称</th>
                    <th>访问权限</th>
                    <th>用户列表</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->name}}}</td>
                        <td>
                            @if($v->id == 1)
                                拥有所有权限
                            @else
                                @forelse($v->acls as $acl)
                                    {{$acl->host->name}}
                                    @if(!$loop->last)
                                        ,
                                    @endif
                                @empty
                                    -
                                @endforelse
                            @endif
                        </td>
                        <td>
                            @forelse($v->users as $user)
                                {{$user->username}}
                                @if(!$loop->last)
                                    ,
                                @endif
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>{{{$v->created_at}}}</td>
                        <td>
                            [<a href="/admin/roles/detail?id={{{$v->id}}}">详情</a>]
                            @unless($v->id == 1)
                                [<a href="javascript:if(confirm('确实要删除吗?'))location='/admin/roles/del?id={{{$v->id}}}'">删除</a>]
                            @endunless
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection