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

    public function addUser()
    {
        return view('admin.user.add', [
            'act_name' => '添加用户',
            'act_desc' => '系统用户凭证',
        ]);
    }

    public function doAddUser(Request $r)
    {
        $this->validate($r, [
            'username' => 'required|unique:users',
            'password' => 'required|min:8'
        ]);
        $u = new User;
        $u->username = $r->input('username');
        $u->password = bcrypt($r->input('password'));
        if ($u->save()) {
            return redirect('/admin/users');
        } else {
            return back()->with(['alert' => 'Add User Failed']);
        }
    }

    public function delUser(Request $r)
    {
        $this->validate($r, [
            'id' => 'required|exists:users'
        ]);
        $u = User::find($r->input('id'));
        $u->roles()->detach();
        $u->delete();
        return redirect('/admin/users');
    }

    public function roles()
    {
        return view('admin.role.list', [
            'act_name' => '角色列表',
            'act_desc' => '用于授权资源的用户组',
            'list' => Role::all()
        ]);
    }

    public function addRole()
    {
        return view('admin.role.add', [
            'act_name' => '添加角色',
            'act_desc' => '系统授权对象添加',
        ]);
    }

    public function doAddRole(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|unique:roles',
        ]);
        $role = new Role;
        $role->name = $r->input('name');
        if ($role->save()) {
            return redirect('/admin/roles');
        } else {
            return back()->with(['alert' => 'Add Role Failed']);
        }
    }

    public function delRole(Request $r)
    {
        $this->validate($r, [
            'id' => 'required|exists:roles'
        ]);
        $role = Role::find($r->input('id'));
        $role->users()->detach();
        $role->delete();
        return redirect('/admin/roles');
    }

    public function detailRole(Request $r)
    {
        $role = Role::find($r->input('id'));
        if (!$role) {
            return back()->with(['alert' => 'Role Not Found!']);
        }
        $has_host = [];
        foreach ($role->acls as $ra) {
            $has_host[] = $ra->host;
        }
        return view('admin.role.detail', [
            'act_name' => '角色详情',
            'act_desc' => '>> ' . $role->name,
            'role' => $role,
            'users' => User::all()->diff($role->users),
            'hosts' => Host::all()->diff($has_host)
        ]);
    }

    public function detailRoleAddHost(Request $r)
    {
        $this->validate($r, [
            'rid' => 'required|exists:roles,id',
            'hid' => 'required|exists:hosts,id'
        ]);
        $role = Role::find($r->input('rid'));
        $role->hosts()->attach(Host::find($r->input('hid')));
        return redirect('/admin/roles/detail?id=' . $r->input('rid'));
    }

    public function detailRoleDelHost(Request $r)
    {
        $this->validate($r, [
            'rid' => 'required|exists:roles,id',
            'hid' => 'required|exists:hosts,id'
        ]);
        $role = Role::find($r->input('rid'));
        $role->hosts()->detach(Host::find($r->input('hid')));
        return redirect('/admin/roles/detail?id=' . $r->input('rid'));
    }

    public function detailRoleAddUser(Request $r)
    {
        $this->validate($r, [
            'rid' => 'required|exists:roles,id',
            'uid' => 'required|exists:users,id'
        ]);
        $role = Role::find($r->input('rid'));
        $role->users()->attach(User::find($r->input('uid')));
        return redirect('/admin/roles/detail?id=' . $r->input('rid'));
    }

    public function detailRoleDelUser(Request $r)
    {
        $this->validate($r, [
            'rid' => 'required|exists:roles,id',
            'uid' => 'required|exists:users,id'
        ]);
        $role = Role::find($r->input('rid'));
        $role->users()->detach(User::find($r->input('uid')));
        return redirect('/admin/roles/detail?id=' . $r->input('rid'));
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
        //网关配置
        $config = [
            'config_token_expire' => cache('config_token_expire', 600),
            'config_token_mode' => cache('config_token_mode', 1),
            'config_token_url' => Redis::get('config_token_url')
        ];

        //网关代理列表
        $hosts = Host::all();
        foreach ($hosts as $h) {
            $config['host_' . $h->url] = $h->proxy;
        }

        //用户权限列表
        $users = User::all();
        foreach ($users as $user) {
            $acl_hosts[$user->id] = [];
            if ($user->roles()->where('role_id', 1)->first()) {
                foreach (Host::all() as $h) {
                    $config['acl_' . $user->id . '_' . $h->url] = 1;
                }
            } else {
                foreach ($user->roles as $ur) {
                    foreach ($ur->hosts as $h) {
                        $config['acl_' . $user->id . '_' . $h->url] = 1;
                    }
                }
            }
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
