<?php
/**
 * 权限管理控制器类
 * @author sxfenglei
 * @email sxfenglei@vip.qq.com
 * @github https://github.com/sxfenglei/TP_flhoutai
 */
namespace Admin\Controller;
use Think\Controller; 
class AuthController extends BaseController {
	//权限类别类别页
	public function classifyList(){
    	$map['status'] = array('egt',0);
    	$list = $this->commonList('AuthRuleClassify',$map);
    	$this->assign('list',$list);
		$this->display();
	}
	//权限类别添加页
	public function classifyAdd(){
		$this->display();
	}
	//权限类别添加数据
	public function classifyInsert(){
		$name = I('post.name');
    	$status = I('post.status',0);
    	if(empty($name)){
    		$this->error('权限类别名称不可为空');
    	}   
		$data['name'] = trim($name); 
		$data['status'] = $status; 

		$map['name'] = array('eq',$data['name']);
		if($this->commonFind('','AuthRuleClassify',$map)){
			$this->error('权限类别已存在');
		}

    	if(false !== $this->commonAdd('AuthRuleClassify',$data)){
    		$this->success('添加成功',U('Auth/classifyList',array('tag'=>'auth')));
    	}else{
			$this->error('添加失败');    		
    	}
	}
	//权限类别修改页
	public function classifyEdit(){
        $id = I('id',0); 
        if($id<1){
        	$this->error('请求错误');
        }
        $res = $this->commonFind($id,'AuthRuleClassify'); 
        $this->assign('res',$res);
		$this->display();
	}
	//权限类别修改数据
	public function classifyUpdate(){
		$id = I('post.id',0);
    	$name = I('post.name');
    	$status = I('post.status','999');
    	if($id<1 || empty($name)){
    		$this->error('请求错误');
    	} 
    	$map['id'] = array('eq',$id); 
    	if(!empty($name)){
    		$data['name'] = trim($name);
    	}
    	if($status != 999){
    		$data['status'] = $status;
    	}

    	if(false !== $this->commonSave($map,'AuthRuleClassify',$data)){
    		$this->success('修改成功',U('Auth/classifyList',array('tag'=>'auth')));
    	}else{
			$this->error('修改失败');    		
    	}
	}
	//权限类别删除数据
	public function classifyDel(){
        $id = I('id',0); 
        if($id<1){
        	$this->ajaxReturn(array('code'=>-6001,'msg'=>'请求错误'));
        }
        if(false !== $this->commonDel($id,'AuthRuleClassify')){
        	$this->ajaxReturn(array('code'=>2000,'msg'=>'删除成功'));
        }else{
        	$this->ajaxReturn(array('code'=>-6002,'msg'=>'删除失败'));
        }
	}

	//////////////////////////////////////
	
	//权限列表页
    public function accessList(){
    	$map['status'] = array('egt',0);
    	$list = $this->commonList('AuthRule',$map,'classify');
    	$this->assign('list',$list);
        $this->display();
    }
    //添加权限页
    public function accessAdd(){
        $classifyList = $this->commonList('AuthRuleClassify'); 
        $this->assign('classifyList',$classifyList);
        $this->display();
    }
    //添加权限数据
    public function accessInsert(){  
    	$classify = I('post.classify');
    	$name = I('post.name');
    	$condition = I('post.condition');
    	$type = I('post.type',1);
    	$status = I('post.status',0);
    	if(empty($classify)){
    		$this->error('请选择规则类别');
    	}  
    	if(empty($name)){
    		$this->error('规则不可为空');
    	}   
    	$data['classify'] = $classify;
		$data['name'] = trim($name); 
		$data['title'] = trim($condition); 
		$data['type'] = $type; 
		$data['status'] = $status; 

		$map['name'] = array('eq',$data['name']);
		if($this->commonFind('','AuthRule',$map)){
			$this->error('规则已存在');
		}

    	if(false !== $this->commonAdd('AuthRule',$data)){
    		$this->success('添加成功',U('Auth/accessList',array('tag'=>'auth')));
    	}else{
			$this->error('添加失败');    		
    	}
    }
    //编辑权限页
    public function accessEdit(){
        $id = I('id',0); 
        if($id<1){
        	$this->error('请求错误');
        }
        $res = $this->commonFind($id,'AuthRule'); 
        $classifyList = $this->commonList('AuthRuleClassify');
        $this->assign('res',$res);
        $this->assign('classifyList',$classifyList);
        $this->display();
    }
    //编辑权限数据
    public function accessUpdate(){
    	$id = I('post.id',0);
    	$name = I('post.name');
    	$classify = I('post.classify');
    	$condition = I('post.condition');
    	$type = I('post.type');
    	$status = I('post.status','999');
    	if($id<1 || empty($name) || empty($classify)){
    		$this->error('请求错误');
    	} 
    	$map['id'] = array('eq',$id); 
    	if(!empty($name)){
    		$data['name'] = trim($name);
    	}
    	if(!empty($condition)){
    		$data['title'] = trim($condition);
    	}
    	if(!empty($type)){
    		$data['type'] = $type;
    	}
    	if($status != 999){
    		$data['status'] = $status;
    	}
    	if(!empty($classify)){
    		$data['classify'] = $classify;
    	}

    	if(false !== $this->commonSave($map,'AuthRule',$data)){
    		$this->success('修改成功',U('Auth/accessList',array('tag'=>'auth')));
    	}else{
			$this->error('修改失败');    		
    	}
    }
    //删除权限数据
    public function accessDel(){
        $id = I('id',0); 
        if($id<1){
        	$this->ajaxReturn(array('code'=>-6001,'msg'=>'请求错误'));
        }
        if(false !== $this->commonDel($id,'AuthRule')){
        	$this->ajaxReturn(array('code'=>2000,'msg'=>'删除成功'));
        }else{
        	$this->ajaxReturn(array('code'=>-6002,'msg'=>'删除失败'));
        }
    }

