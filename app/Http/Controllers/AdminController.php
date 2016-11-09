<?php

namespace App\Http\Controllers;

use App\Acl;
use App\Host;
use App\Role;
use App\User;
use Cache;
use Redis;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function acls()
    {
        return view('admin.acl.list', [
            'act_name' => '授权列表',
            'act_desc' => '角色可以访问的资源',
            'list' => Acl::all()
        ]);
    }

    public function hosts()
    {
        return view('admin.host.list', [
            'act_name' => '主机列表',
            'act_desc' => '被代理的内网服务列表',
            'list' => Host::all()
        ]);
    }

    public function users()
    {
        return view('admin.user.list', [
            'act_name' => '用户列表',
            'act_desc' => '系统用户凭证列表',
            'list' => User::all()
        ]);
    }

    public function roles()
    {
        return view('admin.role.list', [
            'act_name' => '角色列表',
            'act_desc' => '用于授权资源的用户组',
            'list' => Role::all()
        ]);
    }

    public function config()
    {
        return view('admin.config', [
            'act_name' => '配置管理',
            'act_desc' => '网关全局配置'
        ]);
    }

    public function saveConfig(Request $r)
    {
        Redis::set('config_token_url', $r->input('config_token_url'));
        Cache::forever('config_token_expire', $r->input('config_token_expire'));
        Cache::forever('config_token_mode', $r->input('config_token_mode'));
        return redirect('/admin/config');
    }
}
