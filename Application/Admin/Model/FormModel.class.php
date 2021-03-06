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
            'data' => $this->field('*')->where($where)->limit($page->firstRow, $page->listRows)->order($order)->select(),
            'page' => $page->show(), // 翻页的字符串
            'currentPage' => $currentPage,
            'total' => $totalRecord,
            'perpage' => $perpage,
            'orderField' => I('post.orderField','id'),
            'orderDirection' => I('post.orderDirection','desc'),
            'keywords' => I('post.keywords',''),
        );

    }


    /**
     * 列表信息
     * @return Ambigous <\Think\mixed, string, boolean, NULL, multitype:, unknown, mixed, void, object>
     */
    Public function voteLst($tableName) {
        $model = M($tableName);
        //查询条件
        // $where = array('comment'=>array('like',"%".I('post.keywords','')."%"));
        //每页显示条数，默认20

        $where = array();

        $start_time = I('post.start_time');
        $end_time = I('post.end_time');

        if(!empty($start_time) && !empty($end_time)) {
            $where = "add_time >= '{$start_time}' and add_time <= '{$end_time} 23:59:59'";
        } else {
            if(!empty($start_time))
                $where = array('add_time'=>array('egt',$start_time));
            if(!empty($end_time))
                $where = array('add_time'=>array('elt',$end_time . ' 23:59:59'));
        }



        $perpage = I('post.numPerPage',20,'intval');
        //绑定url参数中的页数
        $_GET[C('VAR_PAGE')?C('VAR_PAGE'):'p'] = I('post.pageNum',1,'intval');
        //当前的页数
        $currentPage = $_GET[C('VAR_PAGE')?C('VAR_PAGE'):'p'];
        //总的条数
        $totalRecord = $model->where($where)->count();


        //点击表格动态排序
        $order = array('id'=>'desc');
        if(IS_POST && I('post.orderField')){
            $order = array(I('post.orderField','id')=>I('post.orderDirection','desc'));
        }

        $page = new \Think\Page($totalRecord, $perpage);
        return  array(
            'data' => $model->field('a.*,b.nickname,b.company_name,b.mobile,b.address,b.openid,b.real_name,b.job')->alias('a')->join('LEFT JOIN wx_user b ON a.uid=b.id')->where($where)->limit($page->firstRow, $page->listRows)->order($order)->select(),
            'page' => $page->show(), // 翻页的字符串
            'currentPage' => $currentPage,
            'total' => $totalRecord,
            'perpage' => $perpage,
            'orderField' => I('post.orderField','id'),
            'orderDirection' => I('post.orderDirection','desc'),
            'start_time'=>I('post.start_time'),
            'end_time'=>I('post.end_time')
        );

    }



}