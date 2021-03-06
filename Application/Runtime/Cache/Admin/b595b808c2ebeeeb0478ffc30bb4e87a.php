<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>超级后台</title>

<link href="/Public/Admin/jui/themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="/Public/Admin/jui/themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="/Public/Admin/jui/themes/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link href="/Public/Admin/jui/uploadify/css/uploadify.css" rel="stylesheet" type="text/css" media="screen"/>
<!--[if IE]>
<link href="/Public/Admin/jui/themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
<![endif]-->

<!--[if lt IE 9]><script src="/Public/Admin/jui/js/speedup.js" type="text/javascript"></script><script src="/Public/Admin/jui/js/jquery-1.11.3.min.js" type="text/javascript"></script><![endif]-->
<!--[if gte IE 9]><!--><script src="/Public/Admin/jui/js/jquery-2.1.4.min.js" type="text/javascript"></script><!--<![endif]-->

<script src="/Public/Admin/jui/js/jquery.cookie.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/jquery.validate.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/jquery.bgiframe.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/xheditor/xheditor-1.2.2.min.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/xheditor/xheditor_lang/zh-cn.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>

<!-- svg图表  supports Firefox 3.0+, Safari 3.0+, Chrome 5.0+, Opera 9.5+ and Internet Explorer 6.0+ -->
<!--<script type="text/javascript" src="/Public/Admin/jui/chart/raphael.js"></script>
<script type="text/javascript" src="/Public/Admin/jui/chart/g.raphael.js"></script>
<script type="text/javascript" src="/Public/Admin/jui/chart/g.bar.js"></script>
<script type="text/javascript" src="/Public/Admin/jui/chart/g.line.js"></script>
<script type="text/javascript" src="/Public/Admin/jui/chart/g.pie.js"></script>
<script type="text/javascript" src="/Public/Admin/jui/chart/g.dot.js"></script>-->

<!--<script src="/Public/Admin/jui/js/dwz.core.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.util.date.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.validate.method.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.barDrag.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.drag.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.tree.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.accordion.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.ui.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.theme.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.switchEnv.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.alertMsg.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.contextmenu.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.navTab.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.tab.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.resize.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.dialog.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.dialogDrag.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.sortDrag.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.cssTable.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.stable.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.taskBar.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.ajax.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.pagination.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.database.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.datepicker.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.effects.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.panel.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.checkbox.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.history.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.combox.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.print.js" type="text/javascript"></script>-->


<!-- 可以用dwz.min.js替换前面全部dwz.*.js (注意：替换是下面dwz.regional.zh.js还需要引入)
<script src="bin/dwz.min.js" type="text/javascript"></script>
-->
    <script src="/Public/Admin/jui/bin/dwz.min.js" type="text/javascript"></script>
<script src="/Public/Admin/jui/js/dwz.regional.zh.js" type="text/javascript"></script>

<script type="text/javascript">
$(function(){
	DWZ.init("/Public/Admin/jui/dwz.frag.xml", {
		loginUrl:"login_dialog.html", loginTitle:"登录",	// 弹出登录对话框
//		loginUrl:"login.html",	// 跳到登录页面
		statusCode:{ok:200, error:300, timeout:301}, //【可选】
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
		keys: {statusCode:"statusCode", message:"message"}, //【可选】
		ui:{hideMode:'offsets'}, //【可选】hideMode:navTab组件切换的隐藏方式，支持的值有’display’，’offsets’负数偏移位置的值，默认值为’display’
		debug:false,	// 调试模式 【true|false】
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"/Public/Admin/jui/themes"}); // themeBase 相对于index页面的主题base路径
		}
	});
});
</script>
</head>

<body scroll="no">
	<div id="layout">
		<div id="header">
			<div class="headerNav">
				<a class="logo" href="http://j-ui.com">标志</a>
				<ul class="nav">
					<li id="switchEnvBox"><a href="javascript:">（<span>北京</span>）切换城市</a>
						<ul>
							<li><a href="sidebar_1.html">北京</a></li>
							<li><a href="sidebar_2.html">上海</a></li>
							<li><a href="sidebar_2.html">南京</a></li>
							<li><a href="sidebar_2.html">深圳</a></li>
							<li><a href="sidebar_2.html">广州</a></li>
							<li><a href="sidebar_2.html">天津</a></li>
							<li><a href="sidebar_2.html">杭州</a></li>
						</ul>
					</li>
					<li><a href="https://me.alipay.com/dwzteam" target="_blank">捐赠</a></li>
					<li><a href="changepwd.html" target="dialog" width="600">设置</a></li>
					<li><a href="http://www.cnblogs.com/dwzjs" target="_blank">博客</a></li>
					<li><a href="http://weibo.com/dwzui" target="_blank">微博</a></li>
					<li><a href="login.html">退出</a></li>
				</ul>
				<ul class="themeList" id="themeList">
					<li theme="default"><div class="selected">蓝色</div></li>
					<li theme="green"><div>绿色</div></li>
					<!--<li theme="red"><div>红色</div></li>-->
					<li theme="purple"><div>紫色</div></li>
					<li theme="silver"><div>银色</div></li>
					<li theme="azure"><div>天蓝</div></li>
				</ul>
			</div>

			<!-- navMenu -->
			
		</div>

		<div id="leftside">
			<div id="sidebar_s">
				<div class="collapse">
					<div class="toggleCollapse"><div></div></div>
				</div>
			</div>
			<div id="sidebar">
				<div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>

				<div class="accordion" fillSpace="sidebar">
					<div class="accordionContent">
						<ul class="tree treeFolder">
							<li><a>常用组件</a>
								<ul>
									<li><a href="<?php echo U('Admin/Form/lst');?>" target="navTab" rel="Admin_Form_lst">表单列表</a></li>
									<li><a href="" target="navTab" rel="Admin_Search_lst">用户信息反馈</a></li>
								</ul>
							</li>


						</ul>
					</div>


				</div>
			</div>
		</div>
		<div id="container">
			<div id="navTab" class="tabsPage">
				<div class="tabsPageHeader">
					<div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
						<ul class="navTab-tab">
							<li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
						</ul>
					</div>
					<div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
					<div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
					<div class="tabsMore">more</div>
				</div>
				<ul class="tabsMoreList">
					<li><a href="javascript:;">我的主页</a></li>
				</ul>
				<div class="navTab-panel tabsPageContent layoutBox">
					<div class="page unitBox">
						<div class="accountInfo">
						</div>
						<div class="pageFormContent" layoutH="80" style="margin-right:230px">
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div id="footer">Copyright &copy; 2010 <a href="demo_page2.html" target="dialog">DWZ团队</a> 京ICP备05019125号-10</div>


</body>
</html>