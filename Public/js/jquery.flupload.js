/**
 * $.flUpload.init();
 * $.flUpload.upload('fl');
 * @author sxfenglei
 * @github 
 * 用法：
 * HTML:
 * <div class="col-sm-6 flupload"></div>
 * 
 * CSS:
 * flupload.css
 * 
 * JS:
 * jquery.flupload.js
 *
 * //添加
 * $.flUpload.init({
 * 	'element':'.flupload',
 * 	'addUrl':"{:U('Base/uploadImage')}",
 * 	'delUrl':"{:U('Base/delUploadImage')}",
 * }); 
 * //修改
 * $.flUpload.init({
 * 	'element':'.flupload',
 * 	'addUrl':"{:U('Base/uploadImage')}",
 * 	'delUrl':"{:U('Base/delUploadImage')}",
 * 	'dataPr':"/flhoutai",
 * 	'data':"{$res.img_url}",
 * });
 *
 * PHP:
 * //base64图片上传单张图片
 * public function uploadImage(){
 * 	$status = I('status');
 *     $data = I("data");
 *     $path = I("path");
 *     if(empty($path)){
 *         $path=C('UPLOAD_PATH');
 *     }
 *     //如果是更改就是先删除现有的
 * 	if($status == 'change'){
 * 		$file = './'.$data; 
 *      if(file_exists($file)){ 
 *          @unlink($file);
 *      }
 * 	}else{
 *  	//上传
 *      $data = substr(strstr($data,','),1);
 *      if (!is_readable($path)){ 
 *           is_file($path) or mkdir($path,0777);  
 *      }
 *      $fileName = time().'.png';
 *      $file=$path.$fileName;
 *      $base64=base64_decode($data);
 *      file_put_contents($file, $base64);
 *      $this->ajaxReturn(array("code"=>2000,"msg"=>"图片上传成功!",'name'=>$fileName,"data"=>'/'.$file));
 * 	}
 * }
 * //图片单张删除 
 * public function delUploadImage(){
 *     $file = './'.I("data"); 
 *     if(file_exists($file)){ 
 *         if (unlink($file)){
 *             $this->ajaxReturn(array("code"=>2000,"msg"=>"图片删除成功!",'file'=>$file));
 *         }else{
 *             $this->ajaxReturn(array("code"=>-6001,"msg"=>"图片删除失败!",'file'=>$file));
 *         }
 *     }else{
 *         $this->ajaxReturn(array("code"=>-6001,"msg"=>"图片不存在!",'file'=>$file));
 *     } 
 * } 
 */
jQuery.flUpload = {
	init:function(param){
		var html = '';
		if(typeof(param.data) != "undefined" && param.data != 'http://placehold.it/140x140'){
			html += '<img src="'+param.dataPr+param.data+'" class="img-thumbnail headImg-show">';
		}else{
			html += '<img src="http://placehold.it/140x140" class="img-thumbnail headImg-show">';
		}

		html += '<input type="file" style="display:none" class="form-control" id="headUrl">';
		html += '<div style="margin-top:0.5rem;">';
		html += '<span class="btn btn-default headImg-add">上传</span>&nbsp;';

		if(typeof(param.data) != "undefined" && param.data != 'http://placehold.it/140x140'){
			html += '<span class="btn btn-default headImg-change" value="'+param.dataPr+param.data+'">更换</span>&nbsp;';
			html += '<span class="btn btn-danger headImg-del" value="'+param.dataPr+param.data+'">删除</span>';
		}else{
			html += '<span class="btn btn-default headImg-change">更换</span>&nbsp;';
			html += '<span class="btn btn-danger headImg-del">删除</span>';
		}

		html += '</div>';

		if(typeof(param.data) != "undefined" && param.data != 'http://placehold.it/140x140'){
			html += '<input type="hidden" id="headImg" name="headImg" value="'+param.data+'">';
		}else{
			html += '<input type="hidden" id="headImg" name="headImg" >';
		}
		
		$(param.element).html(html);
		this.add(param);
		this.change(param);
		this.del(param);
		if(typeof(param.data) != "undefined" && param.data != 'http://placehold.it/140x140'){
			$('.headImg-add').hide();
			$('.headImg-change').show();
			$('.headImg-del').show();
		}
	},
	add:function(param){
		//美化input file控件
		$('.headImg-add').on('click',function(){
			$('#headUrl').trigger('click');//触发input file的点击事件
		});
		$('.headImg-del').on('click',function(){
			if($('.headImg-show').attr('src') != 'http://placehold.it/140x140'){
				$('.headImg-del').show();
			}
		});
		//给input file控件绑定事件
		$('#headUrl').on('change',function(){
			var file = $('#headUrl').prop('files');//获取input file的图片文件 
			//图片文件类型判断
			if(!/image\/\w+/.test(file[0].type)){ 
				alert("仅支持图片文件"); 
				return false; 
			} 
			//base64
			if(0 == file.length){
				alert('选择一张图片');
				return false;
			}else{
				if (typeof FileReader == "undefined") {
				    alert('您的浏览器不支持啊');
				}
				var reader = new FileReader(); //实例化一个FileReader
				reader.readAsDataURL(file[0]); //读取base64
				// reader.readAsText(file[0],"UTF-8"); //读取文本文件
				reader.onload = function(event){
					var fileStr = event.target.result;
					//
					var postData = {
						'data':fileStr,
						// 'path':'/Public/headImg/'
					}
					$.post(param.addUrl,postData,function(data){
						console.log(data);
						if(data.code == 2000){
							$('.headImg-add').hide();
							$('.headImg-change').show();
							$('.headImg-del').show();
							$('.headImg-show').attr('src','/flhoutai'+data.data);
							$('#headImg').val(data.data);
							$('.headImg-change').attr('data-imgname',data.data);
							$('.headImg-del').attr('data-imgname',data.data);
						}else{
							alert(data.msg);
						}
						// console.log(fileStr);
					}); 
				}
			}
		});
	},
	change:function(param){
		//更换
		$('.headImg-change').on('click',function(){
			var postData = {
				'data':$(this).data('imgname'),
				'status':'change',
			} 
			$('#headUrl').trigger('click');//触发input file的点击事件
			$.post(param.addUrl,postData,function(data){
				console.log(data);
			});
		});
	},
	del:function(param){
		//删除
		$('.headImg-del').on('click',function(){
			var postData = {
				'data':$(this).data('imgname'),
			} 
			$.post(param.delUrl,postData,function(data){
				if(data.code == 2000){
					$('.headImg-show').attr('src','http://placehold.it/140x140');
					$('.headImg-add').show();
					$('.headImg-change').attr('data-imgname','').hide();
					$('.headImg-del').attr('data-imgname','').hide();
					$('#headImg').val('');
				}else{
					alert(data.msg);
				}
			});
		});
	}
}