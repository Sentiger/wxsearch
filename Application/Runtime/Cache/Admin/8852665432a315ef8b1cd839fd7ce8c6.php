<?php if (!defined('THINK_PATH')) exit();?><link rel="stylesheet" type="text/css" media="screen" href="/Public/Admin/formbuilder/form-builder.css">


<form action="demo.php" method="post">
    <textarea name="form-builder-template" id="form-builder-template" cols="30" rows="10"></textarea>
    <input type="submit" value="submit">
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