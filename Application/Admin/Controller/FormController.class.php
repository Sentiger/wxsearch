<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * Class IndexController
 * @package Admin\Controller
 */
class FormController extends CommonController {
    public function lst(){
        $sql = "SHOW TABLES LIKE '".C('DB_PREFIX') . 'form_%'."'";
        $tables = M()->query($sql);
        $tableArr = array();
        if(!empty($tables)){
            foreach($tables as $k=>$v) {
                $tableArr[] = array_keys($v);
            }
        }


        p($tableArr);die;
        $this->display();
    }
    public function add() {
        if(IS_POST) {



            $type = array(
                'autocomplete'=>'varchar(200)',
                'date' => 'timestamp',
                'rich-text' => 'text',
                'text' => 'varchar(200)'
            );

            $xml = $_POST['form-builder-template'];
            $arr = simplest_xml_to_array($xml);
            $arr = $arr['fields']['field'];

            $tableName = C('DB_PREFIX') . 'form_' . Pinyin($_POST['table_name']);
            $sql = "create table " . $tableName . "( id int(10) unsigned NOT NULL primary key AUTO_INCREMENT COMMENT '自增id',";


            if(count($arr) < 1) {
                $this->ajax(300, '至少选择一个表单组件', 'Admin_Form_lst', 'closeCurrent');
            }

            if(count($arr) == 1) {
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
                    $options .= "array(";
                    foreach($v['option'] as $k1=>$v1) {
                        $options .= "\"{$k1}\"" . "=>" . "\"{$v1}\",";
                    }
                    $options .= ")";

                    if($v['@attributes']['type'] == 'checkbox-group') {
                        $comment = "array(\"label\"=>\"{$label}\",\"type\"=>\"checkbox\",\"option\"=>{$options})";
                    } elseif($v['@attributes']['type'] == 'radio-group'){
                        $comment = "array(\"label\"=>\"{$label}\",\"type\"=>\"radio\",\"option\"=>{$options})";
                    }elseif($v['@attributes']['type'] == 'select') {
                        $comment = "array(\"label\"=>\"{$label}\",\"type\"=>\"select\",\"option\"=>{$options})";
                    }

                    if($v['@attributes']['required']){
                        $sql .= "{$v['@attributes']['name']} varchar(255) not null default '' COMMENT '{$comment}',";
                    } else {
                        $sql .= "{$v['@attributes']['name']} varchar(255) COMMENT '{$comment}',";
                    }


                } else {
                    $comment = "array(\"label\"=>\"{$v['@attributes']['label']}\",\"type\"=>{$v['@attributes']['type']})";

                    if($v['@attributes']['required']){
                        $sql .= "{$v['@attributes']['name']} {$type[$v['@attributes']['type']]} not null  COMMENT '{$comment}',";
                    } else {
                        $sql .= "{$v['@attributes']['name']} {$type[$v['@attributes']['type']]} COMMENT '{$comment}',";
                    }

                }

            }
            $sql = rtrim($sql, ',');
            $sql .= ")";
            $sql .= "ENGINE=MyISAM  CHARSET=utf8 COMMENT='{$_POST['table_name']}'";
            $table_sql = "SHOW TABLES LIKE '{$tableName}'";
            if(M()->query($table_sql)) {
                $this->ajax(300, '表单名字已经存在，请重新填写', 'Admin_Form_lst', 'closeCurrent');
            }else {
                if(M()->execute($sql) !== false) {
                    $this->ajax(200, '添加成功', 'Admin_Form_lst', 'closeCurrent');
                }else{
                    $this->ajax(300, '添加失败', 'Admin_Form_lst', 'closeCurrent');
                }
            }



        }
        $this->display();
    }



    /**
     * 代码生成器
     * 控制器的名字：就是表名
     * 生成规则：sh_goods=>GoodsController.class.php
     * 		  sh_goods_admin=>GoodsAdminController.class.php
     *
     * mvcName为类名
     * moduleName为模块名
     */
    Public function index() {
        if (IS_POST) {
            $tableName = I('post.table_name');
            $moduleName = I('post.module_name');
            if($tableName && $moduleName) {
                $moduleName = ucfirst($moduleName);
                //要生成的Controller目录
                $controllerDir = './Application/' . $moduleName . '/Controller/';
                //要生成的Model目录
                $modelDir = './Application/' . $moduleName . '/Model/';
                //生成视图View目录
                $viewDir = './Application/' . $moduleName . '/View/';
                //要生成的Conf目录
                $confDir = './Application/' . $moduleName . '/Conf/';
                //生成目录
                if(!is_dir($controllerDir))
                    @mkdir($controllerDir, 0755, TRUE);
                if(!is_dir($modelDir))
                    @mkdir($modelDir, 0755, TRUE);
                if(!is_dir($viewfDir))
                    @mkdir($viewDir, 0755, TRUE);
                if(!is_dir($confDir))
                    @mkdir($confDir, 0755, TRUE);
                $mvcName = $this->_tableNameToMVCName($tableName);
                //开启缓存区，读取内容
                /*=================生成控制器==============*/
                ob_start();
                include './Application/Gii/Templates/Controller.php';
                $str = ob_get_clean();
                if(!file_exists($controllerDir.$mvcName.'Controller.class.php'))
                    file_put_contents($controllerDir.$mvcName.'Controller.class.php', "<?php\r\n".$str);
                /*==================生成模型===============*/
                $db = M();
                //获取表中的所有字段
                $fields = $db->query('SHOW FULL FIELDS FROM '.$tableName);
                ob_start();
                include './Application/Gii/Templates/Model.php';
                $str = ob_get_clean();
                $trueTableName = str_replace(C('DB_PREFIX'), '', I('post.table_name'));
                if(!file_exists($modelDir.$mvcName.'Model.class.php'))
                    file_put_contents($modelDir.$mvcName.'Model.class.php', "<?php\r\n".$str);

                /*=================生成三个静态页面============*/
                if(!is_dir($viewDir.$mvcName))
                    @mkdir($viewDir.$mvcName, 0755, TRUE);
                //1、生成表单添加页面 add.html
                ob_start();
                include('./Application/Gii/Templates/add.html');
                $str = ob_get_clean();
                if(!file_exists($viewDir.$mvcName.'/add.html'))
                    file_put_contents($viewDir.$mvcName.'/add.html', $str);
                //2、生成表单修改页面edit.html
                ob_start();
                include('./Application/Gii/Templates/edit.html');
                $str = ob_get_clean();
                if(!file_exists($viewDir.$mvcName.'/edit.html'))
                    file_put_contents($viewDir.$mvcName.'/edit.html', $str);
                //2、生成列表页面lst.html
                ob_start();
                include('./Application/Gii/Templates/lst.html');
                $str = ob_get_clean();
                if(!file_exists($viewDir.$mvcName.'/lst.html'))
                    file_put_contents($viewDir.$mvcName.'/lst.html', $str);
                $this->ajax(200, '自动生成成功！','','closeCurrent');
            }
        }
        $this->display();
    }
    /**
     * 将表名转换成mvc名字
     * @param string $tableName
     */
    Protected function _tableNameToMVCName($tableName) {
        //去掉表的前缀
        $tableName = str_replace(C('DB_PREFIX'), '', $tableName);
        //去掉表中的下划线
        $tableName = explode('_', $tableName);
        //将以下划线切割的首写字母大写
        $tableName = array_map('ucfirst', $tableName);
        //返回重新组合的mvc名
        return implode('', $tableName);
    }


}