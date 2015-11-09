<?php if (!defined('THINK_PATH')) exit();?>
<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
<!--<link rel="stylesheet" type="text/css" media="screen" href="/Public/Admin/formbuild/demo.css">-->
<link rel="stylesheet" type="text/css" media="screen" href="/Public/Admin/formbuild/form-builder.css">

<div class="demo-wrap">
    <div id="main_content_wrap" class="outer">
        <section id="main_content" class="inner">

            <div class="build-form">
                <h2><strong>Build The Form</strong></h2>
                <form action="">
                    <textarea name="form-builder-template" id="form-builder-template" cols="30" rows="10"></textarea>
                </form>
                <br style="clear:both">
            </div>
            <br style="clear:both">
        </section>
    </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="/Public/Admin/formbuild/form-builder.min.js"></script>
<script src="/Public/Admin/formbuild/form-render.min.js"></script>
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
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-4784386-21', 'auto');
    ga('send', 'pageview');
</script>