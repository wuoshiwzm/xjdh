<ul class="profile-intro">
    <?php if(in_array($model,array('power_302a'))){?>
	<li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相功率（W）:</label><?php echo htmlentities($devObj->pa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相功率（W）:</label><?php echo htmlentities($devObj->pb,ENT_COMPAT,"UTF-8");?></li>
    <li><label>C相功率（W）:</label><?php echo htmlentities($devObj->pc,ENT_COMPAT,"UTF-8");?></li>
    <li><label>合相功率（W）:</label><?php echo htmlentities($devObj->pt,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相无功功率（W）:</label><?php echo htmlentities($devObj->qa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相无功功率（W）:</label><?php echo htmlentities($devObj->qb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相无功功率（W）:</label><?php echo htmlentities($devObj->qc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相无功功率（W）:</label><?php echo htmlentities($devObj->qt,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相视在功率（W）:</label><?php echo htmlentities($devObj->sa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相视在功率（W）:</label><?php echo htmlentities($devObj->sb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相视在功率（W）:</label><?php echo htmlentities($devObj->sc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相视在功率（W）:</label><?php echo htmlentities($devObj->st,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相有功功率（W）:</label><?php echo htmlentities($devObj->linePa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相有功功率（W）:</label><?php echo htmlentities($devObj->linePb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相有功功率（W）:</label><?php echo htmlentities($devObj->linePc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相有功功率（W）:</label><?php echo htmlentities($devObj->linePt,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相无功功率（W）:</label><?php echo htmlentities($devObj->lineQa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相无功功率（W）:</label><?php echo htmlentities($devObj->lineQb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相无功功率（W）:</label><?php echo htmlentities($devObj->lineQc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相无功功率（W）:</label><?php echo htmlentities($devObj->lineQt,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相电压有效值（V）:</label><?php echo htmlentities($devObj->uaRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相电压有效值（V）:</label><?php echo htmlentities($devObj->ubRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相电压有效值（V）:</label><?php echo htmlentities($devObj->ucRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相电压有效值（V）:</label><?php echo htmlentities($devObj->utRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相电流有效值（A）:</label><?php echo htmlentities($devObj->iaRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相电流有效值（A）:</label><?php echo htmlentities($devObj->ibRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相电流有效值（A）:</label><?php echo htmlentities($devObj->icRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相电流有效值（A）:</label><?php echo htmlentities($devObj->itRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相有功电压（V）:</label><?php echo htmlentities($devObj->luaRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相有功电压（V）:</label><?php echo htmlentities($devObj->lubRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相有功电压（V）:</label><?php echo htmlentities($devObj->lucRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相有功电流（A）:</label><?php echo htmlentities($devObj->liaRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相有功电流（A）:</label><?php echo htmlentities($devObj->libRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相有功电流（A）:</label><?php echo htmlentities($devObj->licRms,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相功率因数:</label><?php echo htmlentities($devObj->pfa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相功率因数:</label><?php echo htmlentities($devObj->pfb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相功率因数:</label><?php echo htmlentities($devObj->pfc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相功率因数:</label><?php echo htmlentities($devObj->pft,ENT_COMPAT,"UTF-8");?></li>
	<li><label>pga:</label><?php echo htmlentities($devObj->pga,ENT_COMPAT,"UTF-8");?></li>
	<li><label>pgb:</label><?php echo htmlentities($devObj->pgb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>pgc:</label><?php echo htmlentities($devObj->pgc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>yuaub:</label><?php echo htmlentities($devObj->yuaub,ENT_COMPAT,"UTF-8");?></li>
	<li><label>yuauc:</label><?php echo htmlentities($devObj->yuauc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>yubuc:</label><?php echo htmlentities($devObj->yubuc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>频率（Hz）:</label><?php echo htmlentities($devObj->freq,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相电能（kWh）:</label><?php echo htmlentities($devObj->epa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相电能（kWh）:</label><?php echo htmlentities($devObj->epb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相电能（kWh）:</label><?php echo htmlentities($devObj->epc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相电能（kWh）:</label><?php echo htmlentities($devObj->ept,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相无功电能（kWh）:</label><?php echo htmlentities($devObj->eqa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相无功电能（kWh）:</label><?php echo htmlentities($devObj->eqb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相无功电能（kWh）:</label><?php echo htmlentities($devObj->eqc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相无功电能（kWh）:</label><?php echo htmlentities($devObj->eqt,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相视在电能（kWh）:</label><?php echo htmlentities($devObj->esa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相视在电能（kWh）:</label><?php echo htmlentities($devObj->esb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相视在电能（kWh）:</label><?php echo htmlentities($devObj->esc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相视在电能（kWh）:</label><?php echo htmlentities($devObj->est,ENT_COMPAT,"UTF-8");?></li>
	<li><label>A相有功电能（kWh）:</label><?php echo htmlentities($devObj->lineEpa,ENT_COMPAT,"UTF-8");?></li>
	<li><label>B相有功电能（kWh）:</label><?php echo htmlentities($devObj->lineEpb,ENT_COMPAT,"UTF-8");?></li>
	<li><label>C相有功电能（kWh）:</label><?php echo htmlentities($devObj->lineEpc,ENT_COMPAT,"UTF-8");?></li>
	<li><label>合相有功电能（kWh）:</label><?php echo htmlentities($devObj->lineEpt,ENT_COMPAT,"UTF-8");?></li>
    <?php }?>
    
    <?php if(in_array($model,array('battery_24','battery_32','battery24_voltage'))){?>
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>蓄电池单体电压（V）:</label>
	   <?php  for($i=0;$i<count($devObj->battery_voltage);$i++){
	      	       echo number_format($devObj->battery_voltage[$i],3)." ";
	      	       if(($i+1)%5 == 0)
	      	       echo '</br>'	;
	          };
	   ?>
	</li>
	<li><label>蓄电池总电压（V）:</label><?php echo htmlentities($devObj->voltage,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电流（A）:</label><?php echo htmlentities($devObj->current,ENT_COMPAT,"UTF-8");?></li>
	<li><label>温度:</label><?php echo htmlentities($devObj->temperature,ENT_COMPAT,"UTF-8");?></li>
    <?php }?>
    
    <?php if(strpos($model,"-ac")!== false){?>   <!--  M500F/S交流屏电源      M522S交流屏电源 -->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>交流屏输出电流A（A）:</label><?php echo htmlentities($devObj->ia,ENT_COMPAT,"UTF-8");?></li>
	<li><label>交流屏输出电流B（A）:</label><?php echo htmlentities($devObj->ib,ENT_COMPAT,"UTF-8");?></li>
	<li><label>交流屏输出电流C（A）:</label><?php echo htmlentities($devObj->ic,ENT_COMPAT,"UTF-8");?></li>
	<li><label>交流输入路数:</label><?php echo htmlentities($devObj->channel_count,ENT_COMPAT,"UTF-8");?></li>
	<li><label>输出空开数量:</label><?php echo htmlentities($devObj->airlock_count,ENT_COMPAT,"UTF-8");?></li>
	<li><label>输出空开状态:</label><?php echo '('.$devObj->airlock_status['$binary'].','.$devObj->airlock_status['$type'].')';?></li>
	<li><label>p40_43_count:</label><?php echo htmlentities($devObj->p40_43_count,ENT_COMPAT,"UTF-8");?></li>
	<li><label>p40_43:</label><?php echo '('.$devObj->p40_43['$binary'].','.$devObj->p40_43['$type'].')';?></li>
	<li><label>A相输入电流告警:</label><?php echo '('.$devObj->ia_alert['$binary'].','.$devObj->ia_alert['$type'].')';?></li>
	<li><label>B相输入电流告警:</label><?php echo '('.$devObj->ib_alert['$binary'].','.$devObj->ib_alert['$type'].')';?></li>
	<li><label>C相输入电流告警:</label><?php echo '('.$devObj->ic_alert['$binary'].','.$devObj->ic_alert['$type'].')';?></li>
	<li><label>交流输入各路数据状态</label></li>
	<?php  for($i=0;$i<count($devObj->ac_channel);$i++){
		echo  '<li><label>输入线/相电压AB/A:</label>'.$devObj->ac_channel[$i]['a'].'</li>';
		echo  '<li><label>输入线/相电压BC/B:</label>'.$devObj->ac_channel[$i]['b'].'</li>';
		echo  '<li><label>输入线/相电压CA/C:</label>'.$devObj->ac_channel[$i]['c'].'</li>';
		echo  '<li><label>输入频率:</label>'.$devObj->ac_channel[$i]['f'].'</li>';
		echo  '<li><label>p40_41_count:</label>'.$devObj->ac_channel[$i]['p40_41_count'].'</li>';
		echo  '<li><label>p40_41:</label>'.'['.$devObj->ac_channel[$i]['p40_41']['$binary'].','.$devObj->ac_channel[$i]['p40_41']['$type'].']'.'</li>';		
		echo  '<li><label>输入线/相电压AB/A告警:</label>'.'('.$devObj->ac_channel[$i]['alert_a']['$binary'].','.$devObj->ac_channel[$i]['alert_a']['$type'].')'.'</li>';
		echo  '<li><label>输入线/相电压BC/B告警:</label>'.'('.$devObj->ac_channel[$i]['alert_b']['$binary'].','.$devObj->ac_channel[$i]['alert_b']['$type'].')'.'</li>';
		echo  '<li><label>输入线/相电压CA/C告警:</label>'.'('.$devObj->ac_channel[$i]['alert_c']['$binary'].','.$devObj->ac_channel[$i]['alert_c']['$type'].')'.'</li>';
		echo  '<li><label>频率告警:</label>'.'('.$devObj->ac_channel[$i]['alert_f']['$binary'].','.$devObj->ac_channel[$i]['alert_f']['$type'].')'.'</li>';
		echo  '<li><label>p40_44_count:</label>'.$devObj->ac_channel[$i]['p40_44_count'].'</li>';
		echo  '<li><label>p40_44:</label>'.'('.$devObj->ac_channel[$i]['p40_44']['$binary'].','.$devObj->ac_channel[$i]['p40_44']['$type'].')'.'</li>';
      };
     ?>
    <?php }?>
    
    <?php if(strpos($model,"-dc")!== false){?>   <!--  M500F/S直流屏电源   M522S直流流屏电源-->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>直流输出电压（V）:</label><?php echo htmlentities($devObj->v,ENT_COMPAT,"UTF-8");?></li>
	<li><label>负载总电流:</label><?php echo htmlentities($devObj->i,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电池分路电流数量:</label><?php echo htmlentities($devObj->m,ENT_COMPAT,"UTF-8");?></li>
	<li><label>dc_i:</label><?php $dc_i = "";
							     for($i=0;$i<count($devObj->dc_i);$i++){
							     	$dc_i = $dc_i.$devObj->dc_i[$i];
							     	if($i !=count($devObj->dc_i)-1)
							     		$dc_i = $dc_i.',';
							     }
							     echo '['.$dc_i.']';?></li>
	<li><label>监测直流分路电流数:</label><?php echo htmlentities($devObj->n,ENT_COMPAT,"UTF-8");?></li>
	<li><label>channelArray:</label><?php echo htmlentities($devObj->channelArray,ENT_COMPAT,"UTF-8");?></li>
	<li><label>用户自定义测量数:</label><?php echo htmlentities($devObj->p_count,ENT_COMPAT,"UTF-8");?></li>
	<li><label>p:</label><?php $p = "";
							     for($i=0;$i<count($devObj->p);$i++){
							     	$p = $p.$devObj->p[$i];
							     	if($i !=count($devObj->p)-1)
							     		$p = $p.',';
							     }
							     echo '['.$p.']';?></li>
	<li><label>直流告警电压（V）:</label><?php echo '('.$devObj->alert_v['$binary'].','.$devObj->alert_v['$type'].')';?></li>
	<li><label>alert_m_count:</label><?php echo '('.$devObj->alert_m_count['$binary'].','.$devObj->alert_m_count['$type'].')';?></li>
	<li><label>alert_m:</label><?php echo '('.$devObj->alert_m['$binary'].','.$devObj->alert_m['$type'].')';?></li>
	<li><label>alert_p_count:</label><?php echo '('.$devObj->alert_p_count['$binary'].','.$devObj->alert_p_count['$type'].')';?></li>
	<li><label>alert_p:</label><?php echo '('.$devObj->alert_p['$binary'].','.$devObj->alert_p['$type'].')';?></li>
    <?php }?>

    <?php if(strpos($model,"-rc")!== false){?>   <!--  M500F/S整流屏电源      M522S整流屏电源-->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>vu:</label><?php echo htmlentities($devObj->vu,ENT_COMPAT,"UTF-8");?></li>
	<li><label>vl:</label><?php echo htmlentities($devObj->vl,ENT_COMPAT,"UTF-8");?></li>
	<li><label>iu:</label><?php echo htmlentities($devObj->iu,ENT_COMPAT,"UTF-8");?></li>
	<li><label>fu:</label><?php echo htmlentities($devObj->fu,ENT_COMPAT,"UTF-8");?></li>
	<li><label>fl:</label><?php echo htmlentities($devObj->fl,ENT_COMPAT,"UTF-8");?></li>
	<li><label>整流输出电压最大值（V）:</label><?php echo htmlentities($devObj->out_v_high,ENT_COMPAT,"UTF-8");?></li>
	<li><label>整流输出电压最小值（V）:</label><?php echo htmlentities($devObj->out_v_low,ENT_COMPAT,"UTF-8");?></li>
	<li><label>param_num:</label><?php echo htmlentities($devObj->param_num,ENT_COMPAT,"UTF-8");?></li>
	<li><label>param:</label><?php echo '('.$devObj->param['$binary'].','.$devObj->param['$type'].')';?></li>
	<li><label>整流输出电压（V）:</label><?php echo htmlentities($devObj->out_v,ENT_COMPAT,"UTF-8");?></li>
	<li><label>整流模块数量:</label><?php echo htmlentities($devObj->channel_count,ENT_COMPAT,"UTF-8");?></li>
	<li><label>rc_channel:</label></li>
	<?php  for($i=0;$i<count($devObj->rc_channel);$i++){
		echo  '<li><label>整流模块输出电流:</label>'.$devObj->rc_channel[$i]['out_i'].'</li>';
		echo  '<li><label>p41_41_count:</label>'.$devObj->rc_channel[$i]['p41_41_count'].'</li>';
		echo  '<li><label>模块温度:</label>'.$devObj->rc_channel[$i]['p41_41']['0'].'</li>';
		echo  '<li><label>模块限流点（百分数）:</label>'.$devObj->rc_channel[$i]['p41_41']['1'].'</li>';
		echo  '<li><label>模块输出电压:</label>'.$devObj->rc_channel[$i]['p41_41']['2'].'</li>';
		echo  '<li><label>交流输入电压:</label>'.$devObj->rc_channel[$i]['p41_41']['3'].'</li>';
		echo  '<li><label>开机/关机状态:</label>'.'['.$devObj->rc_channel[$i]['shutdown']['$binary'].','.$devObj->rc_channel[$i]['shutdown']['$type'].']'.'</li>';		
		echo  '<li><label>限流/不限流状态:</label>'.'('.$devObj->rc_channel[$i]['i_limit']['$binary'].','.$devObj->rc_channel[$i]['i_limit']['$type'].')'.'</li>';
		echo  '<li><label>浮充/均充/测试状态:</label>'.'('.$devObj->rc_channel[$i]['charge']['$binary'].','.$devObj->rc_channel[$i]['charge']['$type'].')'.'</li>';
		echo  '<li><label>p41_43_count:</label>'.$devObj->rc_channel[$i]['p41_43_count'].'</li>';
		echo  '<li><label>p41_43:</label>'.'('.$devObj->rc_channel[$i]['p41_43']['$binary'].','.$devObj->rc_channel[$i]['p41_43']['$type'].')'.'</li>';
		echo  '<li><label>fault:</label>'.'('.$devObj->rc_channel[$i]['fault']['$binary'].','.$devObj->rc_channel[$i]['fault']['$type'].')'.'</li>';
		echo  '<li><label>p41_44_count:</label>'.$devObj->rc_channel[$i]['p41_44_count'].'</li>';
		echo  '<li><label>p41_44:</label>'.'('.$devObj->rc_channel[$i]['p41_44']['$binary'].','.$devObj->rc_channel[$i]['p41_44']['$type'].')'.'</li>';
      };
     ?>
    <?php }?>

    <?php if(in_array($model,array('psm-6'))){?>   <!--  华为开关电源PSM-6-->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>交流输入类型:</label><?php echo htmlentities($devObj->ac_type,ENT_COMPAT,"UTF-8");?></li>
	<li><label>输入交流高压保护值(V):</label><?php echo htmlentities($devObj->p_in_v_max_limiting,ENT_COMPAT,"UTF-8");?></li>
	<li><label>输入交流低压保护值(V):</label><?php echo htmlentities($devObj->p_in_v_min_limiting,ENT_COMPAT,"UTF-8");?></li>
	<li><label>配电输出总数:</label><?php echo htmlentities($devObj->output_count,ENT_COMPAT,"UTF-8");?></li>
	<li><label>配电输出数量:</label><?php echo htmlentities($devObj->output_num,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电源系统整流模块总数:</label><?php echo htmlentities($devObj->rc_model_count,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电源系统整流模块地址:</label><?php echo htmlentities($devObj->rc_model_addrs,ENT_COMPAT,"UTF-8");?></li>
	<li><label>auto_manual:</label><?php echo htmlentities($devObj->auto_manual,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电池总数(组):</label><?php echo htmlentities($devObj->battery_count,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电池容量(Ah):</label><?php echo htmlentities($devObj->battery_capacity,ENT_COMPAT,"UTF-8");?></li>
	<li><label>浮充电压(V):</label><?php echo htmlentities($devObj->charge_float_v,ENT_COMPAT,"UTF-8");?></li>
	<li><label>均充电压(V):</label><?php echo htmlentities($devObj->charge_average_v,ENT_COMPAT,"UTF-8");?></li>
	<li><label>均充时间间隔(天):</label><?php echo htmlentities($devObj->charge_average_timer,ENT_COMPAT,"UTF-8");?></li><!-- timer -->
	<li><label>均充定时时间(小时):</label><?php echo htmlentities($devObj->charge_average_time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>充电系数:</label><?php echo htmlentities($devObj->charge_modulus,ENT_COMPAT,"UTF-8");?></li>
	<li><label>馈线电阻(mΩ):</label><?php echo htmlentities($devObj->feeder_resistance,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电流充电限流值(A):</label><?php echo htmlentities($devObj->charge_limit_i,ENT_COMPAT,"UTF-8");?></li>
	<li><label>均浮充转换电流(A):</label><?php echo htmlentities($devObj->charge_average_trans_i,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电池欠压报警值（V）:</label><?php echo htmlentities($devObj->low_battery_alert_v,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电池欠压保护值（V）:</label><?php echo htmlentities($devObj->low_battery_protect_v,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电池欠压是否自动保护:</label><?php echo htmlentities($devObj->low_battery_autoprotect,ENT_COMPAT,"UTF-8");?></li>
	<li><label>配电监控单元地址(00-99):</label><?php echo htmlentities($devObj->dev_addr,ENT_COMPAT,"UTF-8");?></li>
	<li><label>更新时间:</label><?php echo htmlentities($devObj->update_time,ENT_COMPAT,"UTF-8");?></li>
    <?php }?>
    
    <?php if(in_array($model,array('humid','temperature','water'))){?>   <!--   -->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数值:</label><?php echo htmlentities($devObj->value,ENT_COMPAT,"UTF-8");?></li>
    <?php }?>
        
    <?php if(in_array($model,array('aeg-ms10se'))){?>   <!--  AEG低压配电柜 -->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>pt1:</label><?php echo htmlentities($devObj->pt1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>pt2:</label><?php echo htmlentities($devObj->pt2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>ct1:</label><?php echo htmlentities($devObj->ct1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>ct2:</label><?php echo htmlentities($devObj->ct2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>频率F（Hz）:</label><?php echo htmlentities($devObj->f,ENT_COMPAT,"UTF-8");?></li>
	<li><label>相电压V1（V）:</label><?php echo htmlentities($devObj->v1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>相电压V2（V）:</label><?php echo htmlentities($devObj->v2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>相电压V3（V）:</label><?php echo htmlentities($devObj->v3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>相电压均值Vvavg（V）:</label><?php echo htmlentities($devObj->vvavg,ENT_COMPAT,"UTF-8");?></li>
	<li><label>线电压V12（V）:</label><?php echo htmlentities($devObj->v12,ENT_COMPAT,"UTF-8");?></li>
	<li><label>线电压V23（V）:</label><?php echo htmlentities($devObj->v23,ENT_COMPAT,"UTF-8");?></li>
	<li><label>线电压V31（V）:</label><?php echo htmlentities($devObj->v31,ENT_COMPAT,"UTF-8");?></li>
	<li><label>线电压均值Vlavg（V）:</label><?php echo htmlentities($devObj->vlavg,ENT_COMPAT,"UTF-8");?></li>
	<li><label>相（线）电流I1（A）:</label><?php echo htmlentities($devObj->i1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>相（线）电流I2（A）:</label><?php echo htmlentities($devObj->i2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>相（线）电流I3（A）:</label><?php echo htmlentities($devObj->i3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>三相电流均值Iavg（A）:</label><?php echo htmlentities($devObj->iavg,ENT_COMPAT,"UTF-8");?></li>
	<li><label>中线电流In:</label><?php echo htmlentities($devObj->in,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相有功功率P1（W）:</label><?php echo htmlentities($devObj->p1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相有功功率P2（W）:</label><?php echo htmlentities($devObj->p2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相有功功率P3（W）:</label><?php echo htmlentities($devObj->p3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>系统有功功率Psum（W）:</label><?php echo htmlentities($devObj->psum,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相无功功率Q1（W）:</label><?php echo htmlentities($devObj->q1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相无功功率Q2（W）:</label><?php echo htmlentities($devObj->q2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相无功功率Q3（W）:</label><?php echo htmlentities($devObj->q3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>系统无功功率Qsum（W）:</label><?php echo htmlentities($devObj->qsum,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相视在功率S1（W）:</label><?php echo htmlentities($devObj->s1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相视在功率S2（W）:</label><?php echo htmlentities($devObj->s2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相视在功率S3（W）:</label><?php echo htmlentities($devObj->s3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>系统视在功率Ssum（W）:</label><?php echo htmlentities($devObj->ssum,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相功率因数PF1:</label><?php echo htmlentities($devObj->pf1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相功率因数PF2:</label><?php echo htmlentities($devObj->pf2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>分相功率因数PF3:</label><?php echo htmlentities($devObj->pf3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>系统有功功率Psum2（W）:</label><?php echo htmlentities($devObj->psum2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>系统无功功率Qsum2（W）:</label><?php echo htmlentities($devObj->qsum2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>系统视在功率Ssum2（W）:</label><?php echo htmlentities($devObj->ssum2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>有功电度 Ep_imp:</label><?php echo htmlentities($devObj->ep_imp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>感性无功电度 Eq_imp:</label><?php echo htmlentities($devObj->eq_imp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>容性无功电度 Eq_exp:</label><?php echo htmlentities($devObj->eq_exp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>总有功电度 Ep_total:</label><?php echo htmlentities($devObj->ep_total,ENT_COMPAT,"UTF-8");?></li>
	<li><label>净有功电度 Ep_net:</label><?php echo htmlentities($devObj->ep_net,ENT_COMPAT,"UTF-8");?></li>
	<li><label>总电度 Eq_total:</label><?php echo htmlentities($devObj->eq_total,ENT_COMPAT,"UTF-8");?></li>
	<li><label>净无功电度 Eq_net:</label><?php echo htmlentities($devObj->eq_net,ENT_COMPAT,"UTF-8");?></li>
	<li><label>DI数据参数:</label><?php echo htmlentities($devObj->di,ENT_COMPAT,"UTF-8");?></li>
	<li><label>DO数据参数:</label><?php echo htmlentities($devObj->d_o,ENT_COMPAT,"UTF-8");?></li>	
    <?php }?>    

    <?php if(in_array($model,array('datamate3000'))){?>   <!--  爱默生Datamate300 -->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内温度:</label><?php echo htmlentities($devObj->room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内湿度:</label><?php echo htmlentities($devObj->room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室外温度:</label><?php echo htmlentities($devObj->outdoor_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>空调开关机状态:</label><?php echo htmlentities($devObj->air_state,ENT_COMPAT,"UTF-8");?></li>
	<li><label>开机温度:</label><?php echo htmlentities($devObj->temperature,ENT_COMPAT,"UTF-8");?></li>
	<li><label>关机湿度:</label><?php echo htmlentities($devObj->humidity,ENT_COMPAT,"UTF-8");?></li>
	<li><label>温度设定点:</label><?php echo htmlentities($devObj->set_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>温度偏差:</label><?php echo htmlentities($devObj->temp_pric,ENT_COMPAT,"UTF-8");?></li>
	<li><label>湿度设定点:</label><?php echo htmlentities($devObj->set_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>湿度偏差:</label><?php echo htmlentities($devObj->humid_pric,ENT_COMPAT,"UTF-8");?></li>
	<li><label>开/关机状态:</label><?php echo htmlentities($devObj->switch_status,ENT_COMPAT,"UTF-8");?></li>
	<li><label>风机状态:</label><?php echo htmlentities($devObj->fan_status,ENT_COMPAT,"UTF-8");?></li>
	<li><label>制冷状态:</label><?php echo htmlentities($devObj->cool_status,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热状态:</label><?php echo htmlentities($devObj->heat_status,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿状态:</label><?php echo htmlentities($devObj->humid_status,ENT_COMPAT,"UTF-8");?></li>
	<li><label>除湿状态:</label><?php echo htmlentities($devObj->dehumid_status,ENT_COMPAT,"UTF-8");?></li>
	
	<li><label>告警状态:</label><?php echo htmlentities($devObj->alert_status,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高压报警:</label><?php echo htmlentities($devObj->high_press_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低压报警:</label><?php echo htmlentities($devObj->low_press_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高压温度告警:</label><?php echo htmlentities($devObj->high_temp_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低压温度告警:</label><?php echo htmlentities($devObj->low_temp_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高压湿度告警:</label><?php echo htmlentities($devObj->high_humid_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低压湿度告警:</label><?php echo htmlentities($devObj->low_humid_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电源故障报警:</label><?php echo htmlentities($devObj->power_failer_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>短周期报警:</label><?php echo htmlentities($devObj->short_cycle_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>用户自定义1报警:</label><?php echo htmlentities($devObj->custom_alarm1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>用户自定义2报警:</label><?php echo htmlentities($devObj->custom_alarm2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>主风机维护报警:</label><?php echo htmlentities($devObj->main_fan_mainten_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿器维护报警:</label><?php echo htmlentities($devObj->humid_mainten_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>过滤网维护报警:</label><?php echo htmlentities($devObj->filter_mainten_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>通讯故障报警:</label><?php echo htmlentities($devObj->com_failer_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>盘管冻结报警:</label><?php echo htmlentities($devObj->coil_freeze_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿器故障报警:</label><?php echo htmlentities($devObj->humid_fault_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>传感器板丢失报警:</label><?php echo htmlentities($devObj->sensor_miss_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>排气温度故障报警:</label><?php echo htmlentities($devObj->gas_temp_fault_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电源丢失故障报警:</label><?php echo htmlentities($devObj->power_miss_fault_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电源过欠压报警:</label><?php echo htmlentities($devObj->power_undervol_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电源缺相报警:</label><?php echo htmlentities($devObj->power_phase_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电源频率偏移报警:</label><?php echo htmlentities($devObj->power_freq_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>地板溢水报警:</label><?php echo htmlentities($devObj->floor_overflow_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>装置状态:</label><?php echo htmlentities($devObj->unit_status,ENT_COMPAT,"UTF-8");?></li>
	<li><label>unit_prop:</label><?php echo htmlentities($devObj->unit_prop,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高压锁定:</label><?php echo htmlentities($devObj->high_press_lock,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低压锁定:</label><?php echo htmlentities($devObj->low_press_lock,ENT_COMPAT,"UTF-8");?></li>
	<li><label>exhaust_lock:</label><?php echo htmlentities($devObj->exhaust_lock,ENT_COMPAT,"UTF-8");?></li>	
    <?php }?>
        
    <?php if(in_array($model,array('fresh_air'))){?>   <!-- 新风系统 -->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内温度1:</label><?php echo htmlentities($devObj->temperature1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内温度2:</label><?php echo htmlentities($devObj->temperature2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内温度3:</label><?php echo htmlentities($devObj->temperature3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内温度4:</label><?php echo htmlentities($devObj->temperature4,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内温度5:</label><?php echo htmlentities($devObj->temperature5,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内湿度1:</label><?php echo htmlentities($devObj->humidity1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内湿度2:</label><?php echo htmlentities($devObj->humidity2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内湿度3:</label><?php echo htmlentities($devObj->humidity3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内湿度4:</label><?php echo htmlentities($devObj->humidity4,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内湿度5:</label><?php echo htmlentities($devObj->humidity5,ENT_COMPAT,"UTF-8");?></li>
	<li><label>出风温度:</label><?php echo htmlentities($devObj->wind_temperature,ENT_COMPAT,"UTF-8");?></li>
	<li><label>出风湿度:</label><?php echo htmlentities($devObj->wind_humidity,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室外温度:</label><?php echo htmlentities($devObj->outside_temperature,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室外湿度:</label><?php echo htmlentities($devObj->outside_humidity,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿器电流:</label><?php echo htmlentities($devObj->humidifier_current,ENT_COMPAT,"UTF-8");?></li>
	<li><label>平均温度:</label><?php echo htmlentities($devObj->average_temperature,ENT_COMPAT,"UTF-8");?></li>
	<li><label>平均湿度:</label><?php echo htmlentities($devObj->average_humidity,ENT_COMPAT,"UTF-8");?></li>
	<li><label>reserve_60_42_1:</label><?php echo htmlentities($devObj->reserve_60_42_1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>reserve_60_42_2:</label><?php echo htmlentities($devObj->reserve_60_42_2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>最高室内温度:</label><?php echo htmlentities($devObj->highest_temperature,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_alert:</label><?php echo htmlentities($devObj->runstate_alert,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_fan:</label><?php echo htmlentities($devObj->runstate_fan,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_r1:</label><?php echo htmlentities($devObj->runstate_r1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_r2:</label><?php echo htmlentities($devObj->runstate_r2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_r3:</label><?php echo htmlentities($devObj->runstate_r3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_r4:</label><?php echo htmlentities($devObj->runstate_r4,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_drain:</label><?php echo htmlentities($devObj->runstate_drain,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_fill:</label><?php echo htmlentities($devObj->runstate_fill,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_pump:</label><?php echo htmlentities($devObj->runstate_pump,ENT_COMPAT,"UTF-8");?></li>
	<li><label>runstate_ac:</label><?php echo htmlentities($devObj->runstate_ac,ENT_COMPAT,"UTF-8");?></li>
	<li><label>告警状态:</label><?php echo htmlentities($devObj->alert,ENT_COMPAT,"UTF-8");?></li>
	<li><label>温度设定点:</label><?php echo htmlentities($devObj->setting_temperature,ENT_COMPAT,"UTF-8");?></li>
	<li><label>湿度设定点:</label><?php echo htmlentities($devObj->setting_humidity,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高温告警点:</label><?php echo htmlentities($devObj->high_temperature_alert,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低温告警点:</label><?php echo htmlentities($devObj->low_temperature_alert,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高湿报警点:</label><?php echo htmlentities($devObj->high_humidity_alert,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低湿报警点:</label><?php echo htmlentities($devObj->low_humidity_alert,ENT_COMPAT,"UTF-8");?></li>
    <?php }?>

    <?php if(in_array($model,array('liebert-ups'))){?>   <!--  力博特UPS -->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>a:</label><?php echo htmlentities($devObj->a,ENT_COMPAT,"UTF-8");?></li>
	<li><label>d1:</label><?php echo htmlentities($devObj->d1,ENT_COMPAT,"UTF-8");?></li>
    <?php }?>
        
    <?php if(in_array($model,array('ug40'))){?>   <!--  施耐德空调 -->
    <li><label>更新日期:</label><?php echo htmlentities($devObj->Date." ".$devObj->Time,ENT_COMPAT,"UTF-8");?></li>
	<li><label>数据ID:</label><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></li>
	<li><label>系统运行:</label><?php echo htmlentities($devObj->system_on,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机1:</label><?php echo htmlentities($devObj->compressor1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机2:</label><?php echo htmlentities($devObj->compressor2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机3:</label><?php echo htmlentities($devObj->compressor3,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机4:</label><?php echo htmlentities($devObj->compressor4,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器1:</label><?php echo htmlentities($devObj->heater1,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器2:</label><?php echo htmlentities($devObj->heater2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>热风:</label><?php echo htmlentities($devObj->hot_gas,ENT_COMPAT,"UTF-8");?></li>
	<li><label>除湿:</label><?php echo htmlentities($devObj->dehumidification,ENT_COMPAT,"UTF-8");?></li>
	<li><label>湿度:</label><?php echo htmlentities($devObj->humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>应急工作:</label><?php echo htmlentities($devObj->emergency,ENT_COMPAT,"UTF-8");?></li>
	<li><label>错误密码报警:</label><?php echo htmlentities($devObj->wrong_psword,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高温报警:</label><?php echo htmlentities($devObj->high_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低温报警:</label><?php echo htmlentities($devObj->low_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高湿度报警:</label><?php echo htmlentities($devObj->high_room_humidy,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低湿度报警:</label><?php echo htmlentities($devObj->low_root_humidy,ENT_COMPAT,"UTF-8");?></li>
	<li><label>温湿度传感器:</label><?php echo htmlentities($devObj->sensors,ENT_COMPAT,"UTF-8");?></li>
	<li><label>过滤器:</label><?php echo htmlentities($devObj->clogged_filter,ENT_COMPAT,"UTF-8");?></li>
	<li><label>漏水报警:</label><?php echo htmlentities($devObj->flooding,ENT_COMPAT,"UTF-8");?></li>
	<li><label>气流报警:</label><?php echo htmlentities($devObj->loss_air_flow,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器过热:</label><?php echo htmlentities($devObj->heater_over,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高压电路1:</label><?php echo htmlentities($devObj->circuit1_high_presure,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高压电路2:</label><?php echo htmlentities($devObj->circuit2_high_presure,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低压电路1:</label><?php echo htmlentities($devObj->circuit1_low_presure,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低压电路2:</label><?php echo htmlentities($devObj->circuit2_low_presure,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路1电流值:</label><?php echo htmlentities($devObj->circuit1_elec_valve,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路2电流值:</label><?php echo htmlentities($devObj->circuit2_elec_valve,ENT_COMPAT,"UTF-8");?></li>
	<li><label>wrong_phase_seq:</label><?php echo htmlentities($devObj->wrong_phase_seq,ENT_COMPAT,"UTF-8");?></li>
	<li><label>smoke_fire:</label><?php echo htmlentities($devObj->smoke_fire,ENT_COMPAT,"UTF-8");?></li>
	<li><label>interrupt_lan:</label><?php echo htmlentities($devObj->interrupt_lan,ENT_COMPAT,"UTF-8");?></li>
	<li><label>high_current:</label><?php echo htmlentities($devObj->high_current,ENT_COMPAT,"UTF-8");?></li>
	<li><label>气流丢失:</label><?php echo htmlentities($devObj->power_loss,ENT_COMPAT,"UTF-8");?></li>
	<li><label>水流丢失:</label><?php echo htmlentities($devObj->water_loss,ENT_COMPAT,"UTF-8");?></li>
	<li><label>连续波温度过高对除湿:</label><?php echo htmlentities($devObj->cthd,ENT_COMPAT,"UTF-8");?></li>
	<li><label>连续波阀故障或水流过低:</label><?php echo htmlentities($devObj->cvf_wftl,ENT_COMPAT,"UTF-8");?></li>
	<li><label>水流报警:</label><?php echo htmlentities($devObj->loss_water_flow,ENT_COMPAT,"UTF-8");?></li>
	<li><label>冷冻水温度高警报:</label><?php echo htmlentities($devObj->high_water_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室内空气传感器/断开连接失败:</label><?php echo htmlentities($devObj->room_air_sensor,ENT_COMPAT,"UTF-8");?></li>
	<li><label>热水温度传感器/断开连接失败:</label><?php echo htmlentities($devObj->hot_water_temp_sensor,ENT_COMPAT,"UTF-8");?></li>
    <li><label>冷冻水温度传感器/断开连接失败:</label><?php echo htmlentities($devObj->chilled_water_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室外温度传感器/断开连接失败:</label><?php echo htmlentities($devObj->outdoor_temp_sensor,ENT_COMPAT,"UTF-8");?></li>
	<li><label>交付空气温度传感器/断开连接失败:</label><?php echo htmlentities($devObj->deliv_air_temp_sensor,ENT_COMPAT,"UTF-8");?></li>
	<li><label>房间的湿度传感器/断开连接失败:</label><?php echo htmlentities($devObj->room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>冷冻水出口Temp.Sensor失败/断开连接:</label><?php echo htmlentities($devObj->water_outlet_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机1:小时计数器阈值报警:</label><?php echo htmlentities($devObj->compress1_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机2:小时计数器阈值报警:</label><?php echo htmlentities($devObj->compress2_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机3:小时计数器阈值报警:</label><?php echo htmlentities($devObj->compress3_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机4:小时计数器阈值报警:</label><?php echo htmlentities($devObj->compress4_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>空气过滤器:小时计数器阈值报警:</label><?php echo htmlentities($devObj->air_filter,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器1:小时计数器阈值报警:</label><?php echo htmlentities($devObj->heater1_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器2:小时计数器阈值报警:</label><?php echo htmlentities($devObj->heater2_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿器:小时计数器阈值报警:</label><?php echo htmlentities($devObj->humid_alarm,ENT_COMPAT,"UTF-8");?></li>
	<li><label>空调机组:小时计数器阈值报警:</label><?php echo htmlentities($devObj->air_cond_unit,ENT_COMPAT,"UTF-8");?></li>
	<li><label>警报通过数字输入2:</label><?php echo htmlentities($devObj->digital_input2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>警报通过数字输入4:</label><?php echo htmlentities($devObj->digital_input4,ENT_COMPAT,"UTF-8");?></li>
	<li><label>警报通过数字输入6:</label><?php echo htmlentities($devObj->digital_input6,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿器通用报警:</label><?php echo htmlentities($devObj->humid_general,ENT_COMPAT,"UTF-8");?></li>
	<li><label>单位在报警:</label><?php echo htmlentities($devObj->unit,ENT_COMPAT,"UTF-8");?></li>
	<li><label>单位在旋转报警:</label><?php echo htmlentities($devObj->unit_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>单位在报警A型:</label><?php echo htmlentities($devObj->unit_a,ENT_COMPAT,"UTF-8");?></li>
	<li><label>单位在报警B型:</label><?php echo htmlentities($devObj->unit_b,ENT_COMPAT,"UTF-8");?></li>
	<li><label>单位在报警C型:</label><?php echo htmlentities($devObj->unit_c,ENT_COMPAT,"UTF-8");?></li>
	<li><label>DX /连续波开关:</label><?php echo htmlentities($devObj->dc_switch,ENT_COMPAT,"UTF-8");?></li>
	<li><label>夏季/冬季开关:</label><?php echo htmlentities($devObj->sw_switch,ENT_COMPAT,"UTF-8");?></li>
	<li><label>单位开/关开关:</label><?php echo htmlentities($devObj->unit_switch,ENT_COMPAT,"UTF-8");?></li>
	<li><label>蜂鸣器报警单元复位:</label><?php echo htmlentities($devObj->unit_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>过滤器运行小时重置:</label><?php echo htmlentities($devObj->filter_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机运行1小时重置:</label><?php echo htmlentities($devObj->comp1_run_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机运行2小时重置:</label><?php echo htmlentities($devObj->comp2_run_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机运行3小时重置:</label><?php echo htmlentities($devObj->comp3_run_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机运行4小时重置:</label><?php echo htmlentities($devObj->comp4_run_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机1开始重置:</label><?php echo htmlentities($devObj->comp1_start_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机2开始重置:</label><?php echo htmlentities($devObj->comp2_start_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机3开始重置:</label><?php echo htmlentities($devObj->comp3_start_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>压缩机4开始重置:</label><?php echo htmlentities($devObj->comp4_start_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器运行1小时重置:</label><?php echo htmlentities($devObj->heater1_run_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器运行2小时重置:</label><?php echo htmlentities($devObj->heater2_run_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器1开始重置:</label><?php echo htmlentities($devObj->heater1_start_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器1开始重置:</label><?php echo htmlentities($devObj->heater2_start_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>增湿器运行小时重置:</label><?php echo htmlentities($devObj->humid_run_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>增湿器开始重置:</label><?php echo htmlentities($devObj->humid_start_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>单位运行时间重置:</label><?php echo htmlentities($devObj->unit_run_reset,ENT_COMPAT,"UTF-8");?></li>
	<li><label>挫折模式(睡眠模式):</label><?php echo htmlentities($devObj->setback_mode,ENT_COMPAT,"UTF-8");?></li>
	<li><label>睡眠模式测试:</label><?php echo htmlentities($devObj->sleep_mode_test,ENT_COMPAT,"UTF-8");?></li>
	<li><label>平均值:</label><?php echo htmlentities($devObj->lm_usage_values,ENT_COMPAT,"UTF-8");?></li>
	<li><label>备用单元:</label><?php echo htmlentities($devObj->sb_unit_no,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第2单元旋转报警:</label><?php echo htmlentities($devObj->unit2_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第3单元旋转报警:</label><?php echo htmlentities($devObj->unit3_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第4单元旋转报警:</label><?php echo htmlentities($devObj->unit4_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第5单元旋转报警:</label><?php echo htmlentities($devObj->unit5_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第6单元旋转报警:</label><?php echo htmlentities($devObj->unit6_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第7单元旋转报警:</label><?php echo htmlentities($devObj->unit7_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第8单元旋转报警:</label><?php echo htmlentities($devObj->unit8_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第9单元旋转报警:</label><?php echo htmlentities($devObj->unit9_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第10单元旋转报警:</label><?php echo htmlentities($devObj->unit10_rotation,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室外温度:</label><?php echo htmlentities($devObj->outdoor_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>交付空气温度:</label><?php echo htmlentities($devObj->deliv_air_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>冷水温度:</label><?php echo htmlentities($devObj->chill_water_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>热水温度:</label><?php echo htmlentities($devObj->hot_water_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>房间相对湿度:</label><?php echo htmlentities($devObj->room_rela_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>出口冷冻水温度:</label><?php echo htmlentities($devObj->outlet_water_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路1蒸发压力:</label><?php echo htmlentities($devObj->circuit1_evap_press,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路2蒸发压力:</label><?php echo htmlentities($devObj->circuit2_evap_press,ENT_COMPAT,"UTF-8");?></li>	
	<li><label>电路1吸入温度:</label><?php echo htmlentities($devObj->circuit1_suct_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路2吸入温度:</label><?php echo htmlentities($devObj->circuit2_suct_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路1蒸发温度:</label><?php echo htmlentities($devObj->circuit1_evap_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路2蒸发温度:</label><?php echo htmlentities($devObj->circuit2_evap_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路1过热:</label><?php echo htmlentities($devObj->circuit1_superheat,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路2过热:</label><?php echo htmlentities($devObj->circuit2_superheat,ENT_COMPAT,"UTF-8");?></li>
	<li><label>冷水阀坡道:</label><?php echo htmlentities($devObj->cold_water_ramp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>热水出水阀坡道:</label><?php echo htmlentities($devObj->hot_water_ramp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>蒸发风扇转速:</label><?php echo htmlentities($devObj->evap_fan_speed,ENT_COMPAT,"UTF-8");?></li>
	<li><label>冷却定位点:</label><?php echo htmlentities($devObj->cool_set,ENT_COMPAT,"UTF-8");?></li>
	<li><label>冷却的敏感性:</label><?php echo htmlentities($devObj->cool_sensit,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第二个冷却定位点:</label><?php echo htmlentities($devObj->cool_set2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热定位点:</label><?php echo htmlentities($devObj->heat_se,ENT_COMPAT,"UTF-8");?></li>
	<li><label>第二次加热定位点:</label><?php echo htmlentities($devObj->heat_set2,ENT_COMPAT,"UTF-8");?></li>
	<li><label>听力敏感性:</label><?php echo htmlentities($devObj->heat_sensit,ENT_COMPAT,"UTF-8");?></li>
	<li><label>房间温度高报警阈值:</label><?php echo htmlentities($devObj->high_room_temp_thres,ENT_COMPAT,"UTF-8");?></li>
	<li><label>室温低报警阈值:</label><?php echo htmlentities($devObj->low_room_temp_thres,ENT_COMPAT,"UTF-8");?></li>
	<li><label>挫折模式:冷却定位点:</label><?php echo htmlentities($devObj->cool_set_mode,ENT_COMPAT,"UTF-8");?></li>
	<li><label>挫折模式:加热定位点:</label><?php echo htmlentities($devObj->heat_set_mode,ENT_COMPAT,"UTF-8");?></li>
	<li><label>连续波选点开始除湿:</label><?php echo htmlentities($devObj->cws_to_sd,ENT_COMPAT,"UTF-8");?></li>
	<li><label>连续波高温报警阈值:</label><?php echo htmlentities($devObj->cw_high_temp_thres,ENT_COMPAT,"UTF-8");?></li>
	<li><label>连续波选点开始连续波操作模式(只有TC单位):</label><?php echo htmlentities($devObj->cws_to_scwom,ENT_COMPAT,"UTF-8");?></li>
	<li><label>Radcooler定位点在节能模式:</label><?php echo htmlentities($devObj->radcool_set,ENT_COMPAT,"UTF-8");?></li>
	<li><label>Radcooler定位点在DX模式:</label><?php echo htmlentities($devObj->radcooler_set_dx,ENT_COMPAT,"UTF-8");?></li>
	<li><label>排气温度下限设定值:</label><?php echo htmlentities($devObj->del_temp_low_set,ENT_COMPAT,"UTF-8");?></li>
	<li><label>串行传输抵消:</label><?php echo htmlentities($devObj->delta_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>自动均值/局部转换的三角洲温度:</label><?php echo htmlentities($devObj->serial_trans,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网单元二室温:</label><?php echo htmlentities($devObj->unit2_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网单元三室温:</label><?php echo htmlentities($devObj->unit3_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网单元四室温:</label><?php echo htmlentities($devObj->unit4_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网单元五室温:</label><?php echo htmlentities($devObj->unit5_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网单元六室温:</label><?php echo htmlentities($devObj->unit6_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网单元七室温:</label><?php echo htmlentities($devObj->unit7_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网单元八室温:</label><?php echo htmlentities($devObj->unit8_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网单元九室温:</label><?php echo htmlentities($devObj->unit9_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网单元十室温:</label><?php echo htmlentities($devObj->unit10_room_temp,ENT_COMPAT,"UTF-8");?></li>
	<li><label>二单元保温室:</label><?php echo htmlentities($devObj->unit2_room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>三单元保温室:</label><?php echo htmlentities($devObj->unit3_room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>四单元保温室:</label><?php echo htmlentities($devObj->unit4_room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>五单元保温室:</label><?php echo htmlentities($devObj->unit5_room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>六单元保温室:</label><?php echo htmlentities($devObj->unit6_room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>七单元保温室:</label><?php echo htmlentities($devObj->unit7_room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>八单元保温室:</label><?php echo htmlentities($devObj->unit8_room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>九单元保温室:</label><?php echo htmlentities($devObj->unit9_room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>十单元保温室:</label><?php echo htmlentities($devObj->unit10_room_humid,ENT_COMPAT,"UTF-8");?></li>
	<li><label>空气过滤器:</label><?php echo htmlentities($devObj->air_filter_run,ENT_COMPAT,"UTF-8");?></li>
	<li><label>运行单位:</label><?php echo htmlentities($devObj->unit_run,ENT_COMPAT,"UTF-8");?></li>
	<li><label>空压机1运行:</label><?php echo htmlentities($devObj->comp1_run,ENT_COMPAT,"UTF-8");?></li>
	<li><label>空压机2运行:</label><?php echo htmlentities($devObj->comp2_run,ENT_COMPAT,"UTF-8");?></li>
	<li><label>空压机3运行:</label><?php echo htmlentities($devObj->comp3_run,ENT_COMPAT,"UTF-8");?></li>
	<li><label>空压机4运行:</label><?php echo htmlentities($devObj->comp4_run,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器1运行:</label><?php echo htmlentities($devObj->heat1_run,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加热器2运行:</label><?php echo htmlentities($devObj->heat2_run,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿器运行:</label><?php echo htmlentities($devObj->humid_run,ENT_COMPAT,"UTF-8");?></li>
	<li><label>除湿器支撑带:</label><?php echo htmlentities($devObj->dehumid_prop_band,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿器支撑带:</label><?php echo htmlentities($devObj->humid_prop_band,ENT_COMPAT,"UTF-8");?></li>
	<li><label>高湿度报警阈值:</label><?php echo htmlentities($devObj->high_humid_thres,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低湿度报警阈值:</label><?php echo htmlentities($devObj->low_humid_thres,ENT_COMPAT,"UTF-8");?></li>
	<li><label>除湿定位点:</label><?php echo htmlentities($devObj->dehumid_set,ENT_COMPAT,"UTF-8");?></li>
	<li><label>除湿定位点逆流模式:</label><?php echo htmlentities($devObj->dehumid_set_mode,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿定位点:</label><?php echo htmlentities($devObj->humid_set,ENT_COMPAT,"UTF-8");?></li>
	<li><label>加湿定位点逆流模式:</label><?php echo htmlentities($devObj->humid_set_mode,ENT_COMPAT,"UTF-8");?></li>
	<li><label>重新启动延迟:</label><?php echo htmlentities($devObj->res_delay,ENT_COMPAT,"UTF-8");?></li>
	<li><label>regula_start_trans:</label><?php echo htmlentities($devObj->regula_start_trans,ENT_COMPAT,"UTF-8");?></li>
	<li><label>低压延迟:</label><?php echo htmlentities($devObj->low_press_delay,ENT_COMPAT,"UTF-8");?></li>
	<li><label>温度/湿度限制告警延迟:</label><?php echo htmlentities($devObj->th_limit_delay,ENT_COMPAT,"UTF-8");?></li>
	<li><label>防震荡常数:</label><?php echo htmlentities($devObj->anti_hunt,ENT_COMPAT,"UTF-8");?></li>
	<li><label>备用循环基准时间:</label><?php echo htmlentities($devObj->cycle,ENT_COMPAT,"UTF-8");?></li>
	<li><label>局域网的数量单位:</label><?php echo htmlentities($devObj->lan_units_num,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路1电子阀的位置:</label><?php echo htmlentities($devObj->circuit1_elec,ENT_COMPAT,"UTF-8");?></li>
	<li><label>电路2电子阀的位置:</label><?php echo htmlentities($devObj->circuit2_elec,ENT_COMPAT,"UTF-8");?></li>
    <?php }?>
 
</ul>