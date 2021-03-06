<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * Class IndexController
 * @package Admin\Controller
 */
class FormController extends CommonController {
    public function lst(){
        $model = D('Form');
        $data = $model->lst();
        $this->data = $data;


        $this->display();
    }
    public function add() {
        if(IS_POST) {

            $share_ico = I('share_ico');
            $share_url = I('share_url');
            $share_title = I('share_title');
            $table_name = I('table_name');

            if(empty($share_ico)) $this->ajax(300,'分享ico不能为空');
            if(empty($share_url)) $this->ajax(300,'分享地址不能为空');
            if(empty($share_title)) $this->ajax(300,'分享标题不能为空');
            if(empty($table_name)) $this->ajax(300,'表单名不能为空');


            $type = array(
                'autocomplete'=>'varchar(200)',
                'date' => 'timestamp',
                'rich-text' => 'text',
                'text' => 'varchar(200)'
            );

            $xml = $_POST['form-builder-template'];
            $arr = simplest_xml_to_array($xml);
            $arr = $arr['fields']['field'];

            $noPreTable = Pinyin($_POST['table_name']);
            $noPreTable = empty($noPreTable) ? $_POST['table_name'] : Pinyin($_POST['table_name']);

            $tableName = C('DB_PREFIX') . 'form_' . $noPreTable;



            $sql = "create table " . $tableName . "( id int(10) unsigned NOT NULL primary key AUTO_INCREMENT COMMENT '自增id',";
            $sql .= "uid int(10) unsigned ,";
            $sql .= "latitude varchar(100) NOT NULL DEFAULT '' ,";
            $sql .= "longitude varchar(100) NOT NULL DEFAULT '' ,";


            /*if(empty($_POST['table_name'])) {
                $this->ajax(300, '表单名称不能为空', 'Admin_Form_lst', 'closeCurrent');
            }*/

            if(count($arr) < 1) {
                $this->ajax(300, '至少选择一个表单组件');
            }

            /*if(count($arr) == 1) {
                $temp_arr[] = $arr;
                $arr = $temp_arr;
            }*/

            if($arr['@attributes'] && $arr['option'] && count($arr)==2) {
                $temp_arr[] = $arr;
                $arr = $temp_arr;
            }


            foreach($arr as $k=>$v) {

                if($v['@attributes']['type'] == 'checkbox' ) continue;


                $v['@attributes']['name'] = str_replace('-','',$v['@attributes']['name']);

                if(isset($v['option'])) {
                    $comment = '';

                    $options = "";

                    $label = "{$v['@attributes']['label']}";
                    $options .= "{";
                    foreach($v['option'] as $k1=>$v1) {
                        $options .= "\"{$k1}\"" . ":" . "\"{$v1}\",";
                    }
                    $options = rtrim($options,',');
                    $options .= "}";

                    if($v['@attributes']['type'] == 'checkbox-group') {
                        $comment = "{\"label\":\"{$label}\",\"type\":\"checkbox\",\"option\":{$options}}";
                    } elseif($v['@attributes']['type'] == 'radio-group'){
                        $comment = "{\"label\":\"{$label}\",\"type\":\"radio\",\"option\":{$options}}";
                    }elseif($v['@attributes']['type'] == 'select') {
                        $comment = "{\"label\":\"{$label}\",\"type\":\"select\",\"option\":{$options}}";
                    }

                    if($v['@attributes']['required']){
                        $sql .= "{$v['@attributes']['name']} varchar(255) not null default '' COMMENT '{$comment}',";
                    } else {
                        $sql .= "{$v['@attributes']['name']} varchar(255) COMMENT '{$comment}',";
                    }


                } else {
                    $comment = "{\"label\":\"{$v['@attributes']['label']}\",\"type\":\"{$v['@attributes']['type']}\"}";

                    if($v['@attributes']['required']){
                        $sql .= "{$v['@attributes']['name']} {$type[$v['@attributes']['type']]} not null  COMMENT '{$comment}',";
                    } else {
                        $sql .= "{$v['@attributes']['name']} {$type[$v['@attributes']['type']]} COMMENT '{$comment}',";
                    }

                }

            }

            $sql .= "add_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,";
            $sql .= "lat_log_to_addr varchar(300) NOT NULL DEFAULT '' ,";

            $sql = rtrim($sql, ',');
            $sql .= ")";
            $sql .= "ENGINE=MyISAM  CHARSET=utf8 COMMENT='{$_POST['table_name']}'";

//            echo $sql;die;
            $table_sql = "SHOW TABLES LIKE '{$tableName}'";
            if(M()->query($table_sql)) {
                $this->ajax(300, '表单名字已经存在，请重新填写', 'Admin_Form_lst', 'closeCurrent');
            }else {
                if(M()->execute($sql) !== false) {
                    $uri = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('APP_ID')."&redirect_uri=".C('REDIRECT_URI')."/index.php/Home/Index/index/table_name/".$tableName."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
                   $data = array(
                       'table_name'=>$tableName,
                       'comment'=>$_POST['table_name'],
                       'url'=> $uri,
                       'share_title'=>I('share_title'),
                       'share_ico'=>I('share_ico'),
                       'share_url'=>I('share_url'),
                       'success_img'=>I('success_img'),
                   );
                    M('tables')->add($data);

                    $this->ajax(200, '添加成功', 'Admin_Form_lst', 'closeCurrent');
                }else{
                    $this->ajax(300, '添加失败', 'Admin_Form_lst', 'closeCurrent');
                }
            }

        }
        $this->display();
    }


