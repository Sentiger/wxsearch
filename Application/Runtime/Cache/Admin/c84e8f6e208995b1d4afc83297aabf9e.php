<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="<?php echo U('Admin/Form/lst');?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="<?php echo $data['perpage'];?>" />
    <input type="hidden" name="orderField" value="<?php echo $data['orderField'];?>" />
    <input type="hidden" name="orderDirection" value="<?php echo $data['orderDirection'];?>" />
</form>
<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="<?php echo U('Admin/Form/lst');?>" method="post">
        <div class="searchBar">
            <ul class="searchContent">
                <li>
                    <label>表明注释：</label>
                    <input type="text" name="keywords" value="<?php echo $data['keywords'];?>"/>
                </li>
            </ul>

            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" href="<?php echo U('Admin/Form/add');?>" target="dialog" mask="true" width="1000" height="600"><span>添加</span></a></li>
            <li class="line">line</li>
        </ul>
    </div>
    <table class="table" width="100%" layoutH="138">
        <thead>
        <tr>
            <th>id</th>
            <th>表明</th>
            <th>说明</th>
            <th width="70">操作</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($data['data'] as $v): ?>
        <tr target="sid" rel="<?php echo $v['id'];?>">

            <td><?php echo $v['id']; ?></td>
            <td><?php echo $v['table_name']; ?></td>
            <td><?php echo $v['comment']; ?></td>

            <td>
                <a title="你确定要删除吗？" target="ajaxTodo" href="<?php echo U('Admin/Form/del',array('id'=>$v['id'],'table_name'=>$v['table_name']));?>" class="btnDel">删除</a>
                <a title="详细信息" target="dialog" href="<?php echo U('Admin/Form/info',array('id'=>$v['id']));?>" mask="true" class="btnEdit">详细信息</a>
            </td>
        </tr>
        <?php endforeach;?>


        </tbody>
    </table>
    <div class="panelBar">
        <div class="pages">
            <span>显示</span>
            <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                <option  value="20">20</option>
                <option <?php if($data['perpage'] == 30):?>selected="selected"<?php endif;?> value="30">30</option>
                <option <?php if($data['perpage'] == 40):?>selected="selected"<?php endif;?> value="40">40</option>
                <option <?php if($data['perpage'] == 50):?>selected="selected"<?php endif;?> value="50">50</option>
            </select>
            <span>共<?php echo $data['total']; ?>条</span>
        </div>

        <div class="pagination" targetType="navTab" totalCount="<?php echo $data['total']; ?>" numPerPage="<?php echo $data['perpage'];?>" pageNumShown="10" currentPage="<?php echo $data['currentPage']; ?>"></div>

    </div>
</div>