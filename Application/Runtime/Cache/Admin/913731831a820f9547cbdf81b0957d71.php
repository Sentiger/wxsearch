<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">

	<form method="post" action="" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone)">

		<div class="pageFormContent" layoutH="58">

			<div class="unit">
				<label>表名：</label>
				<input type="text"  value="<?php echo $data['table_name'];?>" readonly="readonly" size="40">
			</div>
            <div class="unit">
                <label>表注释：</label>
                <input type="text"  value="<?php echo $data['comment'];?>" readonly="readonly" size="40">
            </div>
            <div class="unit">
                <label>微信调查url：</label>
                <textarea style="width: 270px;height: 150px;">
                    <?php echo $data['url'];?>
                </textarea>
            </div>

		

		</div>
		

	</form>

</div>