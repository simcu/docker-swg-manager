<?php

namespace App\Http\Controllers;

use App\Host;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Gregwar\Captcha\CaptchaBuilder;

class AuthController extends Controller
{
    public function login(Request $r)
    {
        if (session('logined', false)) {
            return $this->redirectUrl($r);
        } else {
            return view('login');
        }
    }

    public function doLogin(Request $r)
    {
        if(Session::get('captcha') != $r->input('captcha')){
            return back()->with('msg', '验证码输入错误');
        }
        $u = User::where('username', $r->input('username'))->first();
        if ($u and Hash::check($r->input('password'), $u->password)) {
            $sess = [
                'user' => $u,
                'login_time' => time(),
                'last_url' => $r->input('ref')
            ];
            session(['logined' => $sess]);
            return $this->redirectUrl($r);
        } else {
            return back()->with('msg', '登录失败，请重试');
        }
    }

    public function logout()
    {
        Session::forget('logined');
        return redirect('/login');
    }

    public function index(Request $r)
    {
        if ($r->input('ref')) {
            Session(['logined.last_url' => $r->input('ref')]);
            $token = md5(time() . rand(1, 2832837) . $r->input('ref') . session('logined.login_time'));
            $exp = Carbon::now()->addSeconds(Cache::get('config_token_expire', 600));
            Cache::put('token_' . $token, session('logined.user.id'), $exp);
            $bkurl = $r->input('ref');
            return redirect($bkurl . ((strpos($bkurl, '?') !== false) ? '&' : '?') . 'swg_token=' . $token);
        } else {
            $list = [];
            if (session('logined.user')->roles()->where('role_id', 1)->first()) {
                foreach (Host::all() as $h) {
                    $list[$h->id] = [
                        'name' => $h->name,
                        'url' => $h->url
                    ];
                }
            } else {
                $urs = session('logined.user')->roles;
                foreach ($urs as $ur) {
                    foreach ($ur->acls as $acl) {
                        $h = $acl->host;
                        $list[$h->id] = [
                            'name' => $h->name,
                            'url' => $h->url
                        ];
                    }
                }
            }
            return view('home', ['list' => $list]);
        }
    }

    public function password()
    {
        return view('password');
    }

    public function changepass(Request $r)
    {
        $this->validate($r, [
            'oldpass' => 'required|password:' . session('logined.user')->id,
            'password' => 'required|confirmed|min:8'
        ]);
        $u = User::find(session('logined.user')->id);
        $u->password = bcrypt($r->input('password'));
        $u->save();
        return redirect('/');
    }

    private function redirectUrl($r)
    {
        if ($r->input('ref')) {
            return redirect('/?ref=' . $r->input('ref'));
        } else {
            return redirect('/');
        }
    }

    public function captcha($tmp)
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        Session::flash('captcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
}