    public function info() {
        $id = I('get.id',0,'intval');
        $this->data = M('Tables')->find($id);
        $this->display();
    }

    /**
     * 删除表
     */
    public function del() {
        $id = I('get.id',0,'intval');
        $tableName = I('get.table_name');
        if((M('Tables')->delete($id))) {
            $sql = "drop table {$tableName}";
            $table_sql = "SHOW TABLES LIKE '{$tableName}'";
            if(M()->query($table_sql)) {
                M()->execute($sql);
            }

            $this->ajax(200, '删除成功！', 'Admin_Form_lst');
        }else{
            $this->ajax(300, '删除失败！', 'Admin_Form_lst');
        }
    }



    /**
     * 反馈详细信息
     * @return [type] [description]
     */
    public function voteLst() {

        $start_time = I('start_time','');
        $end_time = I('end_time','');
        if(!empty($start_time) && !empty($end_time) && $end_time<$start_time) {
            $this->ajax(300,'开始时间不能小于结束时间');
        }

        $tableName = I('table_name');
        if(empty($tableName)) die('非法操作');
        $db = M();
        $noPreTable = substr($tableName, strlen(C('DB_PREFIX')));
        if(!$db->query("SHOW TABLES LIKE '{$tableName}'")) die('非法操作');

        $fields = $db->query('SHOW FULL FIELDS FROM '.$tableName);

        $th = array();
        $fie = array();

        $checkbox = array();
        $radio = array();
 
        foreach ($fields as $k => $v) {
            $fields[$k]['comment'] = json_decode($v['comment'],true);
        }

        foreach ($fields as $k => $v) {

            if($v['comment']['type'] == 'checkbox') {
                $checkbox[$v['field']] = $v['comment']['option'];
            }
            if($v['comment']['type'] == 'radio') {
                $radio[$v['field']] = $v['comment']['option'];
            }

            if($v['field'] == 'id') {
                $th[] = 'id';
                $fie[] = $v['field'];
            }elseif($v['field'] == 'uid') {
                continue;
               /* $th[] = '用户id';
                $fie[] = $v['field'];*/
            }elseif($v['field'] == 'latitude') {
                continue;
                $th[] = '经度';
                $fie[] = $v['field'];
            }elseif($v['field'] == 'longitude') {
                continue;
                /*$th[] = '纬度';
                $fie[] = $v['field'];*/
            }elseif($v['field'] == 'lat_log_to_addr'){
                $th[] = '登记表格时所在位置';
                $fie[] = $v['field'];
            }elseif($v['field'] == 'add_time'){
                $th[] = '反馈时间';
                $fie[] = $v['field'];
            }else {
                $th[] = $v['comment']['label'];
                $fie[] = $v['field'];
            }
        }


        $model = D('Form');
        $res = $model->voteLst($noPreTable);


        $this->data = $res;
        $this->fields = $fields;

        $this->fie = $fie;
        $this->th = $th;

        $this->checkbox = $checkbox;
        $this->radio = $radio;

        $this->noPreTable = $noPreTable;
        $this->tableName = $tableName;

        $this->display('voteLst');
    }

