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
        $("#articleTitle").formValidator({onFocus:"请输入数字"}).inputValidator({min:1,max:3,onError:"请输入数字"});
        $("#catId").formValidator({onFocus:"请输入数字"}).inputValidator({min:1,onError: "请输入数字"});
        $("#articleKey").formValidator({onFocus:"请输入数字"}).inputValidator({min:1,max:80,onError:"请输入数字"});

    });
    function edit(){
        var params = {};
        params.isShow = $("input[name='isShow']:checked").val();
        params.yiji = $('#yiji').val();
        params.erji = $('#erji').val();
        params.sanji = $('#sanji').val();
        if(params.yiji=='' || params.erji=='' || params.sanji==''){
            Plugins.Tips({title:'信息提示',icon:'error',content:'请输入数字!',timeout:1000});
            return;
        }
        Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
        $.post("<?php echo U('Admin/Index/setSjfenxiao');?>",params,function(data,textStatus){
            var json = WST.toJson(data);
            if(json.status=='1'){
                Plugins.setWaitTipsMsg({ content:'操作成功',timeout:1000,callback:function(){
                    location.href="<?php echo U('Admin/Index/setSjfenxiao');?>";
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
    <input type='hidden' id='id' value='<?php echo ($object["articleId"]); ?>'/>
    <table class="table table-hover table-striped table-bordered wst-form">

        <tr>
            <th align='right'>是否开启分销<font color='red'>*</font>：</th>
            <td>
                <label>
                    <input type='radio' id='isOpen' name='isShow' value='1' <?php if($status['valueRange'] == 1 ): ?>checked<?php endif; ?> />开启&nbsp;&nbsp;
                </label>
                <label>
                    <input type='radio' id='isClose' name='isShow' value='0' <?php if($status['valueRange'] == 0 ): ?>checked<?php endif; ?> />关闭
                </label>
            </td>
        </tr>
        <tr>
            <th width='160' align='right'>一级分润百分比<font color='red'>*</font>：</th>
            <td><input type='text' id='yiji' class="form-control wst-ipt" value="<?php echo ($yiji['fieldValue']); ?>" maxLength='6' placeholder="如20%,则此处填写20,填写0则该级没有分润"/>（该级分润为购买者本人收益比例，实际收益为<b style="color:red;">该比例</b> x <b style="color:red;">商品分销分成百分比</b> x <b style="color:red;">商品价格</b>）</td>
        </tr>
        <tr>
            <th align='right'>二级分润百分比<font color='red'>*</font>：</th>
            <td><input type='text' id='erji' class="form-control wst-ipt" value='<?php echo ($erji['fieldValue']); ?>' maxLength='6' placeholder="如20%,则此处填写20,填写0则该级没有分润"/>（该级分润为购买者上级收益比例）</td>
        </tr>
        <tr>
            <th align='right'>三级分润百分比<font color='red'>*</font>：</th>
            <td><input type='text' id='sanji' class="form-control wst-ipt" value='<?php echo ($sanji['fieldValue']); ?>' maxLength='6' placeholder="如20%,则此处填写20,填写0则该级没有分润"/>（该级分润为购买者上上级收益比例）</td>
        </tr>

        <tr>
            <td colspan='2' style='padding-left:250px;'>
                <button type="submit" class="btn btn-success">保&nbsp;存</button>
                <button type="reset" class="btn btn-primary">重&nbsp;置</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>