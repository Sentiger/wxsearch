<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="table.html" method="post">
        <input type="hidden" name="pageSize" value="${model.pageSize}">
        <input type="hidden" name="pageCurrent" value="${model.pageCurrent}">
        <input type="hidden" name="orderField" value="${param.orderField}">
        <input type="hidden" name="orderDirection" value="${param.orderDirection}">
        <div class="bjui-searchBar">
            <label>所属业务:</label>
            <select name="type" data-toggle="selectpicker">
                <option value="">全部</option>
                <option value="1">联络</option>
                <option value="2">住宿</option>
                <option value="3">餐饮</option>
                <option value="4">交通</option>
            </select>&nbsp;
            <label>护照号：</label><input type="text" id="customNo" value="" name="code" class="form-control" size="10">&nbsp;
            <label>客户姓名：</label><input type="text" value="" name="name" class="form-control" size="8">&nbsp;
            <input type="checkbox" id="j_table_chk" value="true" data-toggle="icheck" data-label="我的客户">
            <button type="button" class="showMoreSearch" data-toggle="moresearch" data-name="custom"><i class="fa fa-angle-double-down"></i></button>
            <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;
            <a class="btn btn-orange" href="javascript:;" data-toggle="reloadsearch" data-clear-query="true" data-icon="undo">清空查询</a>
            <div class="pull-right">
                <button type="button" class="btn-blue" data-url="ajaxDone2.html?id={#bjui-selected}" data-toggle="doajax" data-confirm-msg="确定要删除选中项吗？" data-icon="remove" title="可以在控制台(network)查看被删除ID">删除选中行</button>&nbsp;
                <a href="<?php echo U('Admin/Form/add');?>" class="btn btn-green" data-toggle="navtab" data-id="form_add" data-reload-warn="本页已有打开的内容，确定将刷新本页内容，是否继续？" data-title="创建表单">创建表单</a>
                &nbsp;
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy">复选框-批量操作<span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a href="book1.xlsx" data-toggle="doexport" data-confirm-msg="确定要导出信息吗？">导出<span style="color: green;">全部</span></a></li>
                        <li><a href="book1.xlsx" data-toggle="doexportchecked" data-confirm-msg="确定要导出选中项吗？" data-idname="expids" data-group="ids">导出<span style="color: red;">选中</span></a></li>
                        <li class="divider"></li>
                        <li><a href="ajaxDone2.html" data-toggle="doajaxchecked" data-confirm-msg="确定要删除选中项吗？" data-idname="delids" data-group="ids">删除选中</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bjui-moreSearch">
            <label>职业：</label><input type="text" value="" name="profession" size="15" />
            <label>&nbsp;性别:</label>
            <select name="sex" data-toggle="selectpicker">
                <option value="">全部</option>
                <option value="true">男</option>
                <option value="false">女</option>
            </select>
            <label>&nbsp;手机:</label>
            <input type="text" value="" name="mobile" size="10">
        </div>
    </form>
</div>
<div class="bjui-pageContent tableContent">
    <table class="table table-bordered table-hover table-striped table-top" data-selected-multi="true">
        <thead>
            <tr>
                <th data-order-field="operation" align="center">业务</th>
                <th data-order-field="name">姓名</th>
                <th>拼音姓</th>
                <th>拼音名</th>
                <th data-order-field="sex">性别</th>
                <th data-order-field="birthday">出生日期</th>
                <th data-order-field="birthplace">出生地</th>
                <th data-order-field="add"  align="center">居住地</th>
                <th data-order-field="passportno">护照号</th>
                <th data-order-field="issuedate">签发日期</th>
                <th data-order-field="indate">有效日期</th>
                <th data-order-field="issueat">签发地</th>
                <th data-order-field="profession">职业</th>
                <th data-order-field="mobile">手机</th>
                <th data-order-direction="asc" data-order-field="createtime">登记时间</th>
                <th width="26"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
                <th width="100">操作</th>
            </tr>
        </thead>
        <tbody>
            <tr data-id="1">
                <td>联络</td>
                <td>孙悟空</td>
                <td>Sun</td>
                <td>Wukong</td>
                <td>男</td>
                <td>0100-01-01</td>
                <td>花果山</td>
                <td align="center">灵山</td>
                <td>0000011</td>
                <td>1000-05-01</td>
                <td>9999-12-31</td>
                <td>五指山</td>
                <td>保镖、斗战圣佛</td>
                <td>--</td>
                <td>2014-10-24 15:50</td>
                <td><input type="checkbox" name="ids" data-toggle="icheck" value="1"></td>
                <td>
                    <a href="form.html?id=1" class="btn btn-green" data-toggle="navtab" data-id="form" data-reload-warn="本页已有打开的内容，确定将刷新本页内容，是否继续？" data-title="编辑-孙悟空">编辑</a>
                    <a href="ajaxDone2.html" class="btn btn-red" data-toggle="doajax" data-confirm-msg="确定要删除该行信息吗？">删</a>
                </td>
            </tr>
            <tr data-id="2">
                <td>联络</td>
                <td>唐僧</td>
                <td>Tang</td>
                <td>Seng</td>
                <td>男</td>
                <td>0600-10-11</td>
                <td>洛阳</td>
                <td>灵山</td>
                <td>0000012</td>
                <td>1000-04-01</td>
                <td>9999-12-31</td>
                <td>洛阳</td>
                <td>念经</td>
                <td>--</td>
                <td>2014-10-24 15:51</td>
                <td><input type="checkbox" name="ids" data-toggle="icheck" value="2"></td>
                <td>
                    <a href="form.html?id=2" class="btn btn-green" data-toggle="navtab" data-id="form" data-reload-warn="本页已有打开的内容，确定将刷新本页内容，是否继续？" data-title="编辑-唐僧">编辑</a>
                    <a href="ajaxDone2.html" class="btn btn-red" data-toggle="doajax" data-confirm-msg="确定要删除该行信息吗？">删</a>
                </td>
            </tr>

        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">
    <div class="pages">
        <span>每页&nbsp;</span>
        <div class="selectPagesize">
            <select data-toggle="selectpicker" data-toggle-change="changepagesize">
                <option value="30">30</option>
                <option value="60">60</option>
                <option value="120">120</option>
                <option value="150">150</option>
            </select>
        </div>
        <span>&nbsp;条，共 600 条</span>
    </div>
    <div class="pagination-box" data-toggle="pagination" data-total="600" data-page-size="30" data-page-current="1">
    </div>
</div>