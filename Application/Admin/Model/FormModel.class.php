<?php
namespace Admin\Model;
use Think\Model;

class FormModel extends Model
{
    protected $tableName = 'Tables';

    /**
     * 列表信息
     * @return Ambigous <\Think\mixed, string, boolean, NULL, multitype:, unknown, mixed, void, object>
     */
    Public function lst() {
        //查询条件
        $where = array('comment'=>array('like',"%".I('post.keywords','')."%"));
        //每页显示条数，默认20
        $perpage = I('post.numPerPage',20,'intval');
        //绑定url参数中的页数
        $_GET[C('VAR_PAGE')?C('VAR_PAGE'):'p'] = I('post.pageNum',1,'intval');
        //当前的页数
        $currentPage = $_GET[C('VAR_PAGE')?C('VAR_PAGE'):'p'];
        //总的条数
        $totalRecord = $this->where($where)->count();
        //点击表格动态排序
        $order = array('id'=>'desc');
        if(IS_POST && I('post.orderField')){
            $order = array(I('post.orderField','id')=>I('post.orderDirection','desc'));
        }

        $page = new \Think\Page($totalRecord, $perpage);
        return  array(
            'data' => $this->field('a.*,b.role_name')->alias('a')->join('LEFT JOIN sh_role b ON a.role_id=b.id')->where($where)->limit($page->firstRow, $page->listRows)->order($order)->select(),
            'page' => $page->show(), // 翻页的字符串
            'currentPage' => $currentPage,
            'total' => $totalRecord,
            'perpage' => $perpage,
            'orderField' => I('post.orderField','id'),
            'orderDirection' => I('post.orderDirection','desc'),
            'keywords' => I('post.keywords',''),
        );

    }




}