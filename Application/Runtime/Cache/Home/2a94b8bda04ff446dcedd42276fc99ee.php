<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>标题</title>
    <link rel="stylesheet" href="/Public/Home/ui/css/frozen.css">
    <link rel="stylesheet" href="/Public/Home/ui/css/style.css">
    <script src="/Public/Home/ui/lib/zepto.min.js"></script>
    <script src="/Public/Home/ui/js/frozen.js"></script>
</head>

<body ontouchstart>
<div class="ui-loading-block show" id="onloading">
    <div class="ui-loading-cnt">
        <i class="ui-loading-bright"></i>

        <p>正在加载中...</p>
    </div>
</div>

<div id="conts" style="display: none">

    <header class="ui-header ui-header-positive ui-border-b">
        <h1>xx调查表</h1>
    </header>
    <form>
    <div class="ui-container"><!-- cont -->

        <div class="page-item">
            <p class="page-desc">基本信息</p>

            <div class="page-block">
                <div class="ui-form ui-border-t">
                    <div class="ui-form-item ui-border-b">
                        <label>
                            公司名称
                        </label>
                        <input type="text" placeholder="公司名字">
                        <a class="ui-icon-close" href="#">
                        </a>
                    </div>
                    <div class="ui-form-item ui-form-item-textarea ui-border-b">
                        <label>
                            详细地址
                        </label>
                        <textarea placeholder="街道等详细地址"></textarea>
                    </div>
                    <div class="ui-form-item ui-form-item-l ui-border-b">
                        <label class="ui-border-r">
                            中国 +86
                        </label>
                        <input type="text" placeholder="请输入手机号码">
                        <a class="ui-icon-close" href="#">
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <?php foreach($fields as $k=>$v):?>
            <?php if(empty($v['comment'])) continue;?>
            <!-- 文本框开始 -->
            <?php if($v['comment']['type']=='autocomplete' || $v['comment']['type']=='text' || $v['comment']['type']=='date') : ?>
                <div class="page-item">
                    <p class="page-desc"><?php echo $v['comment']['label'];?></p>
                    <div class="page-block">
                        <div class="ui-form ui-border-t">
                            <div class="ui-form-item ui-form-item-pure ui-border-b ">
                                <input type="text" name="<?php echo $v['field'];?>" placeholder="<?php echo $v['comment']['label'];?>">
                                <a class="ui-icon-close" href="#"></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;?>  
            <!-- 文本框结束 -->


            <!-- 文本域开始 -->
            <?php if($v['comment']['type']=='rich-text'): ?>
               <div class="page-item">
                    <p class="page-desc"><?php echo $v['comment']['label'];?></p>
                    <div class="page-block">
                        <div class="ui-form ui-border-t">
                            <div class="ui-form-item ui-form-item-pure ui-border-b ui-form-item-textarea">
                                <textarea name="<?php echo $v['field'];?>" placeholder="<?php echo $v['comment']['label'];?>"></textarea>
                                <a class="ui-icon-close" href="#"></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <!-- 文本域结束 -->
            
            <!-- 多选框开始 -->
            <?php if($v['comment']['type']=='checkbox'): ?>
                <div class="page-item">
                    <p class="page-desc"><?php echo $v['comment']['label'];?></p>

                    <div class="page-block">
                        <div class="ui-form ui-border-t">
                            <ul class="ui-list ui-list-text ui-list-checkbox ui-border-b">
                                <?php foreach($v['comment']['option'] as $k1=>$v1):?>
                                <li class="ui-border-t">
                                    <label class="ui-checkbox">
                                        <input type="checkbox" name="<?php echo $v['field'];?>[]" value="<?php echo $k1;?>">
                                    </label>
                                    <p><?php echo $v1;?></p>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif;?>  
            <!-- 多选框结束 -->

            <!-- 单选框开始 -->
            <?php if($v['comment']['type']=='radio'): ?>
                <div class="page-item">
                    <p class="page-desc"><?php echo $v['comment']['label'];?></p>

                    <div class="page-block">
                        <div class="ui-form ui-border-t">
                            <?php foreach($v['comment']['option'] as $k2=>$v2):?>
                            <div class="ui-form-item ui-form-item-radio ui-border-b">
                                <label class="ui-radio" for="radio">
                                    <input type="radio" value="<?php echo $k2;?>" name="<?php echo $v['field'];?>">
                                </label>
                                <p><?php echo $v2;?></p>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            <?php endif;?>  
            <!-- 单选框结束 -->

        <?php endforeach;?>

        

        <div class="ui-btn-wrap">
            <button class="ui-btn-lg ui-btn-primary">
                确定
            </button>
        </div>
        <div class="ui-btn-wrap">
            <button class="ui-btn-lg ui-btn-primary" disabled>
                取消
            </button>
        </div>


        <!--下面的用于提交后的提示页面-->
        <div class="ui-tips ui-tips-info">
            <i></i><span>一般提示</span>
        </div>
        <div class="ui-tips ui-tips-warn">
            <i></i><span>警告提示</span>
        </div>
        <div class="ui-tips ui-tips-success">
            <i></i><span>操作成功的提示</span>
        </div>

    </div><!-- cont end -->
    </form>
    <footer class="">

    </footer>
</div>
<script>
    function hideonload() {
        document.getElementById("conts").style.display = "block"
        document.getElementById("onloading").style.display = "none"
    }
    window.onload = function () {
        t = setTimeout("hideonload()", 1000)
    }
</script>
</body>
</html>