<ul class="profile-intro">
	<li><label>分公司:</label><?php echo htmlentities($devObj->city,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>分局:</label><?php echo htmlentities($devObj->county,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>机房名称:</label><?php echo htmlentities($devObj->room_name,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>机房位置:</label><?php echo htmlentities($devObj->room_location,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>设备名字:</label><?php echo htmlentities($devObj->dev_name,ENT_COMPAT,"UTF-8");?>
    </li>
    <?php if($model == 'imem_12'){?>
	<li><label>监控点:</label><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?> 
    </li>
	<li><label>电表IP:</label><?php echo htmlentities($devObj->device_ip,ENT_COMPAT,"UTF-8");?>
    </li>
    <?php }else{?>
    <li><label>采集板位置:</label><?php echo htmlentities($devObj->smd_device_name,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>采集板IP:</label><?php echo htmlentities($devObj->smd_device_ip,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>物理端口号:</label>
	<?php
        if (in_array($devObj->model, array('water','smoke')))
            echo '开关量DI-' . htmlentities($devObj->port,ENT_COMPAT,"UTF-8");
        else 
            if (in_array($devObj->model, array('temperature','humid')))
                echo '模拟量AD-' . htmlentities($devObj->port,ENT_COMPAT,"UTF-8");
            else
                echo '串口UART-' . htmlentities($devObj->port,ENT_COMPAT,"UTF-8");
        ?>
    </li>
	<li><label>逻辑端口号:</label><?php echo htmlentities($devObj->extra_para,ENT_COMPAT,"UTF-8"); ?>
    </li>
    <?php }?>
     <li><label>生产厂家:</label><?php echo htmlentities($devObj->manufacturer,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>出厂日期:</label><?php echo htmlentities($devObj->production_date,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>设备型号:</label><?php echo htmlentities($devObj->device_model,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>额定功率:</label><?php echo htmlentities($devObj->rated_power,ENT_COMPAT,"UTF-8");?>
    </li>
	<li><label>配电设备:</label>
	   <?php if (strlen($devObj->distribution_equipment) > 0) { $dEqObj = json_decode($devObj->distribution_equipment); ?>
	    <a href='<?php echo site_url('/attachments/' . htmlentities($dEqObj->file_name,ENT_COMPAT,"UTF-8"))?>'
		target="_blank"><?php echo htmlentities($dEqObj->orig_name,ENT_COMPAT,"UTF-8");?></a>
	    <?php }?>
    </li>
	<li><label>备注:</label><?php echo htmlentities($devObj->memo,ENT_COMPAT,"UTF-8");?>
    </li>
</ul>
