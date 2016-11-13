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

    public function addHost()
    {
        return view('admin.host.add', [
            'act_name' => '添加主机',
            'act_desc' => '添加需要代理的Web服务'
        ]);
    }

    public function doAddHost(Request $r)
    {
        $this->validate($r, [
            'name' => 'required',
            'url' => 'required|unique:hosts',
            'proxy' => 'required',
        ]);
        $h = new Host;
        $h->name = $r->input('name');
        $h->url = $r->input('url');
        $h->proxy = $r->input('proxy');
        $h->status = 1;
        if ($h->save()) {
            return redirect('/admin/hosts');
        } else {
            return redirect()->back()->with(['alert' => 'Save Faild']);
        }
    }

    public function delHost(Request $r)
    {
        $this->validate($r, [
            'id' => 'required|exists:hosts,id'
        ]);
        $h = Host::find($r->input('id'));
        $h->acls()->delete();
        $h->delete();
        return redirect('/admin/hosts');
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
