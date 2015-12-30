<?php
/**
 * 系统用户管理控制器类
 * @author sxfenglei
 * @email sxfenglei@vip.qq.com
 * @github https://github.com/sxfenglei/TP_flhoutai
 */
namespace Admin\Controller;
use Think\Controller; 
class AdminController extends BaseController {
	
	//系统用户列表页
    public function adminList(){
    	$map['status'] = array('egt',0);
    	$list = $this->commonList('Admin',$map);
    	$this->assign('list',$list);
        $this->display();
    }
    //添加系统用户页
    public function adminAdd(){ 
        $map['status'] = array('eq',1);
        $auleList = $this->commonList('AuthGroup',$map);
        $this->assign('auleList',$auleList);
        $this->display();
    }
    //添加系统用户数据
    public function adminInsert(){  
        $data['login_name'] = I('name');
        $data['login_pwd'] = I('pwd','','md5');
        $data['nickname'] = I('nickname');
        $data['tel'] = I('tel');
        $data['email'] = I('email');
        $data['img_url'] = I('headImg');
        $data['status'] = I('status');
        $data['createtime'] = time();

        $map['login_name'] = $data['login_name']; 
        if(!empty($data['tel'])){
            $map['tel'] = $data['tel'];
        } 
        if(!empty($data['email'])){
            $map['email'] = $data['email'];
        } 
        $map['_logic'] = 'OR';
        // $map['name'] = array('eq',$data['login_name']);
        if($this->commonFind('','Admin',$map)){
            $this->error('您已注册过'.$map['name']);
        }

        $res = $this->commonAdd('Admin',$data);
        if(false !== $res){
            $newData['uid'] = $res['id'];
            $newData['group_id'] = I('aule');
            @$this->commonAdd('AuthGroupAccess',$newData);
            $this->success('添加成功',U('Admin/adminList',array('tag'=>'admin')));
        }else{
            $this->error('添加失败');           
        }
 
    }
    //编辑系统用户页
    public function adminEdit(){
        $id = I('id',0); 
        if($id<1){
        	$this->error('请求错误');
        }
        $res = $this->commonFind($id,'Admin');  
        $this->assign('res',$res);

        $map['status'] = array('eq',1);
        $auleList = $this->commonList('AuthGroup',$map);
        $this->assign('auleList',$auleList);
        $this->display();
    }
    //编辑系统用户数据
    public function adminUpdate(){
    	$id = I('post.id',0);
    	$name = I('post.name');
    	$pwd = I('post.pwd');
    	$nickname = I('post.nickname');
    	$tel = I('post.tel');
        $email = I('post.email');
        $headImg = I('post.headImg');

    	$status = I('post.status','999');
    	if($id<1 || empty($name)){
    		$this->error('请求错误');
    	} 
    	$map['id'] = array('eq',$id); 
    	if(!empty($name)){
    		$data['login_name'] = trim($name);
    	}
    	if(!empty($pwd)){
    		$data['login_pwd'] = md5(trim($pwd));
    	}
    	if(!empty($nickname)){
    		$data['nickname'] = $nickname;
    	}
        if(!empty($tel)){
            $data['tel'] = $tel;
        }
        if(!empty($email)){
            $data['email'] = $email;
        }
        if(!empty($headImg)){
            $data['img_url'] = $headImg;
        }
        if($status != 999){
            $data['status'] = $status;
        }
        $data['updatetime'] = time();

        $res = $this->commonSave($map,'Admin',$data);
    	if(false !== $res){
            $newMap['uid'] = array('eq',$id);
            $auleRes = $this->commonFind('','AuthGroupAccess',$newMap);
            if(false !== $auleRes){
                $newData['uid'] = $id;
                $newData['group_id'] = I('aule');
                @$this->commonSave($newMap,'AuthGroupAccess',$newData);
            }else{
                $newData['uid'] = $id;
                $newData['group_id'] = I('aule');
                @$this->commonAdd('AuthGroupAccess',$newData);
            }
    		$this->success('修改成功',U('Admin/adminList',array('tag'=>'admin')));
    	}else{
			$this->error('修改失败');    		
    	}
    }
    //删除系统用户数据
    public function adminDel(){
        $id = I('id',0);
        if($id<1){
        	$this->ajaxReturn(array('code'=>-6001,'msg'=>'请求错误'));
        }
        if(false !== $this->commonDel($id,'Admin')){
        	$this->ajaxReturn(array('code'=>2000,'msg'=>'删除成功'));
        }else{
        	$this->ajaxReturn(array('code'=>-6002,'msg'=>'删除失败'));
        }
    }

     
}