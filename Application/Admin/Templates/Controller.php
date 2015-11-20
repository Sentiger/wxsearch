namespace <?php echo $moduleName; ?>\Controller;
use Admin\Controller\CommonController;
/**
 * 2014-12-14
 * @author Sentiger
 *
 */
Class <?php echo $mvcName ?>Controller extends CommonController{
	/**
	 * 列表
	 */
	Public function lst() {
		$model = D('<?php echo $mvcName ?>');
		$data = $model->lst();
		$this->data = $data;
		$this->display();
	}
	/**
	 * 添加
	 */
	Public function add() {
		if(IS_POST) {
			$model = D('<?php echo $mvcName ?>');
			if($model->create()){
				if($model->add()){
					$this->ajax(200, '添加成功', '<?php echo $moduleName; ?>_<?php echo $mvcName; ?>_lst', 'closeCurrent');
				}else{
					$this->ajax(300, '添加失败');
				}
			}else{
				$this->ajax(300, $model->getError());
			}
		}
		$this->display();
	}
	
	/**
	 * 修改视图
	 */
	Public function edit() {
		$id = I('get.id',0,'intval');
		$model = D('<?php echo $mvcName ?>');
		if(IS_POST) {
			if($model->create()){
				if($model->save() !== FALSE){
					$this->ajax('200', '修改成功！', '<?php echo $moduleName ?>_<?php echo $mvcName ?>_lst', 'closeCurrent');
				}else{
					$this->ajax('300', '修改失败！');
				}
			}else{
				$this->ajax('300', $model->getError());
			}
		}
		$this->data = $model->find($id);
		$this->display();
	}
	/**
	 * 删除
	 */
	Public function del() {
		$id = I('get.id',0,'intval');
		if(D('<?php echo $mvcName ?>')->delete($id)) {
			$this->ajax(200, '删除成功！', '<?php echo $moduleName ?>_<?php echo $mvcName ?>_lst');
		}else{
			$this->ajax(300, '删除失败！', '<?php echo $moduleName ?>_<?php echo $mvcName ?>_lst');
		}
	}
	/**
	 * 批量删除
	 */
	Public function bdel() {
		$delid = I('post.ids');
		if($delid){
			// delete方法要求必须是一个字符串，所以要先转化成一个字符串
			$delid = implode(',', $delid); // 2,3,4
			// 生成模型从数据库中删除掉
			if(D('<?php echo $mvcName ?>')->delete($delid))
				$this->ajax(200, '删除成功！', '<?php echo $moduleName ?>_<?php echo $mvcName ?>_lst');
			else 
				$this->ajax(300, '删除失败！', '<?php echo $moduleName ?>_<?php echo $mvcName ?>_lst');
		}
	}
}