    /**
     * 删除
     * @return [type] [description]
     */
    public function delVote() {
        $id = I('get.id',0,'intval');
        $noPreTable = I('get.table_name');

        if(M($noPreTable)->delete($id)) {
         $this->ajax(200, '删除成功！');
        } else {
             $this->ajax(300, '删除失败！');
        }

    }

    /**
     * 表格统计
     */
    public function countData() {

        $tableName = I('table_name');
        $start_time = I('start_time','');
        $end_time = I('end_time','');

        if(!empty($start_time) && !empty($end_time) && $end_time<$start_time) {
            $this->ajax(300,'开始时间不能小于结束时间');
        }

        if(empty($tableName)) die('非法操作');
        $db = M();
        $noPreTable = substr($tableName, strlen(C('DB_PREFIX')));
        if(!$db->query("SHOW TABLES LIKE '{$tableName}'")) die('非法操作');

        $fields = $db->query('SHOW FULL FIELDS FROM '.$tableName);

        $th = array();
        $fie = array();

        $checkbox = array();
        $radio = array();

        foreach ($fields as $k => $v) {
            $fields[$k]['comment'] = json_decode($v['comment'],true);
        }


        foreach ($fields as $k => $v) {

            if($v['comment']['type'] == 'checkbox') {
                $checkbox[$v['field']] = $v['comment']['option'];
                $th[$v['field']] = $v['comment']['label'];
            }

            if($v['comment']['type'] == 'radio') {
                $radio[$v['field']] = $v['comment']['option'];
                $th[$v['field']] = $v['comment']['label'];
            }

            

        }



        $db = M($noPreTable);

        $arr = array();

        $tempWhere = '';
        if(!empty($start_time) && !empty($end_time)) {
            $tempWhere = "add_time >= '{$start_time}' and add_time <= '{$end_time} 23:59:59' and ";
        } else {
            if(!empty($start_time))
                $tempWhere = "add_time >= '{$start_time}' and ";
            if(!empty($end_time))
                $tempWhere = "add_time <= '{$start_time}' and ";
        }

        foreach($checkbox as $k=>$v) {
            foreach($v as $k1=>$v1) {
                $where = $tempWhere ." FIND_IN_SET('{$k1}',{$k})";
                $arr[$k][$v1] = $db->where($where)->count();
            }
        }
        $arr2 = array();
        foreach($radio as $k=>$v) {
            foreach($v as $k1=>$v1) {
//                $where = array($k=>$k1);
                $where = $tempWhere . " {$k}={$k1}";
                $arr2[$k][$v1] = $db->where($where)->count();
            }
        }

        $data = array_merge($arr2,$arr);

        foreach ($data as $k => $v) {
            $data[$k]['title'] = json_encode(array_keys($v));
            $temp = '[';
            foreach ($v as $k2 => $v2) {
                $temp .= '{value:' . $v2 . ',' . 'name:' . '"'.$k2.'"' . '},';
            }
            $temp = rtrim($temp,',');
            $temp .= ']';
            $data[$k]['data'] = $temp;
        }

        $this->startTime = $start_time;
        $this->endTime = $end_time;

        $this->tableName = $tableName;
        $this->data = $data;
        $this->title = $th;
        $this->display();

    }



