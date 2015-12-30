<?php
/**
 * 系统配置控制器类
 * @author sxfenglei
 * @email sxfenglei@vip.qq.com
 * @github https://github.com/sxfenglei/TP_flhoutai
 */
namespace Admin\Controller;
use Think\Controller; 
class SystemController extends BaseController {
	
	//系统基本配置
    public function setbaseinfo(){
        $this->display();
    }
    //写文件
    public function setbaseinfoUpdate(){
        // $_SESSION['WEBINFO'] = C('WEBINFO');
        // if(empty($_SESSION['WEBINFO']) || count($_SESSION['WEBINFO'])<1){
            $_SESSION['WEBINFO'] = $_POST;
            $str = '<?php $webinfo = array(';
            foreach ($_SESSION['WEBINFO'] as $key => $value) {
                $str .= "'".$key."'=>'".trim($value)."',";
            }
            $str .= '); ?>';
            if(file_put_contents(CONF_PATH.'webinfo.php', $str)){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            }
        // }
    }
    //系统邮件配置
    public function setemail(){ 
        $this->display();
    }
    //写文件
    public function setemailUpdate(){
        $_SESSION['EMAIL'] = $_POST;
        $str = '<?php $email = array(';
        foreach ($_SESSION['EMAIL'] as $key => $value) {
            $str .= "'".$key."'=>'".trim($value)."',";
        }
        $str .= '); ?>';
        if(file_put_contents(CONF_PATH.'email.php', $str)){
            $this->success('保存成功');
        }else{
            $this->error('保存失败');
        }
    }
    
}