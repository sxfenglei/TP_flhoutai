<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="renderer" content="webkit">  
	  	<meta content="sxfenglei" name="author" />
		<meta name="keywords" content="<?php echo ($_SESSION['WEBINFO']['keyword']); ?>" />
		<meta name="description" content="<?php echo ($_SESSION['WEBINFO']['desc']); ?>" />
  		<link rel="shortcut icon" href="/TP_flhoutai/Public/img/logo16X16.ico" />	
		<link rel="stylesheet" href="/TP_flhoutai/Plugin/bootstrap3/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/TP_flhoutai/Plugin/bootstrap3/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" href="/TP_flhoutai/Plugin/bootstrap3/css/font-awesome.min.css" />
		<!--[if IE 7]>
		<link rel="stylesheet" href="/TP_flhoutai/Plugin/bootstrap3/css/font-awesome-ie7.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/TP_flhoutai/Public/css/default.css" />
		<link rel="stylesheet" href="/TP_flhoutai/Public/css/flupload.css" />
		
		<title><?php echo ($_SESSION['WEBINFO']['title']); ?></title>
	</head>
<body>
<!--  顶端菜单 --> 

	<!-- topnav导航条开始 -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">	
	<div class="container">
		<div class="collapse navbar-collapse">
		    <ul class="nav navbar-nav">
		      <li class="active"><a href="<?php echo U('Index/index');?>"><i class="glyphicon glyphicon-home"></i> 主界面 </a></li>
		      <li><a href="#"><i class="glyphicon glyphicon-trash"></i> 清理缓存</a></li>
		    </ul>

		    <ul class="nav navbar-nav navbar-right">
		   		<li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#"><i class="glyphicon glyphicon-user"></i> <?php echo (session('NICKNAME')); ?> <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" tabindex="-1"><i class="glyphicon glyphicon-cog"></i>	设置</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo U('Public/logout');?>" tabindex="-1"><i class="glyphicon glyphicon-off"></i>	退出</a>
                        </li>
                    </ul>
                </li>
		    </ul>
			</div><!-- /.navbar-collapse -->
	</div>
</nav><!-- topnav导航条结束 -->

 

<!-- 正文 -->
<div class="container-fluid">
	<div class="row">
		<!-- 菜单侧栏 -->
		<div class="col-sm-2 menu">	
			
	<div class="accordion">

<!-- 默认显示 -->
<div class="accordion-group">
 <!--  <div class="accordion-heading btn btn-info">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
      <i class="icon-group"></i> 系统用户管理 </i>
    </a>
  </div> -->
    <div id="collapseZoom" class="accordion-body collapse in">
    <div class="accordion-inner" style="text-align:center">
      <a href="<?php echo U('Index/index');?>"><i class="glyphicon glyphicon-home"></i> 首页</a>
    </div>
  </div>
</div><!-- end 默认显示 -->

<!-- 权限管理菜单 -->
<?php if(authCheck('Admin/Auth/classifyList,Admin/Auth/classifyAdd,Admin/Auth/classifyEdit,Admin/Auth/classifyDel,Admin/Auth/ruleUser,Admin/Auth/ruleAllot,Admin/Auth/ruleList,Admin/Auth/ruleAdd,Admin/Auth/ruleEdit,Admin/Auth/ruleDel,Admin/Auth/accessList,Admin/Auth/accessAdd,Admin/Auth/accessEdit,Admin/Auth/accessDel',session('ADMIN_UID'))): ?><div class="accordion-group">
    <div class="accordion-heading btn btn-info">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">
        <i class="glyphicon glyphicon-lock"></i><span>权限管理</span></i>
      </a>
    </div>

    <?php if($_GET['tag']== auth): ?><div id="collapseOne" class="accordion-body collapse in">
    <?php else: ?>
      <div id="collapseOne" class="accordion-body collapse"><?php endif; ?>
      <?php if(authCheck('Admin/Auth/classifyList,Admin/Auth/classifyAdd,Admin/Auth/classifyEdit,Admin/Auth/classifyDel',session('ADMIN_UID'))): ?><div class="accordion-inner">
        <a href="<?php echo U('Auth/classifyList',array('tag'=>'auth'));?>"><i class="glyphicon glyphicon-th-large"></i> 权限类别管理</a>
      </div><?php endif; ?>
      <?php if(authCheck('Admin/Auth/accessList,Admin/Auth/accessAdd,Admin/Auth/accessEdit,Admin/Auth/accessDel',session('ADMIN_UID'))): ?><div class="accordion-inner">
        <a href="<?php echo U('Auth/accessList',array('tag'=>'auth'));?>"><i class="glyphicon glyphicon-tasks"></i> 权限列表</a>
      </div><?php endif; ?>
   <!--    <?php if(authCheck('Admin/Auth/accessAdd',session('ADMIN_UID'))): ?><div class="accordion-inner">
        <a href="<?php echo U('Auth/accessAdd',array('tag'=>'auth'));?>"><i class="glyphicon glyphicon-user"></i> 新增权限</a>
      </div><?php endif; ?> -->
      <?php if(authCheck('Admin/Auth/ruleUser,Admin/Auth/ruleAllot,Admin/Auth/ruleList,Admin/Auth/ruleAdd,Admin/Auth/ruleEdit,Admin/Auth/ruleDel',session('ADMIN_UID'))): ?><div class="accordion-inner">
        <a href="<?php echo U('Auth/ruleList',array('tag'=>'auth'));?>"><i class="glyphicon glyphicon-user"></i> 角色列表</a>
      </div><?php endif; ?>
  <!--     <?php if(authCheck('Admin/Auth/ruleAdd',session('ADMIN_UID'))): ?><div class="accordion-inner">
        <a href="<?php echo U('Auth/ruleAdd',array('tag'=>'auth'));?>"><i class="glyphicon glyphicon-user"></i> 创建角色</a>
      </div><?php endif; ?> -->
    </div>
  </div><!-- end accordion-group --><?php endif; ?><!-- end 权限管理菜单 -->

