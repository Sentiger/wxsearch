namespace <?php echo $moduleName ?>\Model;
use Think\Model;
/**
 * <?php echo $mvcName;?>模型，用来具体操作逻辑关系
 * @author Sentiger
 *
 */
class <?php echo $mvcName;?>Model extends Model 
{
	protected $tableName = '<?php echo $trueTableName;?>';
	// 表单验证的规则
	protected $_validate = array(
		<?php 
		//循环生成不能为空的规则
		foreach ($fields as $k => $v):
			if($v['Key'] == 'PRI')
				continue;
			if($v['Null'] == 'NO' && $v['Default'] == NULL):
		?>
		array('<?php echo $v['Field'];?>','require','<?php echo $v['Comment'];?>不能为空！',1),
		<?php endif;endforeach;
		//循环验证生成唯一的验证规则
		foreach ($fields as $k => $v):
			if($v['Key'] == 'UNI'):
		?>
		array('<?php echo $v['Field'];?>', '', '<?php echo $v['Comment'];?>已经存在！',1,'unique'),
		<?php endif;endforeach;?>
		
	);
	
	/**
	 * 列表信息
	 * @return Ambigous <\Think\mixed, string, boolean, NULL, multitype:, unknown, mixed, void, object>
	 */
	Public function lst() {
		//查询条件
		//$where = array('username'=>array('like',"%".I('post.keywords','')."%"));
		//每页显示条数，默认20
		$perpage = I('post.numPerPage',20,'intval');
		//绑定url参数中的页数
		$_GET[C('VAR_PAGE')?C('VAR_PAGE'):'p'] = I('post.pageNum',1,'intval');
		//当前的页数
		$currentPage = $_GET[C('VAR_PAGE')?C('VAR_PAGE'):'p'];
		//总的条数
		$totalRecord = $this->where($where)->count();
		//点击表格动态排序
		<?php 
			$order = "array('id'=>'desc',";
			foreach ($fields as $k => $v){
				if($v['Field']=='id') continue;
				$order .= "'".$v['Field']."'=>'asc',";
			}
			$order .= ');';
			echo '$order = ' . $order;
		?>
		
		if(IS_POST && I('post.orderField')){
			$order = array(I('post.orderField','id')=>I('post.orderDirection','desc'));
		}
		
		$page = new \Think\Page($totalRecord, $perpage);
		return  array(
			'data' => $this->where($where)->limit($page->firstRow, $page->listRows)->order($order)->select(),
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