<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 首页
 */
class IndexController extends CommonController {
    public function index(){

        p($_SERVER);die;
        if(!is_weixin()) die('请在微信中打开');
        $code = I('code');
        $tableName = I('table_name');   
        
        if(empty($tableName)) die('非法操作！');

        $tableInfo = M('tables')->where(array('table_name'=>$tableName))->find();

        $fields = M()->query('SHOW FULL FIELDS FROM '.$tableName);
        foreach ($fields as $k => $v) {
            $fields[$k]['comment'] = json_decode($v['comment'],true);
        }
        // p($fields);die;
        $res = $this->getCodeAccessToken($code);
        $userInfo = $this->getUserInfo($res);
        $info = M('user')->where(array('openid'=>$userInfo['openid'],'table_name'=>$tableName))->find();


        //获取jssdk信息
        $this->signPackage = $this->getSignPackage();


        $this->code = $code;
        $this->info = $info;
        $this->userInfo = $userInfo;
        $this->fields = $fields;
        $this->tableName = $tableName;
        $this->table = $tableInfo;

        $this->display();
    }

    /**
     * 添加反馈信息
     */
    public function addInfo() {
        $data = I('post.');
        $tableName = substr($data['table_name'],3);

        if(!empty($data)) {
            foreach($data as $k=>$v) {
                if(is_array($v)) {
                    $data[$k] = implode(',', $v);
                    // $data[$k] = $data[$k] . '|,|';
                }
            }
        }
        if(empty($data['uid'])) {
            $uid = M('user')->add($data);
        } else {
            $uid = $data['uid'];
        }
        $data['uid'] = $uid;

        $lat = I('latitude');
        $log = I('longitude');

        if(!empty($lat) && !empty($log)) {
            $res = $this->latLongToAddr($lat,$log);
            if($res['status'] == 0) {
                $data['lat_log_to_addr'] = $res['result']['formatted_addresses']['recommend'];
            }
        }

        $infoid = M($tableName)->add($data);
        if($infoid && $uid)
            $data = array(
                'status' => 1,
                'msg' => '成功'
            );
        else
            $data = array(
                'status' => 0,
                'msg' => '失败'
            );
        die(json_encode($data));
    }


}