<!-- 系统用户管理菜单 -->
<?php if(authCheck('Admin/Admin/adminList,Admin/Admin/adminAdd,Admin/Admin/adminEdit,Admin/Admin/adminDel',session('ADMIN_UID'))): ?><div class="accordion-group">
    <div class="accordion-heading btn btn-info">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
        <i class="icon-group"></i><span>系统用户管理</span></i>
      </a>
    </div>
    <?php if($_GET['tag']== admin): ?><div id="collapseTwo" class="accordion-body collapse in">
    <?php else: ?>
      <div id="collapseTwo" class="accordion-body collapse"><?php endif; ?> 
    <?php if(authCheck('Admin/Admin/adminList',session('ADMIN_UID'))): ?><div class="accordion-inner">
        <a href="<?php echo U('Admin/adminList',array('tag'=>'admin'));?>"><i class="icon-group"></i> 系统用户列表</a>
      </div><?php endif; ?>
      <?php if(authCheck('Admin/Admin/adminAdd',session('ADMIN_UID'))): ?><div class="accordion-inner">
        <a href="<?php echo U('Admin/adminAdd',array('tag'=>'admin'));?>"><i class="icon-user"></i> 创建新用户</a>
      </div><?php endif; ?>
    </div>
  </div><!-- end accordion-group --><?php endif; ?><!-- end 系统用户管理菜单 -->

<!-- 系统设置 -->
<?php if(authCheck('Admin/System/setbaseinfo,Admin/System/setbaseinfoUpdate,Admin/System/setemail,Admin/System/setemailUpdate',session('ADMIN_UID'))): ?><div class="accordion-group">
    <div class="accordion-heading btn btn-info">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThr">
        <i class="icon-cog"></i><span>系统配置</span></i>
      </a>
    </div>
    <?php if($_GET['tag']== system): ?><div id="collapseThr" class="accordion-body collapse in">
    <?php else: ?>
      <div id="collapseThr" class="accordion-body collapse"><?php endif; ?> 
    <?php if(authCheck('Admin/System/setbaseinfo',session('ADMIN_UID'))): ?><div class="accordion-inner">
        <a href="<?php echo U('Admin/System/setbaseinfo',array('tag'=>'system'));?>"><i class="icon-laptop"></i> 基本设置</a>
      </div><?php endif; ?>
      <?php if(authCheck('Admin/System/setemail',session('ADMIN_UID'))): ?><div class="accordion-inner">
        <a href="<?php echo U('Admin/System/setemail',array('tag'=>'system'));?>"><i class="icon-envelope-alt"></i> 邮件设置</a>
      </div><?php endif; ?>
    </div>
  </div><!-- end accordion-group --><?php endif; ?><!-- end 系统设置 -->

</div><!-- end accordion -->
		
		</div>	

		<!-- 内容区 -->
		<div class="col-sm-10 content">
			
