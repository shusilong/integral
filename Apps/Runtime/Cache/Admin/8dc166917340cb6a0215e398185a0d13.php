<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['shopTitle']['fieldValue']); ?>后台管理中心</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
      <script src="/Public/plugins/kindeditor/kindeditor.js"></script>
      <script src="/Public/plugins/kindeditor/lang/zh-CN.js"></script>
   </head>
   <script>
   $(function () {
	   KindEditor.ready(function(K) {
			editor1 = K.create('textarea[name="articleContent"]', {
				height:'350px',
				allowFileManager : false,
				allowImageUpload : true,
				items:[
				        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
				        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
				        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
				        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
				        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
				        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image','table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
				        'anchor', 'link', 'unlink', '|', 'about'
				],
				afterBlur: function(){ this.sync(); }
			});
		});
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   edit();
			       return false;
			},onError:function(msg){
		}});
	   $("#title").formValidator({onFocus:"请输入代金券名称"}).inputValidator({min:1,max:50,onError:"请输入50字以内"});
	   $("#man").formValidator({onFocus:"请输入满减额"}).inputValidator({min:1,max:10,onError:"请输入正确的数字"});
       $("#jian").formValidator({onFocus:"请输入满减额"}).inputValidator({min:1,max:10,onError:"请输入正确的数字"});
       $("#expire").formValidator({onFocus:"请输入有效天数"}).inputValidator({min:1,max:10,onError:"请输入正确的数字"});
	   
   });
   function edit(){
	   var params = {};
	   params.id = $('#id').val();
	   params.title = $('#title').val();
	   params.isShow = $("input[name='isShow']:checked").val();
	   params.man = $('#man').val(); params.jian = $('#jian').val();
       params.expire = $('#expire').val();
	   Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
	   $.post("<?php echo U('Admin/Coupon/edit');?>",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({ content:'操作成功',timeout:1000,callback:function(){
				   location.href="<?php echo U('Admin/Coupon/index');?>";
				}});
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
		});
   }
   </script>
   <body class="wst-page">
       <form name="myform" method="post" id="myform" autocomplete="off">
        <input type='hidden' id='id' value='<?php echo ($object["id"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th width='120' align='right'>代金券名称<font color='red'>*</font>：</th>
             <td><input type='text' id='title' class="form-control wst-ipt" value='<?php echo ($object["title"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th align='right'>是否启用<font color='red'>*</font>：</th>
             <td>
             <label>
             <input type='radio' id='isShow1' name='isShow' value='1' <?php if($object['status'] ==1 ): ?>checked<?php endif; ?> />启用&nbsp;&nbsp;
             </label>
             <label>
             <input type='radio' id='isShow0' name='isShow' value='0' <?php if($object['status'] ==0 ): ?>checked<?php endif; ?> />关闭
             </label>
             </td>
           </tr>
           <tr>
             <th align='right'>满减<font color='red'>*</font>：</th>
             <td>
             满 <input type='text' id='man' value='<?php echo ($object["man"]); ?>' maxLength='6' style="width:60px;"/>
             减 <input type='text' id='jian' value='<?php echo ($object["jian"]); ?>' maxLength='6' style="width:60px;"/>
             </td>
           </tr>
            <tr>
                <th width='120' align='right'>有效天数<font color='red'>*</font>：</th>
                <td>&nbsp;&nbsp;<input type='text' id='expire' value='<?php echo ($object["expire"]); ?>' maxLength='10' style="width:60px;"/>天（用户领取后有效天数！）</td>
            </tr>
           <tr>
             <td colspan='2' style='padding-left:250px;'>
                 <button type="submit" class="btn btn-success">保&nbsp;存</button>
                 <button type="button" class="btn btn-primary" onclick='javascript:location.href="<?php echo U('Admin/Coupon/index');?>'>返&nbsp;回</button>
             </td>
           </tr>
        </table>
       </form>
   </body>
</html>