    /////////////////////////////////////////////////
    //角色列表页
    public function ruleList(){
    	$map['status'] = array('egt',0);
    	$list = $this->commonList('AuthGroup',$map);
    	$this->assign('list',$list);
        $this->display();
    }
    //添加角色页
    public function ruleAdd(){
        $this->display();
    }//添加角色数据
    public function ruleInsert(){  
    	$title = I('post.title');
    	$desc = I('post.desc');
    	$status = I('post.status',0);
    	if(empty($title)){
    		$this->error('角色名称不可为空');
    	}   
		$data['title'] = trim($title); 
		$data['desc'] = trim($desc);
		$data['status'] = $status; 

		$map['title'] = array('eq',$data['title']);
		if($this->commonFind('','AuthGroup',$map)){
			$this->error('角色已存在');
		}

    	if(false !== $this->commonAdd('AuthGroup',$data)){
    		$this->success('添加成功',U('Auth/ruleList',array('tag'=>'auth')));
    	}else{
			$this->error('添加失败');    		
    	}
    }
    //编辑角色页
    public function ruleEdit(){
        $id = I('id',0); 
        if($id<1){
        	$this->error('请求错误');
        }
        $res = $this->commonFind($id,'AuthGroup'); 
        $this->assign('res',$res);
        $this->display();
    }
    //修改角色数据
    public function ruleUpdate(){
 		$id = I('post.id',0);
    	$title = I('post.title');
    	$desc = I('post.desc'); 
    	$status = I('post.status','999');
    	if($id<1 || empty($title)){
    		$this->error('请求错误');
    	} 
    	$map['id'] = array('eq',$id); 
    	if(!empty($title)){
    		$data['title'] = trim($title);
    	}
    	if(!empty($desc)){
    		$data['desc'] = trim($desc);
    	}
    	if($status != 999){
    		$data['status'] = $status;
    	}

    	if(false !== $this->commonSave($map,'AuthGroup',$data)){
    		$this->success('修改成功',U('Auth/ruleList',array('tag'=>'auth')));
    	}else{
			$this->error('修改失败');    		
    	}
    }
    //删除角色数据
    public function ruleDel(){
        $id = I('id',0); 
        if($id<1){
        	$this->ajaxReturn(array('code'=>-6001,'msg'=>'请求错误'));
        }
        if(false !== $this->commonDel($id,'AuthGroup')){
        	$this->ajaxReturn(array('code'=>2000,'msg'=>'删除成功'));
        }else{
        	$this->ajaxReturn(array('code'=>-6002,'msg'=>'删除失败'));
        }
    }

    /////////////////////////
    
    //角色分配权限
    public function ruleAllot(){
    	//当前角色拥有的权限
    	$id = I('id');
    	$rulesRes = $this->commonFind($id,'AuthGroup');
		$rulesArr = explode(",", $rulesRes['rules']);

    	//权限类别中文名
    	$map['status'] = array('egt',0);
    	$list = $this->commonList('AuthRule',$map,'classify',99999);
    	$classifyList = $this->commonList('AuthRuleClassify',$map);
    	foreach ($list as $key => $value) {
    		foreach ($classifyList as $k => $v) {
    			if($value['classify'] == $v['id']){
    				$list[$key]['classify_name'] = $v['name'];
    			}
    		} 
    		//标记 拥有的权限
    		if(in_array($value['id'],$rulesArr)){
    			$list[$key]['isHave'] = 1;	
    		}else{
    			$list[$key]['isHave'] = 0;
    		} 
    	} 

    	//分组
    	$newData = array();
    	$tmp = $list['0'];
    	$i = 0; 
    	foreach ($list as $key => $value) {   
			//分组
    		if($tmp['classify'] == $value['classify']){
    			$newData[$i][] = $value;
    		}else{
    			$i++;
    			$tmp = $value;
    			$newData[$i][] = $value;
    		} 
    	}
// var_dump($rulesRes);
// var_dump($newData);
        $this->assign('list',$newData);
        $this->assign('nameTitle',$rulesRes['title']);
    	$this->display();
    }
    //更新数据
    public function ruleAllotUpdate(){
    	$id = I('post.id');
    	$checkbox = I('post.checkbox',array(1));
    	if($id<1){
    		$this->error('请求错误');
    	} 
    	$map['id'] = array('eq',$id); 
    	$checkboxStr = implode(",", $checkbox);
    	$data['rules'] = rtrim($checkboxStr,","); 

    	//角色拥有的权限中文名
    	$map2['status'] = array('gt',0); 
    	$ruleAll = $this->commonList('AuthRule',$map2);
		$strTmp = '';
		foreach ($checkbox as $k => $v) {
			foreach($ruleAll as $ksub=>$vsub){
			  	if($v == $vsub['id']){
			  		$strTmp .= $vsub['title'].',';
			  	}
			}
		}  
		$data['rules_str'] = rtrim($strTmp,","); 

    	if(false !== $this->commonSave($map,'AuthGroup',$data)){
    		$this->success('修改成功',U('Auth/ruleList',array('tag'=>'auth')));
    	}else{
			$this->error('修改失败');    		
    	}
    }
}