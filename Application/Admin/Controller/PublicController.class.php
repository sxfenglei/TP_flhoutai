<?php
/**
 * 公共控制器类
 * @author sxfenglei
 * @email sxfenglei@vip.qq.com
 * @github https://github.com/sxfenglei/TP_flhoutai
 */
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
    public function login(){
        $this->display();
    }
    //登录页面
	public function index(){
		$this->display();
	}

	//验证码
	public function verify(){
		$verify=new \Think\Verify();
		$verify->entry();
	}

	//登录验证
	public function checkLogin(){
		$map['login_name']=I("username");
		$map['login_pwd']=I("password",'','md5');
		$code=I('code');
		$verify=new \Think\Verify();
		if($verify->check($code)){
			$model=M("Admin");
			$res=$model->where($map)->find(); 
			if($res){
				session('ADMIN_UID',$res['id']);
				session('ADMIN_LOGINNAME',$res['login_name']);
				session('NICKNAME',$res['nickname']);
				$this->redirect('Index/index');
			}else{
				$this->error('账号或密码错误!',U('Public/login'));
			}
		}else{
			$this->error('验证码错误!',U('Public/login'));
		}
	}

	//退出
	public function logout(){
		unset($_SESSION['ADMIN_UID']);
		unset($_SESSION);
		$this->success('退出成功!',U('Public/login'));
	}
}