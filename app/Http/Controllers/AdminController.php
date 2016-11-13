<?php

namespace App\Http\Controllers;

use App\Acl;
use App\Host;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
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

    public function sync()
    {
        $config = [
            'config_token_expire' => cache('config_token_expire', 600),
            'config_token_mode' => cache('config_token_mode', 1),
            'config_token_url' => Redis::get('config_token_url')
        ];
        $hosts = Host::all();
        foreach ($hosts as $h) {
            $config['host_' . $h->url] = $h->proxy;
            //管理组默认有所有权限
            $config['acl_1_' . $h->url] = 1;
        }
        $acls = Acl::all();
        foreach ($acls as $acl) {
            $config['acl_' . $acl->role_id . '_' . $acl->host->url] = 1;
        }

        //开始同步规则
        Cache::flush();
        foreach ($config as $k => $v) {
            Redis::set($k, $v);
        }
        echo "同步规则完成 .... <a href='/admin'>返回</a>";
        dd($config);
    }
}