<div class="rightBox"> 
	<ol class="breadcrumb">
		<li><i class="glyphicon glyphicon-home"></i> <a href="#">主页面</a></li>
		<li><a href="#">角色管理</a></li>
		<li class="active">角色列表</li>
	</ol>

	<div class="panel panel-default">
	  <div class="panel-heading"> <i class="glyphicon glyphicon-tasks"></i> 角色列表 </div>
	  <div class="panel-body">
		
		<?php if(authCheck('Admin/Auth/ruleAdd',session('ADMIN_UID'))): ?><div class="panel-btn-box">
			<button type="button" data-id="" data-url="<?php echo U('Auth/ruleAdd');?>" class="btn btn-primary btn-sm btnEdit"> <i class="glyphicon glyphicon-plus"></i> 新增 </button>	
		</div><?php endif; ?>

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>编号</th>
					<th>角色</th> 
					<th>拥有权限</th>
					<th>角色描述</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td>&nbsp;<?php echo ($vo["id"]); ?></td>
					<td>&nbsp;<?php echo ($vo["title"]); ?></td>
					<td>&nbsp;<?php echo ($vo["rules_str"]); ?></td>
					<td>&nbsp;<?php echo ($vo["desc"]); ?></td>
					<td>&nbsp;
						<?php if($vo["status"] == 1): ?><span class="label label-success"> <i class="glyphicon glyphicon-ok"></i> </span>
						<?php else: ?>
							<span class="label label-warning"> <i class="glyphicon glyphicon-warning-sign"></i> </span><?php endif; ?>
					</td>
					<td class="btnTd" style="width:18rem">
						<div class="btn-group" role="group">
							<?php if(authCheck('Admin/Auth/ruleAllot',session('ADMIN_UID'))): ?><button type="button" data-id="<?php echo ($vo["id"]); ?>" data-url="<?php echo U('Auth/ruleAllot',array('id'=>$vo['id'],'tag'=>'auth'));?>" class="btn btn-primary btn-xs btnEdit">分配权限</button><?php endif; ?>
							<?php if(authCheck('Admin/Auth/ruleEdit',session('ADMIN_UID'))): ?><button type="button" data-id="<?php echo ($vo["id"]); ?>" data-url="<?php echo U('Auth/ruleEdit',array('id'=>$vo['id'],'tag'=>'auth'));?>" class="btn btn-info btn-xs btnEdit">修改</button><?php endif; ?>
							<?php if(authCheck('Admin/Auth/ruleUser',session('ADMIN_UID'))): ?><button type="button" data-id="<?php echo ($vo["id"]); ?>" data-url="<?php echo U('Auth/ruleUser',array('id'=>$vo['id'],'tag'=>'auth'));?>" class="btn btn-success btn-xs btnEdit">角色用户</button><?php endif; ?>
							<?php if(authCheck('Admin/Auth/ruleDel',session('ADMIN_UID'))): ?><button type="button" data-id="<?php echo ($vo["id"]); ?>" data-url="<?php echo U('Auth/ruleDel',array('id'=>$vo['id'],'tag'=>'auth'));?>" class="btn btn-danger btn-xs btnDel">删除</button><?php endif; ?>
						</div>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?> 
			</tbody>
		</table>
		 
		<nav>
			<ul class="pagination"><?php echo ($page); ?></ul>
		</nav>	    
	  </div><!-- panel-body -->
	</div><!-- end panel -->
	
</div><!-- end roghtBox -->
	
		</div>
	</div>

	<!-- 末尾 --> 
	<div class="row"> 
		
			<p class="footer"><?php echo ($_SESSION['WEBINFO']['footerinfo']); ?></p>
		
	</div>
</div>
 
<!-- 脚本 -->
<script src="/TP_flhoutai/Public/js/jquery1.min.js"></script>
<script src="/TP_flhoutai/Plugin/bootstrap3/js/bootstrap.min.js"></script>
<script src="/TP_flhoutai/Plugin/bootstrap3/js/Chart.min.js"></script>

<script>
$(function(){
	//菜单
	$('.accordion-heading').on('click',function(){
		console.log($(this).attr('class'));
	});
	//编辑
	$('.btnEdit').on('click',function(){
		window.location.href = $(this).data('url');
	});
	//删除
	$('.btnDel').on('click',function(){
		if(!confirm('你确定要删除吗?')){
			return false;
		}
		var url = $(this).data('url');
		var postData = {
			'id':$(this).data('id')
		}
		$.post(url,postData,function(data){
			if(data.code == 2000){
				window.location.reload();
			}else{
				alert(data.msg);
			}
		});
	});
});
</script>

</body>
</html>