    /**
     * 导出excel
     * @return [type] [description]
     *   `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
     */
    public function doExportExcel() {

        $tableName = I('table_name');
        if(empty($tableName)) die('非法操作');
        $noPreTable = substr($tableName, strlen(C('DB_PREFIX')));
        $db = M();
        if(!$db->query("SHOW TABLES LIKE '{$tableName}'")) die('非法操作');

        $fields = $db->query('SHOW FULL FIELDS FROM '.$tableName);

        $th = array();
        $fie = array();

        $checkbox = array();
        $radio = array();

        foreach ($fields as $k => $v) {
            $fields[$k]['comment'] = json_decode($v['comment'],true);
        }


        foreach ($fields as $k => $v) {

            if($v['comment']['type'] == 'checkbox') {
                $checkbox[$v['field']] = $v['comment']['option'];
            }
            if($v['comment']['type'] == 'radio') {
                $radio[$v['field']] = $v['comment']['option'];
            }

            if($v['field'] == 'id') {
                $th[] = 'id';
                $fie[] = 'a.'.$v['field'];
            }elseif($v['field'] == 'uid') {
                continue;
                $th[] = '用户id';
                $fie[] = 'a.'.$v['field'];
            }elseif($v['field'] == 'latitude') {
                $th[] = '经度';
                $fie[] = 'a.'.$v['field'];
            }elseif($v['field'] == 'longitude') {
                $th[] = '纬度';
                $fie[] = 'a.'.$v['field'];
            }elseif($v['field'] == 'add_time'){
                $th[] = '反馈时间';
                $fie[] = 'a.'.$v['field'];
            }elseif($v['field'] == 'lat_log_to_addr'){
                $th[] = '登记表格时所在位置';
                $fie[] = 'a.'.$v['field'];
            }else {
                $th[] = $v['comment']['label'];
                $fie[] = 'a.'.$v['field'];
            }
        }

        $th[] = '公司名称';
        $fie[] = 'b.company_name';


        $data = M($noPreTable)->field($fie)->alias('a')->join('LEFT JOIN wx_user b ON a.uid=b.id')->select();


        if(!empty($data)) {
            foreach($data as $k=>$v) {

                if(!empty($checkbox)) {
                    foreach($checkbox as $k1=>$v1) {
                        $temp = $v[$k1];
                        $temp = explode(',', $temp);
                        $tempCheckbox = '';
                        foreach($temp as $k3=>$v3) {
                            $tempCheckbox .= $checkbox[$k1][$v3] . ',';
                        }
                        $data[$k][$k1] = rtrim($tempCheckbox,',');
                    }
                }

                if(!empty($radio)) {
                    foreach($radio as $k4=>$v4) {
                        $temp = $v[$k4];
                        $data[$k][$k4] = $radio[$k4][$temp];
                    }
                }


            }
        }

        exportexcel($data, $th, '反馈列表');die;
    }


    /**
     * 图片上传
     */
    public function upload() {
        $config = array(
            'maxSize'    =>     10 * 1024 * 1024, // 设置附件上传大小
            'rootPath'   =>    './Upload/',
            'savePath'   =>    'ico/',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    'jpg,png,jpeg,gif,ico',
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传文件
        $infos   =   $upload->upload();
        $info = array('status' => 100, 'message' => '上传失败');
        if(!$infos) {// 上传错误提示错误信息
            $info['message'] = $upload->getError();
        }else{// 上传成功 获取上传文件信息
            $info['src'] = "/Upload/".$infos['file']['savepath'].$infos['file']['savename'];
            $info['status'] = 200;
            $info['message'] = '上传成功';
        }

        echo json_encode($info);
    }



}