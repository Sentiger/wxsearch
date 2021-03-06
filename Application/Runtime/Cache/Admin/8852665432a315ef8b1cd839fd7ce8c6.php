<?php if (!defined('THINK_PATH')) exit();?><link rel="stylesheet" type="text/css" media="screen" href="/Public/Admin/formbuilder/form-builder.css">


<form method="post" action="<?php echo U('Admin/Form/add');?>" class="pageForm " onsubmit="return validateCallback(this,dialogAjaxDone)">
    <textarea name="form-builder-template" id="form-builder-template" cols="30" rows="10"></textarea>
    <label>表单名称：</label>
    <input type="text" name="table_name">
    <div class="formBar">
        <ul>
            <li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
            <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
        </ul>
    </div>
</form>



<script src="/Public/Admin/formbuilder/jquery-ui.min.js"></script>
<script src="/Public/Admin/formbuilder/form-builder.min.js"></script>
<script src="/Public/Admin/formbuilder/form-render.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        'use strict';
        var template = document.getElementById('form-builder-template'),
                formContainer = document.getElementById('rendered-form'),
                renderBtn = document.getElementById('render-form-button');
        $(template).formBuilder();

        $(renderBtn).click(function() {
            $(template).formRender({
                container: $(formContainer)
            });
        });
    });
</script>

<script>
    $(function(){
        $('#frmb-0-save').remove();
        $('#frmb-0-export-xml').remove();
//        $('#frmb-0').css({'overflow':'scroll'})
    })
</script>