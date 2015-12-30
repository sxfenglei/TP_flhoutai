<?php
/**
 * 公共基础控制器类
 * @author sxfenglei
 * @email sxfenglei@vip.qq.com
 * @github https://github.com/sxfenglei/TP_flhoutai
 */
namespace Admin\Controller;
use Think\Controller; 
class BaseController extends Controller {

	public function _initialize(){
		//验证登陆,没有登陆则跳转到登陆页面
		if(empty($_SESSION['ADMIN_UID'])){
			$this->redirect('Public/login');
		}
		//
		if(!in_array($_SESSION['ADMIN_UID'], C('ADMINISTRATOR'))){
			//权限验证
			if(!authCheck(MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME,session('ADMIN_UID'))){
				$this->error('你没有权限!');
			}
		}
		//读取网站基本配置信息
		session('WEBINFO',C('WEBINFO'));
		session('EMAIL',C('EMAIL')); 
	}
	/**
	 * 公共分页列表数据方法
	 * @param  string $model   [数据表名]
	 * @param  array  $map     [查询条件]
	 * @param  string $order   [排序字段]
	 * @param  string $pageNum [每页显示几条数据]
	 * @return res
	 */
	protected function commonList($model='',$map=array(),$order='id',$pageNum=''){
		if(empty($model)){
			return false;
		}
		if(empty($pageNum)){
			$pageNum = C('PAGE_NUM');
		}
		$p = I('p',1);
    	$model = M($model);
    	$list = $model->where($map)->order($order)->page($p.','.$pageNum)->select();

		$count = $model->where($map)->count();// 查询满足要求的总记录数
		import("@.Think.Page");
		$Page = new \Think\Page($count,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数
		//分页跳转的时候保证查询条件
		foreach($map as $key=>$val) {
		    $Page->parameter[$key] = urlencode($val);
		}
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出

		return $list;
    	// $this->assign('list',$list);
	}
	/**
	 * 公共获取单条数据方法
	 * @param  string $model [数据表名]
	 * @param  array  $map   [查询条件]
	 * @return array        [返回查询结果]
	 */
	protected function commonFind($id='',$model='',$map=array(),$field=''){
		if(empty($model)){
			return false;
		}
		$model = M($model);
		if(count($map)<1){
			$map['id'] = array('eq',$id);
		}
		if(!empty($field)){
			$res = $model->where($map)->field($field)->find();
		}else{
			$res = $model->where($map)->find();
		}
		if(false !== $res){
			return $res;
		}else{
			return false;
		}
	}
	/**
	 * 公共添加数据方法
	 * @param  string $model [数据表名]
	 * @param  array  $data  [要添加的数据]
	 * @param  bool  $isMultiterm  [是否添加多条数据]
	 * @return [bool]        [res true false]
	 */
	protected function commonAdd($model='',$data=array(),$isMultiterm=false){
		if(empty($model)){
			return false;
		}
		$model = M($model);
		if($isMultiterm){
			$res = $model->addAll($data);
		}else{
			$res = $model->add($data);
		}
		if(false !== $res){
			return $res;
		}else{
			return false;
		} 
	}
	/**
	 * 公共保存数据方法
	 * @param  string $id    [表id]
	 * @param  string $model [数据表名]
	 * @param  array  $data  [要保存的数据]
	 * @return [bool]        [res true false]
	 */
	protected function commonSave($map=array(),$model='',$data=array()){
		if(count($map)<1 || empty($model)){
			return false;
		}
		$model = D($model);
		$res = $model->where($map)->save($data);
		// die($model->getLastSql());
		if(flase !== $res){
			return $res;
		}else{
			return false;
		} 
	}
	/**
	 * 公共虚拟删除数据方法
	 * @param  string $id    [表id]
	 * @param  string $model [数据表名]
	 * @param  string $isTrue [是否真实删除]
	 * @param  string $field [虚拟删除时候的修改字段]
	 * @param  string $value [虚拟删除时候的修改字段值]
	 * @return bool        [true false]
	 */
	protected function commonDel($id='',$model='',$isTrue=false,$field='status',$value='-1'){
		if(empty($id) || empty($model)){
			return false;
		}
		$model = M($model);
		$map['id'] = array('eq',$id);
		if($isTrue){
			$res = $model->where($map)->delete();
		}else{
			$data[$field] = $value;
			$res = $model->where($map)->save($data);
		}
		if(false !== $res){
			return true;
		}else{
			return false;
		}
	} 

	/**
	 * base64图片上传单张图片
	 * @return [ajax json] [description]
	 */
    public function uploadImage(){
    	$status = I('status');
        $data = I("data");
        $path = I("path");
        if(empty($path)){
            $path=C('UPLOAD_PATH');
        }
        //如果是更改就是先删除现有的
    	if($status == 'change'){
    		$file = './'.$data; 
	        if(file_exists($file)){ 
	            @unlink($file);
	        }
    	}else{
	    	//上传
	        $data = substr(strstr($data,','),1);
	        if (!is_readable($path)){ 
	             is_file($path) or mkdir($path,0777);  
	        }
	        $fileName = time().'.png';
	        $file=$path.$fileName;
	        $base64=base64_decode($data);
	        file_put_contents($file, $base64);
	        $this->ajaxReturn(array("code"=>2000,"msg"=>"图片上传成功!",'name'=>$fileName,"data"=>'/'.$file));
    	}
    }
    /**
     * 图片单张删除
     * @return [ajax json] [description]
     */
    public function delUploadImage(){
        $file = './'.I("data"); 
        if(file_exists($file)){ 
            if (unlink($file)){
                $this->ajaxReturn(array("code"=>2000,"msg"=>"图片删除成功!",'file'=>$file));
            }else{
                $this->ajaxReturn(array("code"=>-6001,"msg"=>"图片删除失败!",'file'=>$file));
            }
        }else{
            $this->ajaxReturn(array("code"=>-6001,"msg"=>"图片不存在!",'file'=>$file));
        } 
    } 

}