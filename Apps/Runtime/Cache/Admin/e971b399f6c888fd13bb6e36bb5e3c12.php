<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['mallTitle']); ?>后台管理中心</title>
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
   </head>
   <script>
   function toggleIsShow(t,v){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/Coupon/editiIsShow');?>",{id:v,isShow:t},function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
				    location.reload();
				}});
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
	   });
   }
   function del(id){
	   Plugins.confirm({title:'信息提示',content:'您确定要删除该文章吗?',okText:'确定',cancelText:'取消',okFun:function(){
		   Plugins.closeWindow();
		   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
		   $.post("<?php echo U('Admin/Coupon/del');?>",{id:id},function(data,textStatus){
					var json = WST.toJson(data);
					if(json.status=='1'){
						Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
						location.reload();
						}});
					}else{
						Plugins.closeWindow();
						Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
					}
				});
	   }});
   }
   </script>
   <body class='wst-page'>
       <form method='post' action='<?php echo U("Admin/Coupon/index");?>'>
       <div class='wst-tbar' style='height:25px;'>
                    代金券名称：<input type='text' id='titkey' name='titkey' class='form-control wst-ipt-15' value='<?php echo ($titkey); ?>'/>
       <button type="submit" class="btn btn-primary glyphicon glyphicon-search">查询</button>             
       <?php if(in_array('coupon_01',$WST_STAFF['grant'])){ ?>
       <a class="btn btn-success glyphicon glyphicon-plus" href="<?php echo U('Admin/Coupon/toEdit');?>" style='float:right'>新增</a>
       <?php } ?>
       </div>
       </form>
       <div class="wst-body"> 
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='40'>序号</th>
               <th>名称</th>
               <th>满减</th>
               <th>注册后有效使用时间</th>
               <th width='' style="cursor: pointer;" title="每次只能启用一张，若启用多张则用户注册时获得最新的一张代金券！">是否启用<img src="/Apps/Admin/View/img/notice.gif"></th>
               <th width=''>创建时间</th>
               <th width=''>操作</th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['root'])): $i = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
               <td><?php echo ($i); ?></td>
               <td><?php echo ($vo['title']); ?></td>
               <td>满 <b><?php echo ($vo['man']); ?></b> 元减 <b><?php echo ($vo['jian']); ?></b> 元</td>
               <td><?php echo ($vo['expire']); ?>天</td>
               <td>
               <div class="dropdown">
               <?php if($vo['status']==0 ): ?><button class="btn btn-danger dropdown-toggle wst-btn-dropdown"  type="button" data-toggle="dropdown">
					     关闭
					  <span class="caret"></span>
				   </button>
               <?php else: ?>
                   <button class="btn btn-success dropdown-toggle wst-btn-dropdown" type="button" data-toggle="dropdown">
					     启用
					  <span class="caret"></span>
				   </button><?php endif; ?>
               <?php if(in_array('coupon_02',$WST_STAFF['grant'])){ ?>
                   <ul class="dropdown-menu" role="menu">
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:toggleIsShow(1,<?php echo ($vo['id']); ?>)">启用</a></li>
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:toggleIsShow(0,<?php echo ($vo['id']); ?>)">关闭</a></li>
				   </ul>
			   <?php } ?>
               </div>
               </td>
               <td><?php echo ($vo['date']); ?></td>
               <td>
               <?php if(in_array('coupon_02',$WST_STAFF['grant'])){ ?>
               <a class="btn btn-default glyphicon glyphicon-pencil" href="<?php echo U('Admin/Coupon/toEdit',array('id'=>$vo['id']));?>">修改</a>&nbsp;
               <?php } ?>
               <?php if(in_array('coupon_03',$WST_STAFF['grant'])){ ?>
               <a class="btn btn-default glyphicon glyphicon-trash" href="javascript:del(<?php echo ($vo['id']); ?>)"">刪除</a>
               <?php } ?>
               </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='7' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
   </body>
</html>