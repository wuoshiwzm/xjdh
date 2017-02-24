<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Realtime
{

    static function Get_Mec10RtData($dataIdStr)
    {
        $CI = & get_instance();
        $CI->load->driver('cache');
        $mec10List = array();
        $idArr = array();
        if (strlen($dataIdStr) > 0)
            $idArr = explode(',', $dataIdStr);
        foreach ($idArr as $key => $val) {
            $mec10Obj = new stdClass();
            $mec10Obj->data_id = $val;
            $memData = $CI->cache->get($val);
            if (strlen($memData) > 48) {
                $v = unpack('c*', substr($memData, 4, 2));
                $mec10Obj->mode = $v[1];
                $mec10Obj->on_status = $v[2];
                $v = unpack('s', substr($memData, 6, 2));
                $mec10Obj->speed = $v[1];
                $v = unpack('c*', substr($memData, 8, 5));
                $mec10Obj->front_status = $v[1];
                $mec10Obj->alert1 = $v[2];
                $mec10Obj->alert2 = $v[3];
                $mec10Obj->alert3 = $v[4];
                $mec10Obj->alert4 = $v[5];
                $v = unpack('s*', substr($memData, 13, 2*9));
                $mec10Obj->battery = $v[1];
                $mec10Obj->ai1 = $v[2];
                $mec10Obj->ai2 = $v[3];
                $mec10Obj->ai3 = $v[4];
                $mec10Obj->ai4 = $v[5];
                $mec10Obj->ai5 = $v[6];
                $mec10Obj->ai6 = $v[7];
                $mec10Obj->freq = $v[8];
                $v = unpack('i', substr($memData, 13+2*9+4, 4));
                $mem10Obj->run_time = $v[1];
                $v = unpack('i', substr($memData, 13+2*9+4 + 4, 4));
                $mem10Obj->up_time = $v[1];
                $mem10Obj->count = $v[2];
                $v = unpack('c*', substr($memData, 13+2*9+4 + 4 + 4, 6));
                $mem10Obj->year = $v[1];
                $mem10Obj->month = $v[2];
                $mem10Obj->day = $v[3];
                $mem10Obj->hour = $v[4];
                $mem10Obj->minute = $v[5];
                $mem10Obj->second = $v[6];
                //功率寄存器
            }
            $mem10Obj->update_datetime = date('Y-m-d H:i:s');
            $mem10Obj->dynamic_config = $CI->cache->get($val . '_dc');
            array_push($mem10List, $mem10Obj);
        }
        return $mec10List;
    }
    static function Get_Power302ARtData($dataIdStr)
    {
        $CI = & get_instance();
        $CI->load->driver('cache');
        $power302aDevList = array();
        $idArr = array();
        if (strlen($dataIdStr) > 0)
            $idArr = explode(',', $dataIdStr);
        foreach ($idArr as $key => $val) {
            $power302aDevObj = new stdClass();
            $power302aDevObj->data_id = $val;
            $memData = $CI->cache->get($val);
            if (strlen($memData) == 248) {
                $v = unpack('f*', substr($memData,4,244));
                //功率寄存器
                $power302aDevObj->pa = number_format($v[1]/1000, 3);
                $power302aDevObj->pb = number_format($v[2]/1000, 3);
                $power302aDevObj->pc = number_format($v[3]/1000, 3);
                $power302aDevObj->pt = number_format($v[4]/1000, 3);
                $power302aDevObj->qa = number_format($v[5], 3);
                $power302aDevObj->qb = number_format($v[6], 3);
                $power302aDevObj->qc = number_format($v[7], 3);
                $power302aDevObj->qt = number_format($v[8], 3);
                $power302aDevObj->sa = number_format($v[9], 3);
                $power302aDevObj->sb = number_format($v[10], 3);
                $power302aDevObj->sc = number_format($v[11], 3);
                $power302aDevObj->st = number_format($v[12], 3);
                $power302aDevObj->linePa = number_format($v[13], 3);
                $power302aDevObj->linePb = number_format($v[14], 3);
                $power302aDevObj->linePc = number_format($v[15], 3);
                $power302aDevObj->linePt = number_format($v[16], 3);
                $power302aDevObj->lineQa = number_format($v[17], 3);
                $power302aDevObj->lineQb = number_format($v[18], 3);
                $power302aDevObj->lineQc = number_format($v[19], 3);
                $power302aDevObj->lineQt = number_format($v[20], 3);
                //有效值寄存器
                $power302aDevObj->uaRms = number_format($v[21], 3);
                $power302aDevObj->ubRms = number_format($v[22], 3);
                $power302aDevObj->ucRms = number_format($v[23], 3);
                $power302aDevObj->iaRms = number_format($v[24], 3);
                $power302aDevObj->ibRms = number_format($v[25], 3);
                $power302aDevObj->icRms = number_format($v[26], 3);
                $power302aDevObj->itRms = number_format($v[27], 3);
                $power302aDevObj->utRms = number_format($v[28], 3);
                $power302aDevObj->luaRms = number_format($v[29], 3);
                $power302aDevObj->lubRms = number_format($v[30], 3);
                $power302aDevObj->lucRms = number_format($v[31], 3);
                $power302aDevObj->liaRms = number_format($v[32], 3);
                $power302aDevObj->libRms = number_format($v[33], 3);
                $power302aDevObj->licRms = number_format($v[34], 3);
                //功率因数寄存器
                $power302aDevObj->pfa = number_format($v[35], 3);
                $power302aDevObj->pfb = number_format($v[36], 3);
                $power302aDevObj->pfc = number_format($v[37], 3);
                $power302aDevObj->pft = number_format($v[38], 3);
                //功率角和电压夹角寄存器
                $power302aDevObj->pga = number_format($v[39], 3);
                $power302aDevObj->pgb = number_format($v[40], 3);
                $power302aDevObj->pgc = number_format($v[41], 3);
                $power302aDevObj->yuaub = number_format($v[42], 3);
                $power302aDevObj->yuauc = number_format($v[43], 3);
                $power302aDevObj->yubuc = number_format($v[44], 3);
                //线频率寄存器
                $power302aDevObj->freq = number_format($v[45], 3);
                //能量寄存器
                $power302aDevObj->epa = number_format($v[46], 3);
                $power302aDevObj->epb = number_format($v[47], 3);
                $power302aDevObj->epc = number_format($v[48], 3);
                $power302aDevObj->ept = number_format($v[49], 3);
                $power302aDevObj->eqa = number_format($v[50], 3);
                $power302aDevObj->eqb = number_format($v[51], 3);
                $power302aDevObj->eqc = number_format($v[52], 3);
                $power302aDevObj->eqt = number_format($v[53], 3);
                $power302aDevObj->esa = number_format($v[54], 3);
                $power302aDevObj->esb = number_format($v[55], 3);
                $power302aDevObj->esc = number_format($v[56], 3);
                $power302aDevObj->est = number_format($v[57], 3);
                $power302aDevObj->lineEpa = number_format($v[58], 3);
                $power302aDevObj->lineEpb = number_format($v[59], 3);
                $power302aDevObj->lineEpc = number_format($v[60], 3);
                $power302aDevObj->lineEpt = number_format($v[61], 3);               
            }            
            $power302aDevObj->update_datetime = date('Y-m-d H:i:s');
            $power302aDevObj->dynamic_config = $CI->cache->get($val . '_dc');
            array_push($power302aDevList, $power302aDevObj);
        }
        return $power302aDevList;
    }
    static function Get_Imem12RtData ($dataIdStr)
    {
        $CI = & get_instance();
        $CI->load->driver('cache');
        $imem12DevList = array();
        $idArr = array();
        if (strlen($dataIdStr) > 0)
            $idArr = explode(',', $dataIdStr);
        
        foreach ($idArr as $key => $val) {
            $imem12DevObj = new stdClass();
            $imem12DevObj->data_id = $val;
            $memData = $CI->cache->get($val);
            if (strlen($memData) == 32) {
                $v = unpack('f*', $memData);
                $imem12DevObj->w1 = number_format($v[1], 2);
                $imem12DevObj->p1 = number_format($v[2], 2);
                $imem12DevObj->w2 = number_format($v[3], 2);
                $imem12DevObj->p2 = number_format($v[4], 2);
                $imem12DevObj->w3 = number_format($v[5], 2);
                $imem12DevObj->p3 = number_format($v[6], 2);
                $imem12DevObj->w4 = number_format($v[7], 2);
                $imem12DevObj->p4 = number_format($v[8], 2);
            } else {
                $imem12DevObj->w1 = 0;
                $imem12DevObj->p1 = 0;
                $imem12DevObj->w2 = 0;
                $imem12DevObj->p2 = 0;
                $imem12DevObj->w3 = 0;
                $imem12DevObj->p3 = 0;
                $imem12DevObj->w4 = 0;
                $imem12DevObj->p4 = 0;
            }
            $imem12DevObj->update_datetime = date('Y-m-d H:i:s');
            $imem12DevObj->dynamic_config = $CI->cache->get($val . '_dc');
            array_push($imem12DevList, $imem12DevObj);
        }
        return $imem12DevList;
    }
    static function Get_Battery4Voltage($dataIdStr)
    {
        $CI = & get_instance();
        $CI->load->driver('cache');
        $batList = array();
        $idArr = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        foreach ($idArr as $key => $val) {
            $batObj = new stdClass();
            $batObj->data_id = $val;
            $memData = $CI->cache->get($val);
            $val = unpack('f', $memData);
            $batObj->group_v = number_format($val[1], 2);
            $batObj->update_datetime = date('Y-m-d H:i:s');
            $batObj->dynamic_config = $CI->cache->get($val . '_dc');
            array_push($batList, $batObj);
        }
        return $batList;
    }
    static function Get_BatRtData ($dataIdStr, $batNum)
    {
        $CI = & get_instance();
        $CI->load->driver('cache');
        $batList = array();
        $idArr = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        /**
         * bat
         * unsigned int data_id;
         * float voltage[$batNum];
         * float group_v;
         * float group_i;
         * unsigned char no_i;
         * float temperature;
         * tele_c_ttime update_time;
         */
        foreach ($idArr as $key => $val) {
            $batObj = new stdClass();
            $batObj->data_id = $val;
            $memData = $CI->cache->get($val);
            $batObj->pi = json_decode($CI->cache->get($val . '_pi'));
            if ($batObj->pi != null) {
                foreach ($batObj->pi as $piObj) {
                    if ($piObj->name != 'gv' && $batNum == 24) {
                        $piObj->value = number_format($piObj->value, 3);
                    } else {
                        $piObj->value = number_format($piObj->value, 2);
                    }
                }
            }
            if (strlen($memData) == ($batNum == 24 ? 120 : 152)) {
                $v = unpack('f*', substr($memData, 4, $batNum * 4));
                $batObj->voltage = array();
                foreach ($v as $key => $val) {
                    array_push($batObj->voltage, number_format($val, $batNum == 24 ? 3 : 2));
                }
                $v = unpack('f*', substr($memData, 4 + $batNum * 4, 8));
                $batObj->group_v = number_format($v[1], 2);
                $batObj->group_i = number_format($v[2], 2);
                $v = unpack('C', substr($memData, $batNum * 4 + 4 + 4 + 4, 1));
                $batObj->no_i = number_format($v[1], 2);
                $v = unpack('f', substr($memData, $batNum * 4 + 4 + 4 + 4 + 1, 4));
                $batObj->temperature = number_format($v[1], 2);
                $val = unpack('v', substr($memData, $batNum * 4 + 4 + 4 + 4 + 4 + 1, 2));
                $year = $val[1];
                $val = unpack('C*', substr($memData, $batNum * 4 + 4 + 4 + 4 + 4 + 1 + 2, 5));
                $batObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $val[1] . '-' . $val[2] . ' ' . $val[3] . ':' . $val[4] . ':' . $val[5]));
            } else {
                $batObj->voltage = array();
                for ($i = 0; $i < $batNum; $i ++) {
                    array_push($batObj->voltage, 0);
                }
                $batObj->group_v = 0;
                $batObj->group_i = 0;
                $batObj->no_i = true;
                $batObj->temperature = 0;
                $batObj->update_datetime = date('Y-m-d H:i:s');
            }
            $batObj->dynamic_config = $CI->cache->get($batObj->data_id . '_dc');
            array_push($batList, $batObj);
        }
        return $batList;
    }

    static function Get_FreshAirRtData ($dataIdStr)
    {
        /*
         * typedef struct tele_c_freshair_
         * {
         * unsigned int data_id;
         * //60_42 获取模拟量量化后数据（定点数）
         * float temperature1;
         * float temperature2;
         * float temperature3;
         * float temperature4;
         * float temperature5;//室内温度5
         * float humidity1;
         * float humidity2;
         * float humidity3;
         * float humidity4;
         * float humidity5;//室内湿度5
         * float wind_temperature;//出风温度
         * float wind_humidity;//出风湿度
         * float outside_temperature;//室外温度
         * float outside_humidity;//室外湿度
         * float humidifier_current;
         * float average_temperature;
         * float average_humidity;
         *
         * unsigned short reserve_60_42_1;
         * unsigned short reserve_60_42_2;
         *
         * float highest_temperature;
         *
         * //60_43 获取设备状态及系统运行状态
         * char runstate_alert;//公共告警
         * char runstate_fan;//内风机
         * char runstate_r1;//
         * char runstate_r2;//
         * char runstate_r3;//
         * char runstate_r4;//
         * char runstate_drain;//湿帘加湿排水
         * char runstate_fill;//湿帘加湿注水
         * char runstate_pump;//湿帘加湿水泵
         * char runstate_ac;//外部空调
         * //60_44 获取告警状态
         * char alert[135];//00H：正常 20H：无此报警类型 ,01H：故障
         *
         * //60_47 参数设置
         * float setting_temperature;//温度设定点
         * float setting_humidity;//湿度设定点
         * float high_temperature_alert;//高温告警点
         * float low_temperature_alert;//低温告警点
         * float high_humidity_alert;//高湿报警点
         * float low_humidity_alert;//低湿报警点
         *
         * tele_c_ttime update_time;
         * }tele_c_freshair;
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $idArr = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        $freshAirList = array();
        foreach ($idArr as $key => $val) {
            $freshAirObj = new stdClass();
            $freshAirObj->data_id = $val;
            $memData = $CI->cache->get($val);
            if (strlen($memData) == 256) {
                $freshAirObj->is_empty = false;
                $v = unpack('f*', substr($memData, 0, 18 * 4));
                // $freshAirObj->data_id = $v[1];
                $freshAirObj->temperature1 = number_format($v[2], 2);
                $freshAirObj->temperature2 = 0; // number_format($v[3], 2);
                $freshAirObj->temperature3 = 0; // number_format($v[4], 2);
                $freshAirObj->temperature4 = 0; // number_format($v[5], 2);
                $freshAirObj->temperature5 = 0; // number_format($v[6], 2); // 室内温度5
                $freshAirObj->humidity1 = number_format($v[7], 2);
                
                $freshAirObj->humidity2 = 0; // number_format($v[8], 2);
                $freshAirObj->humidity3 = 0; // number_format($v[9], 2);
                $freshAirObj->humidity4 = 0; // number_format($v[10], 2);
                $freshAirObj->humidity5 = 0; // number_format($v[11], 2); // 室内湿度5
                $freshAirObj->wind_temperature = number_format($v[12], 2); // 出风温度
                $freshAirObj->wind_humidity = number_format($v[13], 2); // 出风湿度
                $freshAirObj->outside_temperature = number_format($v[14], 2); // 室外温度
                $freshAirObj->outside_humidity = number_format($v[15], 2); // 室外湿度
                $freshAirObj->humidifier_current = number_format($v[16], 2);
                $freshAirObj->average_temperature = number_format($v[17], 2);
                $freshAirObj->average_humidity = number_format($v[18], 2);
                
                $v = unpack('s*', substr($memData, 18 * 4, 2 * 2));
                $freshAirObj->reserve_60_42_1 = $v[1];
                $freshAirObj->reserve_60_42_2 = $v[2];
                $v = unpack('f', substr($memData, 18 * 4 + 2 * 2, 4));
                $freshAirObj->highest_temperature = number_format($v[1], 2);
                // 60_43 获取设备状态及系统运行状态
                $v = unpack('c*', substr($memData, 18 * 4 + 2 * 2 + 4, 10));
                $freshAirObj->runstate_alert = $v[1]; // 公共告警
                $freshAirObj->runstate_fan = $v[2]; // 内风机
                $freshAirObj->runstate_r1 = $v[3]; //
                $freshAirObj->runstate_r2 = $v[4]; //
                $freshAirObj->runstate_r3 = $v[5]; //
                $freshAirObj->runstate_r4 = $v[6]; //
                $freshAirObj->runstate_drain = $v[7]; // 湿帘加湿排水
                $freshAirObj->runstate_fill = $v[8]; // 湿帘加湿注水
                $freshAirObj->runstate_pump = $v[9]; // 湿帘加湿水泵
                $freshAirObj->runstate_ac = $v[10]; // 外部空调
                
                /*
                 * 60_44 获取告警状态
                 * 00H：正常 20H：无此报警类型 ,01H：故障
                 */
                // $v = unpack('c*', substr($memData, 18 * 4 + 2 * 2 + 4 + 10,
                // 135));
                // $freshAirObj->alert[135] = $v[0];
                
                // 60_47 参数设置
                $v = unpack('f*', substr($memData, 18 * 4 + 2 * 2 + 4 + 10 + 135, 6 * 4));
                $freshAirObj->setting_temperature = number_format($v[1], 2); // 温度设定点
                $freshAirObj->setting_humidity = number_format($v[2], 2); // 湿度设定点
                $freshAirObj->high_temperature_alert = number_format($v[3], 2); // 高温告警点
                $freshAirObj->low_temperature_alert = number_format($v[4], 2); // 低温告警点
                $freshAirObj->high_humidity_alert = number_format($v[5], 2); // 高湿报警点
                $freshAirObj->low_humidity_alert = number_format($v[6], 2); // 低湿报警点
                
                $v = unpack('v', substr($memData, 18 * 4 + 2 * 2 + 4 + 10 + 135 + 6 * 4, 2));
                $year = $v[1];
                $v = unpack('C*', substr($memData, 18 * 4 + 2 * 2 + 4 + 10 + 135 + 6 * 4 + 2, 5));
                $freshAirObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
            } else {
                $freshAirObj->is_empty = true;
                $freshAirObj->update_datetime = date('Y-m-d H:i:s');
            }
            $freshAirObj->dynamic_config = $CI->cache->get($freshAirObj->data_id . '_dc');
            array_push($freshAirList, $freshAirObj);
        }
        return $freshAirList;
    }

    static function Get_Datamate3000RtData ($dataIdStr)
    {
        /*
         struct tele_c_data_mate3000
        {
        	unsigned int data_id;
        	//获取模拟量参数 --60_42
        	float room_temp; //室内温度
        	float room_humid; //室内湿度
        	float outdoor_temp; //室外温度
        	//获取开关机状态 --60_43
        	unsigned char air_state; //空调状态
        	//获取系统参数 --60_47
        	float temperature; //开机温度
        	float humidity; //关机湿度
        	float set_temp; //温度设定点
        	float temp_pric; //温度偏差
        	float set_humid; //湿度设定点
        	float humid_pric; //湿度偏差
        //	//获取系统监测模块时间 --60_4D
        //	unsigned short sys_year;
        //	unsigned char sys_month;
        //	unsigned char sys_day;
        //	unsigned char sys_hour;
        //	unsigned char sys_minute;
        //	unsigned char sys_seconds;
        	//获取机组状态 --60_82
        	unsigned char switch_status; //开关机状态
        	unsigned char fan_status; //风机状态
        	unsigned char cool_status; //制冷状态
        	unsigned char heat_status; //加热状态
        	unsigned char humid_status; //加湿状态
        	unsigned char dehumid_status; //除湿状态
        	unsigned char alert_status; //告警状态
        	unsigned char high_press_alarm; //高压报警
        	unsigned char low_press_alarm; //低压报警
        	unsigned char high_temp_alarm; //高温报警
        	unsigned char low_temp_alarm; //低温报警
        	unsigned char high_humid_alarm; //高湿报警
        	unsigned char low_humid_alarm; //低温报警
        	unsigned char power_failer_alarm; //电源故障告警
        	unsigned char short_cycle_alarm;  //短周期告警
        	unsigned char custom_alarm1; //用户自定义告警1
        	unsigned char custom_alarm2; //用户自定义告警2
        	unsigned char main_fan_mainten_alarm; //主风机维护告警
        	unsigned char humid_mainten_alarm; //加湿器维护报警
        	unsigned char filter_mainten_alarm; //过滤网维护报警
        	unsigned char com_failer_alarm; //通讯故障报警
        	unsigned char coil_freeze_alarm; //盘管冻结告警
        	unsigned char humid_fault_alarm; //加湿器故障报警
        	unsigned char sensor_miss_alarm; //传感器板丢失告警
        	unsigned char gas_temp_fault_alarm; //排气温度故障告警
        	unsigned char power_miss_fault_alarm; //电源丢失故障告警
        	unsigned char power_undervol_alarm; //电源过欠压报警
        	unsigned char power_phase_alarm; //电源缺相报警
        	unsigned char power_freq_alarm; //电源频率偏移报警
        	unsigned char floor_overflow_alarm; //地板溢水报警
        	unsigned char save_card_failure; //节能卡故障
        	//获取当前机组状态  --60_83
        	unsigned char unit_status; //机组状态
        	unsigned char unit_prop; //机组属性
        	unsigned char high_press_lock; //高压锁定
        	unsigned char low_press_lock; //低压锁定
        	unsigned char exhaust_lock; //排气锁定
        	
        	tele_c_ttime update_time;	
        };
        */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $idArr = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        $dataList = array();
        foreach ($idArr as $key => $val) {
            $dataObj = new stdClass();
            $dataObj->data_id = $val;
            $memData = $CI->cache->get($val);
            if (strlen($memData) > 100) {
                $dataObj->is_empty = false;
                $v = unpack('f*', substr($memData, 0, 4 * 4));
                $dataObj->room_temp = number_format($v[2], 1);
                $dataObj->room_humid = number_format($v[3], 1);
                $dataObj->outdoor_temp = number_format($v[4], 1);
                
                $v = unpack('c*', substr($memData, 4 * 4, 1));
                $dataObj->air_state = $v[1];
                
                $v = unpack('f*', substr($memData, 4 * 4 + 1, 4*6));
                $dataObj->temperature = number_format($v[1], 1);
                $dataObj->humidity = number_format($v[2], 1);    
                $dataObj->set_temp = number_format($v[3], 1);
                $dataObj->temp_pric = number_format($v[4], 1);
                $dataObj->set_humid = number_format($v[5], 1);
                $dataObj->humid_pric = number_format($v[6], 1);
                
                $v = unpack('c*', substr($memData, 4 * 4 + 1 + 4*6, 36));
                $dataObj->switch_status = $v[1];
                $dataObj->fan_status = $v[2];
                $dataObj->cool_status = $v[3];
                $dataObj->heat_status = $v[4];
                $dataObj->humid_status = $v[5];
                $dataObj->dehumid_status = $v[6];
                $dataObj->alert_status = $v[7];
                $dataObj->high_press_alarm = $v[8];
                $dataObj->low_press_alarm = $v[9];
                $dataObj->high_temp_alarm = $v[10];
                $dataObj->low_temp_alarm = $v[11];
                $dataObj->high_humid_alarm = $v[12];
                $dataObj->low_humid_alarm = $v[13];
                $dataObj->power_failer_alarm = $v[14];
                $dataObj->short_cycle_alarm = $v[15];
                $dataObj->custom_alarm1 = $v[16];
                $dataObj->custom_alarm2 = $v[17];
                $dataObj->main_fan_mainten_alarm = $v[18];
                $dataObj->humid_mainten_alarm = $v[19];
                $dataObj->filter_mainten_alarm = $v[20];
                $dataObj->com_failer_alarm = $v[21];
                $dataObj->coil_freeze_alarm = $v[22];
                $dataObj->humid_fault_alarm = $v[23];
                $dataObj->sensor_miss_alarm = $v[24];
                $dataObj->gas_temp_fault_alarm = $v[25];
                $dataObj->power_miss_fault_alarm = $v[26];
                $dataObj->power_undervol_alarm = $v[27];
                $dataObj->power_phase_alarm = $v[28];
                $dataObj->power_freq_alarm = $v[29];
                $dataObj->floor_overflow_alarm = $v[30];
                $dataObj->save_card_failure = $v[31];
                $dataObj->unit_status = $v[32];
                $dataObj->unit_prop = $v[33];
                $dataObj->high_press_lock = $v[34];
                $dataObj->low_press_lock = $v[35];
                $dataObj->exhaust_lock = $v[36];
             
    
                $v = unpack('v', substr($memData, 4 * 4 + 1 + 4*6 + 36, 2));
                $year = $v[1];
                $v = unpack('C*', substr($memData, 4 * 4 + 1 + 4*6 + 36 + 2, 5));
                $dataObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
            } else {
                $dataObj->is_empty = true;
                $dataObj->update_datetime = date('Y-m-d H:i:s');
            }
            //$dataObj->dynamic_config = $CI->cache->get($freshAirObj->data_id . '_dc');
            array_push($dataList, $dataObj);
        }
        return $dataList;
    }
    static function Get_SwitchingPowerSupplyRtData ($dataIdStr)
    {
        $idArr = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        $CI = & get_instance();
        $switchingPowerSupplyList = array();
        foreach ($idArr as $data_id) {
            $devObj = $CI->mp_xjdh->Get_Device($data_id);
            $switchingPowerSupplyObj = new stdClass();
            switch ($devObj->model) {
                case 'psma-ac':
                    $switchingPowerSupplyObj = Realtime::_Get_PsmaAcData($data_id);
                    break;
                case 'psma-dc':
                    $switchingPowerSupplyObj = Realtime::_Get_PsmaDcData($data_id);
                    break;
                case 'psma-rc':
                    $switchingPowerSupplyObj = Realtime::_Get_PsmaRcData($data_id);
                    break;
                case 'm810g-ac':
                    $switchingPowerSupplyObj = Realtime::_Get_M810gAcData($data_id);
                    break;
                case 'm810g-dc':
                    $switchingPowerSupplyObj = Realtime::_Get_M810gDcData($data_id);
                    break;
                case 'm810g-rc':
                    $switchingPowerSupplyObj = Realtime::_Get_M810gRcData($data_id);
                    break;
               	case 'smu06c-ac':
                    $switchingPowerSupplyObj = Realtime::_Get_Smu06cAcData($data_id);
                    break;
                case 'smu06c-dc':
                    $switchingPowerSupplyObj = Realtime::_Get_Smu06cDcData($data_id);
                    break;
                case 'smu06c-rc':
                    $switchingPowerSupplyObj = Realtime::_Get_Smu06cRcData($data_id);
                    break;
                case 'zxdu-ac':
		    $switchingPowerSupplyObj = Realtime::Get_zxduACcache($data_id);
		    break;
                case 'zxdu-dc':
		    $switchingPowerSupplyObj = Realtime::Get_zxduDCcache($data_id);
		    break;
		case 'zxdu-rc':
		    $switchingPowerSupplyObj = Realtime::Get_zxduRCcache($data_id);
		    break;
                default:
                    break;
            }
            $switchingPowerSupplyObj->model = $devObj->model;
            array_push($switchingPowerSupplyList, $switchingPowerSupplyObj);
        }
        return $switchingPowerSupplyList;
    }

    static function Get_Dk04RtData($dataIdStr)
    {
        /*	unsigned short SysV;
	unsigned short ILoad;
	short IBat1;
	short IBat2;
	short IBat3;
	short IBat4;
	unsigned short VAcSys;
	unsigned short I1AcSys;
	unsigned short I2AcSys;
	unsigned char  MDO1va1;
	unsigned char  MDO2val;
	unsigned char  MDO3val;	
	char  Btemp1;
	char  Btemp2;
	char  Btemp3;
	char  Btemp4;
	unsigned char  PortAval;
	unsigned char  PortBval;
	unsigned char  PortCval;
	unsigned char  DIPval;
	unsigned char  KB5val;
	char  Atemp;
	unsigned char  HallAlarm;
	unsigned char  Spare[4];
	unsigned char  ChkSum;*/
        $idArr = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        $CI = & get_instance(); 
        $CI->load->driver('cache');
        $dk04List = array();
        foreach ($idArr as $data_id) {
            $dk04Obj = new stdClass();
            $dk04Obj->data_id = $data_id;
            $memData = $CI->cache->get($data_id);
            // memData minimal length
            if (strlen($memData) >= 37) {
                $dk04Obj->isEmpty = false;
                $v = unpack('S*', substr($memData, 0, 9 * 4));
                $dk04Obj->SysV = $v[1];
                $dk04Obj->ILoad = $v[2];
                $dk04Obj->IBat1 = $v[3];
                $dk04Obj->IBat2 = $v[4];
                $dk04Obj->IBat3 = $v[5];
                $dk04Obj->IBat4 = $v[6];
                $dk04Obj->VAcSys = $v[7];
                $dk04Obj->I1AcSys = $v[8];
                $dk04Obj->I2AcSys = $v[9];
                $v = unpack("c*", substr($memData, 9*4, 14));
                $dk04Obj->Btemp1 = $v[4];
                $dk04Obj->Btemp2 = $v[5];
                $dk04Obj->Btemp3 = $v[6];
                $dk04Obj->Btemp4 = $v[7];
                $dk04Obj->Atemp = $v[13];
                $dk04Obj->update_datetime = date('Y-m-d H:i:s');
                
                array_push($dk04List, $dk04Obj);
            }
        }
        return $dk04List;
    }
    
    static function Get_Psm06RtData($dataIdStr)
    {
    	/*		
	struct tele_c_psm6
	{
		 unsigned int data_id;
		 float out_v;//系统输出电压
		 float out_i;//系统负载电流
		 char ac_type;//交流类型00H单相，FFH三相
		 int p_in_v_max_limiting;//输入交流过压电压值
		 int p_in_v_min_limiting;//输入交流低压保护值
		 int output_count;//配电输出总数
		 int output_num[16];//配电输出序号
		 int rc_model_count;//整流模块总数
		 int  rc_model_addrs[20];//整流模块地址
		 char  auto_manual;//模块的控制状态,自动或手动 00H:手动，01H:自动
		 char battery_count;//电池组数ascii
		 int battery_capacity;//电池容量
		 int charge_float_v;//浮充电压
		 int charge_average_v;//均充电压
		 int charge_average_timer;//均充时间间隔（小时）
		 int charge_average_time;//均充时间（小时）
		 int charge_modulus;//充电系数
		 int feeder_resistance;//馈线电阻
		 int charge_limit_i;//电池充电限流值
		 int charge_average_trans_i;//均充转换电流
		 int low_battery_alert_v;//电池欠压报警值
		 int low_battery_protect_v;//电池欠压保护值
		 char low_battery_autoprotect;//电池欠压是否自动保护 00是 01否
		 int dev_addr;//配电监控单元地址（00-99）
		 
		 char  run_status;//正常运行 00H：市电停电电池放电，01H：有市电停电到有点电池充电，02H:市电停电到有电,电池充电
		 char  charge;//浮充/均充 00H：浮充，01H：均充	
		 char  connect_status;//配电通讯状态 00H正常：01H通信中断
		 char  output_status;//系统总输出通讯状态 00H正常：01H通讯中断
		
		 char  fuses_status[9];//直流容断丝
		 char  alert_p[16];//池组1过流预报警（用01H表示）、电池组1过流紧急报警（用02H表示）、电池组1欠压预报警（用04H表示）、电池组1电压过低（用05H表示）、
									//池组2过流预报警（用01H表示）、电池组2过流紧急报警（用02H表示）、电池组2欠压预报警（用04H表示）、电池组2电压过低（用05H表示）、
		 tele_c_ttime update_time;
	};
*/
    	$idArr = array();
    	if (strlen($dataIdStr))
    		$idArr = explode(',', $dataIdStr);
    		$CI = & get_instance();
    		$CI->load->driver('cache');
    		$psm06List = array();
    		foreach ($idArr as $data_id) {
    			$psm06Obj = new stdClass();
    			$psm06Obj->data_id = $data_id;
    			$memData = $CI->cache->get($data_id);
    			// memData minimal length
//echo strlen($memData);
    			if (strlen($memData) >= 223) {
    				$psm06Obj->isEmpty = false;
    				$v = unpack('c', substr($memData, 4, 1));
    				$psm06Obj->ac_type = $v[1];
//echo $psm06Obj->ac_type;
    				$v = unpack('i*', substr($memData, 4 + 1, 40 * 4));
    				$psm06Obj->p_in_v_max_limiting = $v[1];
    				$psm06Obj->p_in_v_min_limiting = $v[2];
    				$psm06Obj->output_count = $v[3];
    				$psm06Obj->output_num = array_values(array_slice($v, 3, 16));
    				$psm06Obj->rc_model_count = $v[20];
    				$psm06Obj->rc_model_addrs = array_values(array_slice($v, 20));	
    				$v = unpack('c*', substr($memData, 4 + 1 + 40 * 4, 2));
    				$psm06Obj->auto_manual= $v[1];
    				$psm06Obj->battery_count= $v[2];
    				$v = unpack('i*', substr($memData, 4 + 1 + 40 * 4 + 2, 11 * 4));
    				$psm06Obj->battery_capacity = $v[1];
    				$psm06Obj->charge_average_v = $v[2];
    				$psm06Obj->charge_float_v = $v[3];
    				$psm06Obj->charge_average_timer = $v[4];
    				$psm06Obj->charge_average_time = $v[5];
    				$psm06Obj->charge_modulus = $v[6];
    				$psm06Obj->feeder_resistance = $v[7];
    				$psm06Obj->charge_limit_i = $v[8];
    				$psm06Obj->charge_average_trans_i = $v[9];
    				$psm06Obj->low_battery_alert_v = $v[10];
    				$psm06Obj->low_battery_protect_v = $v[11];
    				$v = unpack('s', substr($memData, 4 + 1 + 40 * 4 + 2 + 11 * 4,2));
    				$psm06Obj->dev_addr = $v[1];
    				$psm06Obj->update_datetime = date('Y-m-d H:i:s');
    
    				array_push($psm06List, $psm06Obj);
    			}
    		}
    		return $psm06List;
    }
    
    static function _Get_PsmaAcData ($dataId)
    {
        /*
         * //交流
         * typedef struct tele_c_ac_
         * {
         * unsigned int data_id;
         * float ia;
         * float ib;
         * float ic;
         * int channel_count;
         * //status
         * int airlock_count;
         * char airlock_status[8];
         * char ac_switch;//交流切换状态（切换自动或切换手动）
         * char light_switch;//事故照明灯状态（照明关或照明开）
         * char working_line;//当前工作路号（E4H:第一路，E5H:第二路，E6H:第三路，E7H：无工作路号）
         * //alert交流告警数据
         * char ia_alert;
         * char ib_alert;
         * char ic_alert;
         * tele_c_ttime update_time;
         * }tele_c_ac;
         *
         * typedef struct tele_c_ac_channel_
         * {
         * float a;
         * float b;
         * float c;
         * float f;
         * //alert
         * char alert_a;//输入线/相电压AB/A
         * char alert_b;//输入线/相电压BC/B
         * char alert_c;//输入线/相电压CA/C
         * char alert_f;//输入频率
         * char p[8];//按顺序为交流输入空开跳（用05表示故障状态），交流输出空开跳（用05表示故障状态），防雷器断（用05表示故障状态），交流输入1停电（用E1H表示故障状态），
         * 交流输入2停电（用E1H表示故障状态），交流输入3停电（用E1H表示故障状态），市电切换失败（用E3H表示故障状态），交流屏通讯中断（用E2H表示故障状态），以上各量以00H表示正常状态
         * }tele_c_ac_channel;
         */
        $psmaAcObj = new stdClass();
        $psmaAcObj->data_id = $dataId;
        $CI = & get_instance();
        $CI->load->driver('cache');
        $memData = $CI->cache->get($dataId);
        // memData minimal length
        if (strlen($memData) >= 45) {
            $psmaAcObj->isEmpty = false;
            $v = unpack('f*', substr($memData, 4, 3 * 4));
            $psmaAcObj->ia = number_format($v[1], 2);
            $psmaAcObj->ib = number_format($v[2], 2);
        
            $psmaAcObj->ic = number_format($v[3], 2);
            $v = unpack('i', substr($memData, 4 + 3 * 4, 4));
            $psmaAcObj->channelCount = $v[1];
            $psmaAcObj->channelList = array();
            // total length
            if (strlen($memData) == 45 + $psmaAcObj->channelCount * 28) {
                for ($i = 0; $i < $psmaAcObj->channelCount; $i ++) {
                    $channelObj = new stdClass();
                    $channelData = substr($memData, 45 + $i * 28, 28);
                    $v = unpack('f*', substr($channelData, 0, 4 * 4));
                    $channelObj->a = number_format($v[1], 2);
                    $channelObj->b = number_format($v[2], 2);
                    $channelObj->c = number_format($v[3], 2);
                    $channelObj->f = number_format($v[4], 2);
                    $v = unpack('c*', substr($channelData, 4 * 4, 12));
                    $channelObj->alert_a = $v[1];
                    $channelObj->alert_b = $v[2];
                    $channelObj->alert_c = $v[3];
                    $channelObj->alert_f = $v[4];
                    $channelObj->p = array_values(array_slice($v, 4));
                    array_push($psmaAcObj->channelList, $channelObj);
                }
            }
            
            $v = unpack('i', substr($memData, 4 + 3 * 4 + 4, 4));
            $psmaAcObj->airlock_count = $v[1];
            
            $v = unpack('c*', substr($memData, 4 + 3 * 4 + 4 + 4, 8));
            $psmaAcObj->airlock_status = array_values($v);
            
            $v = unpack('c*', substr($memData, 4 + 3 * 4 + 4 + 4 + 8, 6));
            $psmaAcObj->ac_switch = $v[1];
            $psmaAcObj->light_switch = $v[2];
            $psmaAcObj->working_line = $v[3];
            $psmaAcObj->ia_alert = $v[4];
            $psmaAcObj->ib_alert = $v[5];
            $psmaAcObj->ic_alert = $v[6];
            $v = unpack('v', substr($memData, 4 + 3 * 4 + 4 + 4 + 8 + 6, 2));
            $year = $v[1];
            $v = unpack('C*', substr($memData, 4 + 3 * 4 + 4 + 4 + 8 + 6 + 2, 5));
            $psmaAcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
        } else {
            $psmaAcObj->isEmpty = true;
            $psmaAcObj->update_datetime = date('Y-m-d H:i:s');
        }
        $psmaAcObj->dynamic_config = $CI->cache->get($psmaAcObj->data_id . '_dc');
        return $psmaAcObj;
    }

    static function _Get_PsmaRcData ($dataId)
    {
        /*
         * //整流
         * typedef struct tele_c_rc_
         * {
         * unsigned int data_id;
         * float out_v;
         * int channel_count;
         * tele_c_ttime update_time;
         * }tele_c_rc;
         *
         * typedef struct tele_c_rc_channel_
         * {
         * float out_i;
         * float p_temperature;//模块温度
         * float p_limiting;//模块限流点（百分数）
         * float p_out_v;//模块输出电压
         * float p_out_v_limiting;//输出电压保护点
         * //status状态量
         * char shutdown;//开机/关机状态
         * char i_limit;//限流/不限流状态
         * char charge;//浮充/均充/测试状态
         * char auto_manual;//模块的控制状态,自动或手动
         * //alert告警量
         * char fault;
         * char p[4];//模块保护（用01H表示故障），风扇故障（用01H表示故障），模块过温（用01H表示故障），模块通讯中断（用E2H表示故障）
         * }tele_c_rc_channel;
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $psmaRcObj = new stdClass();
        $psmaRcObj->data_id = $dataId;
        $memData = $CI->cache->get($dataId);
        // minimain length
        if (strlen($memData) >= 19) {
            $psmaRcObj->isEmpty = false;
            $v = unpack('f', substr($memData, 4, 4));
            $psmaRcObj->out_v = number_format($v[1], 2);
            $v = unpack('f', substr($memData, 4 + 4, 4));
            $psmaRcObj->channelCount = $v[1];
            $psmaRcObj->channelList = array();
            if (strlen($memData) == 19 + 29 * $psmaRcObj->channelCount) {
                for ($i = 0; $i < $psmaRcObj->channelCount; $i ++) {
                    $channelObj = new stdClass();
                    $channelStr = substr($memData, 19 + 29 * $i, 29);
                    $v = unpack('f*', substr($channelStr, 0, 4 * 5));
                    $channelObj->out_i = number_format($v[1], 2);
                    $channelObj->p_temperature = number_format($v[2], 2);
                    $channelObj->p_limiting = number_format($v[3], 2);
                    $channelObj->p_out_v = number_format($v[4], 2);
                    $channelObj->p_out_v_limiting = number_format($v[5], 2);
                    $v = unpack('c*', substr($channelStr, 4 * 5, 9));
                    $channelObj->shutdown = $v[1];
                    $channelObj->i_limit = $v[2];
                    $channelObj->charge = $v[3];
                    $channelObj->auto_manual = $v[4];
                    $channelObj->fault = $v[5];
                    $channelObj->p = array_values(array_slice($v, 5));
                    array_push($psmaRcObj->channelList, $channelObj);
                }
            }
            $v = unpack('v', substr($memData, 4 + 4 + 4, 2));
            $year = $v[1];
            $v = unpack('C*', substr($memData, 4 + 4 + 4 + 2, 5));
            $psmaRcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
        } else {
            $psmaRcObj->isEmpty = true;
            $psmaRcObj->update_datetime = date('Y-m-d H:i:s');
        }
        $psmaRcObj->dynamic_config = $CI->cache->get($psmaRcObj->data_id . '_dc');
        
        return $psmaRcObj;
    }

    static function _Get_PsmaDcData ($dataId)
    {
        // 直流
        /*
         * typedef struct tele_c_dc_
         * {
         * unsigned int data_id;
         * float v;//直流输出电压
         * float i;//总负载电流
         * int m;//蓄电池组数m,m<2
         * float dc_i[2];//
         * int n;//监测直流分路电流数N<6
         * float channel[6];
         * int p_count;
         * float p[5];//当m=2,n=1时，按顺序依次为电池组1电压、电池组2电压、电池房温度。
         * 当m=2,n=2时，按顺序依次为电池组1电压、电池组2电压、电池房温度、测点1温度。当m=2,n=3时，按顺序依次为电池组1电压、电池组2电压、电池房温度、测点1温度、测点2温度。当m=1或m=0时，情况类推。
         * //alert
         * char alert_v;//直流电压
         * char alert_m_number;//直流容断丝数量
         * char alert_m[64];//直流容断丝
         * char alert_p[13];//池组1熔丝断（用03H表示）、电池组2熔丝断（用03H表示）、电池组1充电过流（用02H表示）、电池组2充电过流（用02H表示）、电池组1保护（用E4H表示）、
         * 电池组2保护（用E4H表示）、二次下电（用E3H表示）、电池房过温（用E1表示）、测点1过温（用E1表示）、测点2过温（用E1表示）、直流屏通讯中断（用E2H表示）、
         * 电池组1电压异常（01H：欠压，02H：过压）、电池组2电压异常（01H：欠压，02H：过压）以上各量以00H表示正常。
         * tele_c_ttime update_time;
         * }tele_c_dc;
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        
        $psmaDcObj = new stdClass();
        $psmaDcObj->data_id = $dataId;
       $memData = $CI->cache->get($dataId);      
        if (strlen($memData) == 162) {
            $psmaDcObj->isEmpty = false;
            $v = unpack('f*', substr($memData, 4, 4 * 2));
            $psmaDcObj->v = number_format($v[1], 2);
            $psmaDcObj->i = number_format($v[2], 2);
            $v = unpack('i', substr($memData, 4 + 4 * 2, 4));
            $psmaDcObj->m = $v[1];
            $v = unpack('f*', substr($memData, 4 + 4 * 2 + 4, 2 * 4));
            $psmaDcObj->dc_i = array();
            array_push($psmaDcObj->dc_i, number_format($v[1], 2));
            array_push($psmaDcObj->dc_i, number_format($v[2], 2));
            $v = unpack('i', substr($memData, 4 + 4 * 2 + 4 + 2 * 4, 4));
            $psmaDcObj->n = $v[1];
            $v = unpack('f*', substr($memData, 4 + 4 * 2 + 4 + 2 * 4 + 4, 4 * 6));
            $psmaDcObj->channelList = array();
            foreach ($v as $key => $val) {
                array_push($psmaDcObj->channelList, number_format($val, 2));
            }
            $v = unpack('i', substr($memData, 4 + 4 * 2 + 4 + 2 * 4 + 4 + 4 * 6, 4));
            $psmaDcObj->p_count = $v[1];
            $psmaDcObj->p = array();
            $v = unpack('f*', substr($memData, 4 + 4 * 2 + 4 + 2 * 4 + 4 + 4 * 6 + 4, 5 * 4));
            foreach ($v as $key => $val) {
                array_push($psmaDcObj->p, number_format($val, 2));
            }
            $v = unpack('c*', substr($memData, 4 + 4 * 2 + 4 + 2 * 4 + 4 + 4 * 6 + 4 + 5 * 4, 79));
            $psmaDcObj->alert_v = $v[1];
            $psmaDcObj->alert_m_number = $v[2];
            $psmaDcObj->alert_m = array_values(array_slice($v, 2, 64));
            $psmaDcObj->alert_p = array_values(array_slice($v, 2 + 64, 13));
            $v = unpack('v', substr($memData, 4 + 4 * 2 + 4 + 2 * 4 + 4 + 4 * 6 + 4 + 5 * 4 + 79, 2));
            $year = $v[1];
            $v = unpack('C*', substr($memData, 4 + 4 * 2 + 4 + 2 * 4 + 4 + 4 * 6 + 4 + 5 * 4 + 79 + 2, 5));
            $psmaDcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
        } else {
            $psmaDcObj->isEmpty = true;
            $psmaDcObj->update_datetime = date('Y-m-d H:i:s');
        }
        $psmaDcObj->dynamic_config = $CI->cache->get($psmaDcObj->data_id . '_dc');
        return $psmaDcObj;
    }

    static function _Get_M810gAcData ($dataId)
    {
        /*
         * struct tele_c_m810g_ac
         * {
         * unsigned int data_id;
         * float ia;
         * float ib;
         * float ic;
         * int channel_count;
         * //status
         * int airlock_count;
         * char airlock_status[8];
         * char ac_switch;//交流切换状态（切换自动或切换手动）
         * char light_switch;//事故照明灯状态（照明关或照明开）
         * char working_line;//当前工作路号（E4H:第一路，E5H:第二路，E6H:第三路，E7H：无工作路号）
         * //alert交流告警数据
         * char ia_alert;
         * char ib_alert;
         * char ic_alert;
         * tele_c_ttime update_time;
         * };
         *
         * struct tele_c_m810g_ac_channel
         * {
         * float a;
         * float b;
         * float c;
         * float f;
         * //alert
         * char alert_a;//输入线/相电压AB/A
         * char alert_b;//输入线/相电压BC/B
         * char alert_c;//输入线/相电压CA/C
         * char alert_f;//频率
         * char
         * p[7];//按顺序为交流输入空开跳（用05表示故障状态），交流输出空开跳（用05表示故障状态），防雷器断（用05表示故障状态），交流输入1停电（用E1H表示故障状态），交流输入2停电（用E1H表示故障状态），交流输入3停电（用E1H表示故障状态），交流屏通讯中断（用E2H表示故障状态）。以上各量以00H表示正常状态
         * };
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $m810gAcObj = new stdClass();
        $m810gAcObj->data_id = $dataId;
        $memData = $CI->cache->get($dataId);
        // memData minimal length
        if (strlen($memData) >= 45) {
            $m810gAcObj->isEmpty = false;
            $v = unpack('f*', substr($memData, 4, 3 * 4));
            $m810gAcObj->ia = number_format($v[1], 2);
            $m810gAcObj->ib = number_format($v[2], 2);
            $m810gAcObj->ic = number_format($v[3], 2);
            $v = unpack('i', substr($memData, 4 + 3 * 4, 4));
            $m810gAcObj->channelCount = $v[1];
            $m810gAcObj->channelList = array();
            // total length
            if (strlen($memData) == 45 + $m810gAcObj->channelCount * 27) {
                for ($i = 0; $i < $m810gAcObj->channelCount; $i ++) {
                    $channelObj = new stdClass();
                    $channelData = substr($memData, 45 + $i * 27, 27);
                    $v = unpack('f*', substr($channelData, 0, 4 * 4));
                    $channelObj->a = number_format($v[1], 2);
                    $channelObj->b = number_format($v[2], 2);
                    $channelObj->c = number_format($v[3], 2);
                    $channelObj->f = number_format($v[4], 2);
                    $v = unpack('c*', substr($channelData, 4 * 4, 12));
                    $channelObj->alert_a = $v[1];
                    $channelObj->alert_b = $v[2];
                    $channelObj->alert_c = $v[3];
                    $channelObj->alert_f = $v[4];
                    $channelObj->p = array_values(array_slice($v, 4));
                    array_push($m810gAcObj->channelList, $channelObj);
                }
            }
            
            $v = unpack('i', substr($memData, 4 + 3 * 4 + 4, 4));
            $m810gAcObj->airlock_count = $v[1];
            
            $v = unpack('c*', substr($memData, 4 + 3 * 4 + 4 + 4, 8));
            $m810gAcObj->airlock_status = array_values($v);
            
            $v = unpack('c*', substr($memData, 4 + 3 * 4 + 4 + 4 + 8, 6));
            $m810gAcObj->ac_switch = $v[1];
            $m810gAcObj->light_switch = $v[2];
            $m810gAcObj->working_line = $v[3];
            $m810gAcObj->ia_alert = $v[4];
            $m810gAcObj->ib_alert = $v[5];
            $m810gAcObj->ic_alert = $v[6];
            $v = unpack('v', substr($memData, 4 + 3 * 4 + 4 + 4 + 8 + 6, 2));
            $year = $v[1];
            $v = unpack('C*', substr($memData, 4 + 3 * 4 + 4 + 4 + 8 + 6 + 2, 5));
            $m810gAcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
        } else {
            $m810gAcObj->isEmpty = true;
            $m810gAcObj->update_datetime = date('Y-m-d H:i:s');
        }
        
        $m810gAcObj->dynamic_config = $CI->cache->get($m810gAcObj->data_id . '_dc');
        return $m810gAcObj;
    }

     static function Get_ACCESScache($dataid){      	
      	    $CI=& get_instance();
      	      $CI->load->driver('cache');
      	      $cache=$CI->cache->get($dataid);
      	      return $cache;
      }
      static function Get_zxduRCcache($dataId){
      /*
         * //整流
         * typedef struct tele_c_rc_
         * {
         * unsigned int data_id;
         * float out_v;
         * int channel_count;
         * tele_c_ttime update_time;
         * }tele_c_rc;
         *
         * typedef struct tele_c_rc_channel_
         * {
         * float out_i;
         * float out_wrong;//整流模块输出异常
  
         * //status状态量
         * char shutdown;//开机/关机状态
         * char i_limit;//限流/不限流状态
         * char charge;//浮充/均充/测试状态
         * char status_p;//模块的控制状态,自动或手动
         * //alert告警量
         * char fault;
         * char p[4];//模块保护（用01H表示故障），风扇故障（用01H表示故障），模块过温（用01H表示故障），模块通讯中断（用E2H表示故障）
         * }tele_c_rc_channel;
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $psmaRcObj = new stdClass();
        $psmaRcObj->data_id = $dataId;
        $memData = $CI->cache->get($dataId);
        // minimain length
        if (strlen($memData) >= 19) {
            $zxduRcObj->isEmpty = false;
            $v = unpack('f', substr($memData, 4, 4));
            $zxduRcObj->out_v = number_format($v[1], 2);
            $v = unpack('f', substr($memData, 4 + 4, 4));
            $zxduRcObj->channelCount = $v[1];
            $zxduRcObj->channelList = array();
            if (strlen($memData) == 19 + $zxduRcObj->channelCount * 17) {
                for ($i = 0; $i < $zxduRcObj->channelCount; $i ++) {
                    $channelObj = new stdClass();
                    $channelStr = substr($memData, 19 + 17 * $i, 17);
                    $v = unpack('f*', substr($channelStr, 0, 4 * 2));
                    $channelObj->out_i = number_format($v[1], 2);
                    $channelObj->out_wrong = number_format($v[2], 2);
                    $v = unpack('c*', substr($channelStr, 4 * 2, 9));
                    $channelObj->shutdown = $v[1];
                    $channelObj->i_limit = $v[2];
                    $channelObj->charge = $v[3];
                    $channelObj->status_p = $v[4];
                    $channelObj->fault = $v[5];
                    $channelObj->p = array_values(array_slice($v, 5));
                    array_push($zxduRcObj->channelList, $channelObj);
                }
            }
            $v = unpack('v', substr($memData, 4 + 4 + 4, 2));
            $year = $v[1];
            $v = unpack('C*', substr($memData, 4 + 4 + 4 + 2, 5));
            $zxduRcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
        } else {
            $zxduRcObj->isEmpty = true;
            $zxduRcObj->update_datetime = date('Y-m-d H:i:s');
        }
        $zxduRcObj->dynamic_config = $CI->cache->get($zxduRcObj->data_id . '_dc');
        
        return $zxduRcObj;
      }
      static function Get_zxduDCcache($dataId){
       /*
         * struct tele_c_zxdu_dc
         * {
         * unsigned int data_id;
	int dc_m; //直流屏数量M(1字节) ＝ 1
	float v;//直流输出电压
	float i;//总负载电流
	int   m;//蓄电池组数m,m<4
	float dc_i[4];//
	int   n;//监测直流分路电流数N<9
	float channel[9];
	int   p_count;
	float p[12];//按顺序依次为用户自定义（电池1 温度）用户自定义（电池1 电压） 用户自定义（电池1实时容量百分比）
	char test; //有无测试报告
	tele_c_ttime test_end; //测试节数时间
	int duration; //测试持续时间
	float quality; //电池放电容量
	//status
	char status_num; //状态数量
	char eps_status; //应急照明状态
	char charge_discharge; //充放电状态
	char stem_in; //输入干结点数量
	char stem_m[4]; //依次为干结点1,干结点2,干结点3,干结点4
	char work_mode;  //工作模式
	char stem_func; //输出干结点功能 00H：自动控制，01H手动控制
	char stem_out; //输出干结点数量
	char stem_o[8]; //依次为输出干结点1-8
	//alert
	char  alert_v;//直流电压
	char  alert_m_number;//直流容断丝数量
	char  alert_m[15];//直流输出
	char  alert_p[27];//依次为：（一次下电），（二次下电）,（电池1 回路断 ）,（电池1 电压低）,（电池1 温度高）,（电池1 温度低）,（电池1 温度无效）,（电池2 回路断 ）,（电池2 电压低）,（电池2 温度高）,（电池2 温度低）,（电池2 温度无效）,（电池3 回路断 ）,（电池3电压低）,（电池3 温度高）,（电池3 温度低）,（电池3 温度无效）,（电池4 回路断 ）,（电池4 电压低）,（电池4 温度高）,（电池4 温度低）,（电池4 温度无效）,（直流避雷器异常）,（负载断路器1异常）,（负载断路器2异常）,（蓄电池故障）,（电池放电告警）
//			　　　告警字节描述：
//　　　					00H：正常          	    01H：低于下限			02H：高于上限
//　　　					03H：熔丝断				04H：开关断开
//　　　　				E1H：防雷器坏/空开断
//　　　					F0H：一次下电			F1H：二次下电           F2H：负载断路器异常
//　　　					F3H：蓄电池故障
//　　　					F4H：电池放电告警
//　　　					F5H：温度无效
	

	//parameter
	float out_v_high; //输出电压上限
	float out_v_low; //输出电压下限
	int param_num; //用户自定义参数个数
	float param[32]; //依次为：用户自定义参数数量p =32，浮充电压值(V)，均充电压值(V)，测试电压值(V)，电池欠压值(V)，一次下电电压(V)，二次下电电压(V)，电池限电流(A/Ah)，均充周期(天)，温度补偿系数(V/℃)，电池过温值(℃)，电池1容量(Ah)，电池2容量(Ah)，电池3容量(Ah)，电池4容量(Ah)，均充最长时间(H)，均充最短时间(H)，均充维持时间(H)，均充阈值容量(C)，均充阈值电压(V)，均充末期电流率(A/Ah)，自动测试周期(天)，测试最长时间(H)，测试启动时刻，启调电压偏差(V)，轮换周期(天)，电池检测时间(M)，非节能延时时间(H)，电池检测周期(天)，最小开机数，限流温补系数，电池放电阈值，电池温度低阈值
	
	float get_channel(int index){ if(index >=0 && index < 9){ return channel[index];}else{return 0;}}
	float get_p(int index){ if(index >=0 && index < 12){ return p[index];}else{return 0;}}
	float get_alert_m(int index){ if(index >=0 && index < 15){ return alert_m[index];}else{return 0;}}
	float get_alert_p(int index){ if(index >=0 && index < 27){ return alert_p[index];}else{return 0;}}
	tele_c_ttime update_time;
         * };
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        
        $zxduDcObj = new stdClass();
        $zxduDcObj->data_id = $dataId;
        $memData = $CI->cache->get($dataId);
        if (strlen($memData) >= 179) {
            $zxduDcObj->isEmpty = false;
            $v = unpack('i', substr($memData, 4, 4));
            $zxduDcObj->dc_m = $v[1];
            $v = unpack('f*', substr($memData, 4 + 4, 4 * 2));
            $zxduDcObj->v = number_format($v[1], 2);
            $zxduDcObj->i = number_format($v[2], 2);
            $v = unpack('i', substr($memData, 4 + 4 + 4 * 2, 4));
            $zxduDcObj->m = $v[1];
            $v = unpack('f*', substr($memData,4 + 4 + 4 * 2 + 4, 4 * 4));
            $zxduDcObj->dc_i = array();
            array_push($zxduDcObj->dc_i, number_format($v[1], 2));
            array_push($zxduDcObj->dc_i, number_format($v[2], 2));
            array_push($zxduDcObj->dc_i, number_format($v[3], 2));
            array_push($zxduDcObj->dc_i, number_format($v[4], 2));
            $v = unpack('i', substr($memData, 4 + 4 + 4 * 2 + 4 + 4 * 4, 4));
            $zxduDcObj->n = $v[1];
            $v = unpack('f*', substr($memData,4 + 4 + 4 * 2 + 4 + 4 * 4 + 4, 4 * 9));
            $zxduDcObj->channel = array();
            foreach ($v as $key => $val) {
                array_push($zxduDcObj->channel, number_format($val, 2));
            }
            $v = unpack('i', substr($memData, 4 + 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4, 4));
            $zxduDcObj->p_count = $v[1];
            $zxduDcObj->p = array();
            $v = unpack('f*', substr($memData,4 + 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4, 4 * 14));
            foreach ($v as $key => $val) {
                array_push($zxduDcObj->p, number_format($val, 2));
            }
            $v = unpack('c*', substr($memData,4 + 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 14 * 4, 44));
            $zxduDcObj->alert_v = $v[1];
            $zxduDcObj->alert_m_number = $v[2];
            $zxduDcObj->alert_m = array_values(array_slice($v, 2, 15));
            $zxduDcObj->alert_p = array_values(array_slice($v, 2 + 15, 27));
            $v = unpack('v', substr($memData, 4 + 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 + 4 + 4 + 14 * 4 + 44, 2));
            $year = $v[1];
            $v = unpack('C*', substr($memData,4 + 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 + 4 + 4 + 14 * 4 + 44 + 2, 5));
            $zxduDcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
        } else {
            $zxduDcObj->isEmpty = true;
            $zxduDcObj->update_datetime = date('Y-m-d H:i:s');
        }
        $zxduDcObj->dynamic_config = $CI->cache->get($zxduDcObj->data_id . '_dc');
        return $zxduDcObj;
      }
     static function Get_zxduACcache($dataId){
     	  /*
         struct tele_c_zxdu_ac
{
	unsigned int data_id;
	float ia; //交流屏输出电流L1
	float ib;  //交流屏输出电流L2
	float ic;	//交流屏输出电流L3
	int channel_count; //交流配电数量
	//status
	int airlock_count; //开关数量
	int status_p; //用户自定义状态数量P=4
	char airlock_status[4]; //自定义状态数量 依次为：自定义字节 （交流输入空开1断），自定义字节 （交流输入空开2断），自定义字节 （交流辅助输出开关断），自定义字节（交流供电方式）
	//alert交流告警数据
	char ia_alert; //输出电流L1
	char ib_alert;//输出电流L2
	char ic_alert;//输出电流L3
	GET_AC_CHANNEL_FIELD(float,va)
	GET_AC_CHANNEL_FIELD(float,vb)
	GET_AC_CHANNEL_FIELD(float,vc)
	GET_AC_CHANNEL_FIELD(float,f)
	GET_AC_CHANNEL_FIELD(char,alert_a)
	GET_AC_CHANNEL_FIELD(char,alert_b)
	GET_AC_CHANNEL_FIELD(char,alert_c)
	GET_AC_CHANNEL_FIELD(char,alert_f)
	char get_ac_channel_p(int index, int offset)
	{
		if(index >= 0 && index < channel_count && offset >=0 && offset < 4)
		{
			return channels[index].am[offset];
		}
		return 0;
	}
	
	tele_c_ttime update_time;
	tele_c_zxdu_ac_channel channels[0];
};
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $acObj = new stdClass();
        $acObj->data_id = $dataId;
        $memData = $CI->cache->get($dataId);
        // memData minimal length
        if (strlen($memData) >= 42) {//74
            $zxduAcObj->isEmpty = false;
            $v = unpack('f*', substr($memData, 4, 3 * 4));
            $zxduAcObj->ia = number_format($v[1], 2);
            $zxduAcObj->ib = number_format($v[2], 2);
            $zxduAcObj->ic = number_format($v[3], 2);
            $v = unpack('i', substr($memData, 4 + 3 * 4, 4));
            $zxduAcObj->channelCount = $v[1];
            $zxduAcObj->channelList = array();
            // total length
            if (strlen($memData) == 42 + $zxduAcObj->channelCount * 33) {
                for ($i = 0; $i < $zxduAcObj->channelCount; $i ++) {
                    $channelObj = new stdClass();
                    $channelData = substr($memData, 42 + $i * 32, 32);
                    $v = unpack('f*', substr($channelData, 0, 4 * 4));
                    $channelObj->va = number_format($v[1], 2);
                    $channelObj->vb = number_format($v[2], 2);
                    $channelObj->vc = number_format($v[3], 2);
                    $channelObj->f = number_format($v[4], 2);
                    $v = unpack('c*', substr($channelData, 4 * 4, 4));
                    $channelObj->alert_a = $v[1];
                    $channelObj->alert_b = $v[2];
                    $channelObj->alert_c = $v[3];
                    $channelObj->alert_f = $v[4];
                    $v = unpack('i*', substr($channelData, 4 * 4 + 4, 4 * 2));
                    $channelObj->m = $v[1];
                    $channelObj->alert_m = $v[2];
                    $v = unpack('c*', substr($channelData, 4 * 4 + 4 + 4 * 2, 5));
                    $channelObj->am = array_values($v);
                    array_push($zxduAcObj->channelList, $channelObj);
                }
            }
            
            $v = unpack('i', substr($memData, 4 + 3 * 4 + 4, 4));
            $zxduAcObj->airlock_count = $v[1];
 
            $v = unpack('i', substr($memData, 4 + 3 * 4 + 4 + 4, 4));
            $zxduAcObj->status_p= $v[1];
            
            $v = unpack('c*', substr($memData,4 + 3 * 4 + 4 + 4 + 4, 4));
            $zxduAcObj->airlock_status = array_values($v);
            
            $v = unpack('c*', substr($memData,4 + 3 * 4 + 4 + 4 + 4 + 4, 3));
            $zxduAcObj->ia_alert = $v[1];
            $zxduAcObj->ib_alert = $v[2];
            $zxduAcObj->ic_alert = $v[3];
            $v = unpack('v', substr($memData, 4 + 3 * 4 + 4 + 4 + 4 + 3, 2));
            $year = $v[1];
            $v = unpack('C*', substr($memData, 4 + 3 * 4 + 4 + 4 + 4 + 3 + 2, 5));
            $zxduAcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
        } else {
            $zxduAcObj->isEmpty = true;
            $zxduAcObj->update_datetime = date('Y-m-d H:i:s');
        }
        
        $zxduAcObj->dynamic_config = $CI->cache->get($zxduAcObj->data_id . '_dc');
        return $zxduAcObj;
     }
    static function _Get_M810gRcData ($dataId)
    {
        /*
         * //整流
         * typedef struct tele_c_rc_
         * {
         * unsigned int data_id;
         * float out_v;
         * int channel_count;
         * tele_c_ttime update_time;
         * }tele_c_rc;
         *
         * typedef struct tele_c_rc_channel_
         * {
         * float out_i;
         * float p_temperature;//模块温度
         * float p_limiting;//模块限流点（百分数）
         * float p_out_v;//模块输出电压
         * float p_ab_v//交流AB线电压
         * float p_bc_v;//交流BC线相电压
         * float p_ca_v;//交流CA线相电压
         * float p_no;//模块位置号
         * //status状态量
         * char shutdown;//开机/关机状态
         * char i_limit;//限流/不限流状态
         * char charge;//浮充/均充/测试状态
         * char status_p[5];//模块的交流限功率，温度限功率，风扇全速，WALK-In，过压脱离
         * //alert告警量
         * char fault;
         * char p[7];//模块保护（用01H表示故障），风扇故障（用01H表示故障），模块过温（用01H表示故障），模块通讯中断（用E2H表示故障）
         * }tele_c_rc_channel;
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        
        $m810gRcObj = new stdClass();
        $m810gRcObj->data_id = $dataId;
        $memData = $CI->cache->get($dataId);
        // minimain length
        if (strlen($memData) >= 19) {
            $m810gRcObj->isEmpty = false;
            $v = unpack('f', substr($memData, 4, 4));
            $m810gRcObj->out_v = number_format($v[1], 2);
            $v = unpack('f', substr($memData, 4 + 4, 4));
            $m810gRcObj->channelCount = $v[1];
            $m810gRcObj->channelList = array();
            if (strlen($memData) == 19 + 48 * $m810gRcObj->channelCount) {
                for ($i = 0; $i < $m810gRcObj->channelCount; $i ++) {
                    $channelObj = new stdClass();
                    $channelStr = substr($memData, 19 + 48 * $i, 48);
                    $v = unpack('f*', substr($channelStr, 0, 4 * 8));
                    $channelObj->out_i = number_format($v[1], 2);
                    $channelObj->p_temperature = number_format($v[2], 2);
                    $channelObj->p_limiting = number_format($v[3], 2);
                    $channelObj->p_out_v = number_format($v[4], 2);
                    $channelObj->p_ab_v = number_format($v[5], 2);
                    $channelObj->p_bc_v = number_format($v[6], 2);
                    $channelObj->p_ca_v = number_format($v[7], 2);
                    $channelObj->p_no = number_format($v[8], 2);
                    $v = unpack('c*', substr($channelStr, 4 * 8, 16));
                    $channelObj->shutdown = $v[1];
                    $channelObj->i_limit = $v[2];
                    $channelObj->charge = $v[3];
                    $channelObj->status_p = array_values(array_slice($v, 3, 5));
                    $channelObj->fault = $v[8];
                    $channelObj->p = array_values(array_slice($v, 9));
                    array_push($m810gRcObj->channelList, $channelObj);
                }
            }
            $v = unpack('v', substr($memData, 4 + 4 + 4, 2));
            $year = $v[1];
            $v = unpack('C*', substr($memData, 4 + 4 + 4 + 2, 5));
            $m810gRcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
        } else {
            $m810gRcObj->isEmpty = true;
            $m810gRcObj->update_datetime = date('Y-m-d H:i:s');
        }
        $m810gRcObj->dynamic_config = $CI->cache->get($m810gRcObj->data_id . '_dc');
        
        return $m810gRcObj;
    }

    static function _Get_M810gDcData ($dataId)
    {
        /*
         * struct tele_c_m810g_dc
         * {
         * unsigned int data_id;
         * float v;//直流输出电压
         * float i;//总负载电流
         * int m;//蓄电池组数m,m<4
         * float dc_i[4];//
         * int n;//监测直流分路电流数N<9
         * float channel[9];
         * int p_count;
         * float p[11];//按顺序依次为温度1、温度2、温度3（由温度采集配置确定）、电池组1电压、电池组1实际容量百分比、电池组2电压、
         * 电池组2实际容量百分比、电池组3电压、电池组3实际容量百分比、电池组4电压、电池组4实际容量百分比
         * //alert
         * char alert_v;//直流电压
         * char alert_m_number;//直流容断丝数量
         * char alert_m[64];//直流容断丝
         * char alert_p[17];//按顺序依次为：
         * LVD1状态、LVD2状态、温度1告警状态、温度2告警状态、温度3告警状态、直流屏通讯中断（用E2H表示）、温度1传感器故障（用06H表示）、温度2传感器故障（用06H表示）、温度3传感器故障（用06H表示）、
         * 电池组1熔丝断（用03H表示）、电池组1充电过流（用02H表示）、电池组2熔丝断（用03H表示）、电池组2充电过流（用02H表示）、电池组3熔丝断（用03H表示）、电池组3充电过流（用02H表示）、
         * 电池组4熔丝断（用03H表示）、电池组4充电过流（用02H表示）。以上各量以00H表示正常。
         * tele_c_ttime update_time;
         * };
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        
        $m810gDcObj = new stdClass();
        $m810gDcObj->data_id = $dataId;
        $memData = $CI->cache->get($dataId);
        if (strlen($memData) == 210) {
            $m810gDcObj->isEmpty = false;
            $v = unpack('f*', substr($memData, 4, 4 * 2));
            $m810gDcObj->v = number_format($v[1], 2);
            $m810gDcObj->i = number_format($v[2], 2);
            $v = unpack('i', substr($memData, 4 + 4 * 2, 4));
            $m810gDcObj->m = $v[1];
            $v = unpack('f*', substr($memData, 4 + 4 * 2 + 4, 4 * 4));
            $m810gDcObj->dc_i = array();
            array_push($m810gDcObj->dc_i, number_format($v[1], 2));
            array_push($m810gDcObj->dc_i, number_format($v[2], 2));
            array_push($m810gDcObj->dc_i, number_format($v[3], 2));
            array_push($m810gDcObj->dc_i, number_format($v[4], 2));
            $v = unpack('i', substr($memData, 4 + 4 * 2 + 4 + 4 * 4, 4));
            $m810gDcObj->n = $v[1];
            $v = unpack('f*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4, 9 * 6));
            $m810gDcObj->channelList = array();
            foreach ($v as $key => $val) {
                array_push($m810gDcObj->channelList, number_format($val, 2));
            }
            $v = unpack('i', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4, 4));
            $m810gDcObj->p_count = $v[1];
            $m810gDcObj->p = array();
            $v = unpack('f*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4, 11 * 4));
            foreach ($v as $key => $val) {
                array_push($m810gDcObj->p, number_format($val, 2));
            }
            $v = unpack('c*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 11 * 4, 83));
            $m810gDcObj->alert_v = $v[1];
            $m810gDcObj->alert_m_number = $v[2];
            $m810gDcObj->alert_m = array_values(array_slice($v, 2, 64));
            $m810gDcObj->alert_p = array_values(array_slice($v, 2 + 64, 17));
            $v = unpack('v', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 11 * 4 + 83, 2));
            $year = $v[1];
            $v = unpack('C*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 11 * 4 + 83 + 2, 5));
            $m810gDcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
        } else {
            $m810gDcObj->isEmpty = true;
            $m810gDcObj->update_datetime = date('Y-m-d H:i:s');
        }
        $m810gDcObj->dynamic_config = $CI->cache->get($m810gDcObj->data_id . '_dc');
        return $m810gDcObj;
    }

    
    static function _Get_Smu06cAcData ($dataId)
    {
    	/*
		 //交流
		struct tele_c_smu06c_ac
		{
			unsigned int data_id;
			int channel_count; //交流配电数量
			//status
			char ac_switch;//交流切换状态（切换自动或切换手动）
			int airlock_count; //开关数量
			int p; //用户自定义状态数量P
			char airlock_status[4]; //自定义状态数量 依次为：自定义字节 （交流输入空开1断），自定义字节 （交流输入空开2断），自定义字节 （交流辅助输出开关断），自定义字节（交流供电方式）
			//alert交流告警数据
		};
		//smu06c related functions
		struct tele_c_smu06c_ac_channel
		{
			float va; //输入相电压/ L1
			float vb;//输入相电压/ L2
			float vc;//输入相电压/ L3
			float f;  //交流输入频率
			//alert
			char alert_a;//输入线/相电压AB/A
			char alert_b;//输入线/相电压BC/B
			char alert_c;//输入线/相电压CA/C
			char alert_f;//输入频率
			int m; //监测熔丝/开关数量L ＝0
			int p; //用户自定义数量
			char am[4];//用户自定义（交流主空开断）,用户自定义（交流停电）,用户自定义（交流避雷器异常 ）,自定义字节 （交流辅助输出断）
			char alert_mp[2];//1:防雷器丝告警2:第一路交流输入停电告警
		};
    	 */
    	$CI = & get_instance();
    	$CI->load->driver('cache');
    	$smu06cAcObj = new stdClass();
    	$smu06cAcObj->data_id = $dataId;
    	$memData = $CI->cache->get($dataId);
    	// memData minimal length
    	if (strlen($memData) >= 43) {
    		$smu06cAcObj->isEmpty = false;
    		$v = unpack('f*', substr($memData, 4, 3 * 4));
    		$smu06cAcObj->ia = number_format($v[1], 2);
    		$smu06cAcObj->ib = number_format($v[2], 2);
    		$smu06cAcObj->ic = number_format($v[3], 2);
    		$v = unpack('i', substr($memData, 4 + 3 * 4, 4));
    		$smu06cAcObj->channelCount = $v[1];
    		$v = unpack('c', substr($memData, 4 + 3 * 4 + 4, 1));
    		$smu06cAcObj->ac_switch = $v[1];
    		$v = unpack('i', substr($memData, 4 + 3 * 4 + 4 + 1, 4));
    		$smu06cAcObj->airlock_count = $v[1];
    		$v = unpack('i', substr($memData, 4 + 3 * 4 + 4 + 1 + 4, 4));
    		$smu06cAcObj->p = $v[1];
    		
    		$v = unpack('c*', substr($memData, 4 + 3 * 4 + 4 + 1 + 4 + 4, 4));
    		$smu06cAcObj->airlock_status = array_values($v);
    		
    		$v = unpack('c*', substr($memData, 4 + 3 * 4 + 4 + 1 + 4 + 4 + 4, 3));
    		$smu06cAcObj->ia_alert = $v[1];
    		$smu06cAcObj->ib_alert = $v[2];
    		$smu06cAcObj->ic_alert = $v[3];
    		$smu06cAcObj->channelList = array();
    		// total length
    		if (strlen($memData) == 43 + $smu06cAcObj->channelCount * 34) {
    			for ($i = 0; $i < $smu06cAcObj->channelCount; $i ++) {
    				$channelObj = new stdClass();
    				$channelData = substr($memData, 43 + $i * 34, 34);
    				$v = unpack('f*', substr($channelData, 0, 4 * 4));
    				$channelObj->a = number_format($v[1], 2);
    				$channelObj->b = number_format($v[2], 2);
    				$channelObj->c = number_format($v[3], 2);
    				$channelObj->f = number_format($v[4], 2);
    				$v = unpack('c*', substr($channelData, 4 * 4, 4));
    				$channelObj->alert_a = $v[1];
    				$channelObj->alert_b = $v[2];
    				$channelObj->alert_c = $v[3];
    				$channelObj->alert_f = $v[4];
    				$v = unpack('i*', substr($channelData, 4 * 4 + 4, 8));
    				$channelObj->m = $v[1];
    				$channelObj->p = $v[2];
    				$v = unpack('c*', substr($channelData, 4 * 4 + 4 + 8, 6));
    				$channelObj->am = array_values(array_slice($v, 0, 4));
    				$channelObj->alert_mp = array_values(array_slice($v, 4));
    				array_push($smu06cAcObj->channelList, $channelObj);
    			}
    		}
    		$v = unpack('v', substr($memData, 4 + 3 * 4 + 4 + 1 + 4 + 4 + 4 + 3, 2));
    		$year = $v[1];
    		$v = unpack('C*', substr($memData, 4 + 3 * 4 + 4 + 1 + 4 + 4 + 4 + 3 + 2, 5));
    		$smu06cAcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
    	} else {
    		$smu06cAcObj->isEmpty = true;
    		$smu06cAcObj->update_datetime = date('Y-m-d H:i:s');
    	}
    
    	$smu06cAcObj->dynamic_config = $CI->cache->get($smu06cAcObj->data_id . '_dc');
    	return $smu06cAcObj;
    }
    
    static function _Get_Smu06cRcData ($dataId)
    {
/*     	
			struct tele_c_smu06c_rc
	{
		 unsigned int data_id;
		 float out_v; //整流模块输出电压
		 //float channel_count; //监控的模块数量M ＝16
		 int channel_count; //监控的模块数量M ＝16
		 tele_c_ttime update_time;
	};
  //整流
    	struct tele_c_smu06c_rc_channel
    	{
    		float out_i; //模块输出电流
    		//	 float out_wrong; //整流模块输出异常
    		//status状态量
    		char  shutdown;//开机/关机状态
    		char  i_limit;//限流/不限流状态
    		char  charge;//浮充/均充/测试状态/交流停电：00H：浮充，01H：均充，02H：测试
    		char  status_p[2];//WALK-in模式（00H使能，83H禁止）;（00H：无顺序起机，84H顺序起机）
    		float p_limiting;//模块限流点(百分比，45%时上报45)
    		float p_out_v;//模块输出电压
    		float p_ab_v;//交流输入三相电压AB/A
    		float p_bc_v;//交流输入三相电压BC/B
    		float p_ca_v;//交流输入三相电压CA/C
    		//alert告警量
    		char  fault;
    		char  p[2];//模块通讯中断(00H：正常，80H：告警)，模块保护(00H：正常，81H：告警)
    	}; */

    	$CI = & get_instance();
    	$CI->load->driver('cache');
    
    	$smu06cRcObj = new stdClass();
    	$smu06cRcObj->data_id = $dataId;
    	$memData = $CI->cache->get($dataId);
    	// minimain length
    	if (strlen($memData) >= 19) {
    		$smu06cRcObj->isEmpty = false;
    		$v = unpack('f', substr($memData, 4, 4));
    		$smu06cRcObj->out_v = number_format($v[1], 2);
    		$v = unpack('i', substr($memData, 4 + 4, 4));
    		$smu06cRcObj->channelCount = $v[1];
    		$smu06cRcObj->channelList = array();
    		if (strlen($memData) == 19 + 32 * $smu06cRcObj->channelCount) {
    			for ($i = 0; $i < $smu06cRcObj->channelCount; $i ++) {
    				$channelObj = new stdClass();
    				$channelStr = substr($memData, 19 + 32 * $i, 32);
    				$v = unpack('f', substr($channelStr, 0, 4));
    				$channelObj->out_i = number_format($v[1], 2);
    				$v = unpack('c*', substr($channelStr, 4, 5));
    				$channelObj->shutdown = $v[1];
    				$channelObj->i_limit = $v[2];
    				$channelObj->charge = $v[3];
    				$channelObj->status_p = array_values(array_slice($v, 3));
    				$v = unpack('f*', substr($channelStr, 4 + 5, 4*5));    				
    				$channelObj->p_limiting = number_format($v[1], 2);
    				$channelObj->p_out_v = number_format($v[2], 2);
    				$channelObj->p_ab_v = number_format($v[3], 2);
    				$channelObj->p_bc_v = number_format($v[4], 2);
    				$channelObj->p_ca_v = number_format($v[5], 2);
    				$v = unpack('c*', substr($channelStr, 4 + 5 + 4 * 5, 3));
    				$channelObj->fault = $v[1];
    				$channelObj->p = array_values(array_slice($v, 1));
    				array_push($smu06cRcObj->channelList, $channelObj);
    			}
    		}
    		$v = unpack('v', substr($memData, 4 + 4 + 4, 2));
    		$year = $v[1];
    		$v = unpack('C*', substr($memData, 4 + 4 + 4 + 2, 5));
    		$smu06cRcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
    	} else {
    		$smu06cRcObj->isEmpty = true;
    		$smu06cRcObj->update_datetime = date('Y-m-d H:i:s');
    	}
    	$smu06cRcObj->dynamic_config = $CI->cache->get($smu06cRcObj->data_id . '_dc');
    
    	return $smu06cRcObj;
    }
    
    static function _Get_Smu06cDcData ($dataId)
    {
    	/*
//直流
struct tele_c_smu06c_dc
{
	unsigned int data_id;
	int dc_m; //直流屏数量M(1字节) ＝ 1
	float v;//直流输出电压
	float i;//总负载电流
	int   m;//蓄电池组数m,m<4
	float dc_i[4];//
	int   n;//监测直流分路电流数N<9
	float channel[9];
	int   p_count;
	float battery_i;
	float p[12];//按顺序依次为用户自定义（电池1 温度）用户自定义（电池1 电压） 用户自定义（电池1实时容量百分比）
	char test; //有无测试报告
	tele_c_ttime test_end; //测试节数时间
	int duration; //测试持续时间
	float quality; //电池放电容量
	//status
	char status_num; //状态数量
	char eps_status; //应急照明状态
	char charge_discharge; //充放电状态
	char stem_in; //输入干结点数量
	char stem_m[4]; //依次为干结点1,干结点2,干结点3,干结点4
	char work_mode;  //工作模式
	char stem_func; //输出干结点功能 00H：自动控制，01H手动控制
	char stem_out; //输出干结点数量
	char stem_o[8]; //依次为输出干结点1-8
	//alert
	char  alert_v;//直流电压
	char  alert_m_number;//直流容断丝数量
	char  alert_m[15];//直流输出
	char  alert_p[60];
	float battery_v[6];//各组电池中点电压
	float battery_last_capacity[6];//各组电池剩余容量百分比
	float battery_temperature[6];//各组电池温度支持电池组1
	float internal_temperature[3];//机柜内环境温度
	float internal_humidity[3];//机柜内环境湿度支持环境湿度1
	float fan_speed[4];	*/
														/*	风扇组1风扇1转速
														风扇组1风扇2转速
														风扇组2风扇1转速
														风扇组2风扇2转速*/
	//parameter
// 	float out_v_high; //输出电压上限
// 	float out_v_low; //输出电压下限
// 	int param_num; //用户自定义参数个数
// 	float param[32]; 
												/*依次为：电池组过压告警点(V)
													电池组欠压告警点(V)
													电池组充电过流告警点(A)
													电池过温告警点(℃)
													电池欠温告警点(℃)
													环境过温告警点(℃)
													环境欠温告警点(℃)
													环境过湿告警点(℃)
													环境欠湿告警点(℃)
													电池充电限流点(A)
													浮充电压(V)
													均充电压(V)
													电池下电电压(V)
													电池上电电压
													LLVD1下电电压
													LLVD1上电电压
													每组电池额定容量(Ah)
													电池测试终止电压(V)
													电池组温补系数(mV/℃)
													电池温补中心点*/
// 	char timed_charge_enable;//定时均充使能
// 	char auto_charge_enable;//自动均充使能
// 	char timed_test_enable;//定时测试使能
// 	char timed_test_interval[2];//定时测试间隔
// 	char battery_testend_time[2];//电池测试终止时间(分钟)
// 	char timed_average_interval[2];//定时均充间隔(天)
// 	char screen_battery_packs[10];//第1屏-第10屏电池组数，支持一屏
    	
    	$CI = & get_instance();
    	$CI->load->driver('cache');
    
    	$smu06cDcObj = new stdClass();
    	$smu06cDcObj->data_id = $dataId;
    	$memData = $CI->cache->get($dataId);
    	if (strlen($memData)>= 314){
    		$smu06cDcObj->isEmpty = false;
/*     		$v = unpack('i', substr($memData, 4, 4));
    		$smu06cDcObj->dc_m = $v[1];
    		$v = unpack('f*', substr($memData, 4 + 4, 4 * 2));
    		$smu06cDcObj->v = number_format($v[1], 2);
    		$smu06cDcObj->i = number_format($v[2], 2);
    		$v = unpack('i', substr($memData, 4 + 4 * 3, 4));
    		$smu06cDcObj->m = $v[1];
    		$v = unpack('f*', substr($memData, 4 + 4 * 3 + 4, 4 * 4));
    		$smu06cDcObj->dc_i = array();
    		array_push($smu06cDcObj->dc_i, number_format($v[1], 2));
    		array_push($smu06cDcObj->dc_i, number_format($v[2], 2));
    		array_push($smu06cDcObj->dc_i, number_format($v[3], 2));
    		array_push($smu06cDcObj->dc_i, number_format($v[4], 2));
    		$v = unpack('i', substr($memData, 4 + 4 * 3 + 4 + 4 * 4, 4));
    		$smu06cDcObj->n = $v[1];
    		$v = unpack('f*', substr($memData, 4 + 4 * 3 + 4 + 4 * 4 + 4, 9 * 4));
    		$smu06cDcObj->channel = array();
    		foreach ($v as $key => $val) {
    			array_push($smu06cDcObj->channel, number_format($val, 2));
    			}
    		$v = unpack('i', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4, 4));
    		$smu06cDcObj->p_count = $v[1]; */
//     		$smu06cDcObj->p = array();
//     		$v = unpack('f*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4, 12 * 4));
//     		foreach ($v as $key => $val) {
//     			array_push($smu06cDcObj->p, number_format($val, 2));
//     			}
/*     		$v = unpack('c', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 12 * 4, 4));
    		$smu06cDcObj->test = $v[1];
    		$v = unpack('i', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 12 * 4 + 4, 4));
    		$smu06cDcObj->duration = $v[1];
    		$v = unpack('c*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 12 * 4 + 3 + 4, 11));
    		$smu06cDcObj->status_num = $v[1];
    		$smu06cDcObj->eps_status = $v[2];
    		$smu06cDcObj->charge_discharge = $v[3];
    		$smu06cDcObj->stem_m[0] = $v[4];
    		$smu06cDcObj->stem_m[1] = $v[5];
    		$smu06cDcObj->stem_m[2] = $v[6];
    		$smu06cDcObj->stem_m[3] = $v[7];
    		$smu06cDcObj->work_mode = $v[8];
    		$smu06cDcObj->stem_func = $v[9];
    		$smu06cDcObj->stem_out = $v[10];
    		$v = unpack('c*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 12 * 4 + 3 + 4 + 11, 8));
    		foreach ($v as $key => $val) {
    			array_push($smu06cDcObj->stem_o, $v);
    			}
    		$v = unpack('c', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 12 * 4 + 3 + 4 + 11 + 8, 1));
    		$smu06cDcObj->stem_out = $v[1];
    		$v = unpack('c', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 12 * 4 + 3 + 4 + 11 + 8 + 1, 1));
    		$smu06cDcObj->stem_out = $v[1];
    		$v = unpack('c*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 12 * 4 + 3 + 4 + 11 + 8 + 1 + 1, 15));
    		foreach ($v as $key => $val) {
    			array_push($smu06cDcObj->alert_m, $v);
    			}
    		$v = unpack('c*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 12 * 4 + 3 + 4 + 11 + 8 + 1 + 1 + 15, 60));
    		foreach ($v as $key => $val) {
    			array_push($smu06cDcObj->alert_p, $v);
    			}
    		$v = unpack('f*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 12 * 4 + 3 + 4 + 11 + 8 + 1 + 1 + 15, 30));  			
    		$smu06cDcObj->alert_m_number = $v[2];
    		$smu06cDcObj->battery_v = array_values(array_slice($v, 0, 6));
    		$smu06cDcObj->battery_last_capacity = array_values(array_slice($v, 6, 6));
    		$smu06cDcObj->battery_temperature = array_values(array_slice($v, 6 + 6, 6));
    		$smu06cDcObj->internal_temperature = array_values(array_slice($v, 6 + 6 + 6, 3));
    		$smu06cDcObj->internal_humidity = array_values(array_slice($v, 6 + 6 + 6 + 3, 3));
    		$smu06cDcObj->fan_speed = array_values(array_slice($v, 6 + 6 + 6 + 3 + 4, 4)); */
//     		$v = unpack('f', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 4 * 29, 4));
    		$v = unpack('f', substr($memData, 49 * 4, 4));
    		$smu06cDcObj->out_v_high = number_format($v[1], 2);
//     		$v = unpack('f', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 4 * 29 + 4, 4));
    		$v = unpack('f', substr($memData, 49 * 4 + 4, 4));
    		$smu06cDcObj->out_v_low = number_format($v[1], 2);
    		$v = unpack('i', substr($memData, 49 * 4 + 4 + 4, 4));
    		$smu06cDcObj->param_num = $v[1];
    		$v = unpack('f*', substr($memData, 49 * 4 + 4 + 4 + 4, 80));
    		$smu06cDcObj->param = array();
    	 	foreach ($v as $key => $val) {
    	 		array_push($smu06cDcObj->param, number_format($val, 2));
    			}
    		$v = unpack('c', substr($memData, 49 * 4 + 4 + 4 + 4 + 80, 1));
    		$smu06cDcObj->timed_charge_enable = $v[1];
    		$v = unpack('c', substr($memData, 49 * 4 + 4 + 4 + 4 + 80 + 1, 1));
    		$smu06cDcObj->auto_charge_enable = $v[1];
    		$v = unpack('c', substr($memData, 49 * 4 + 4 + 4 + 4 + 80 + 1 + 1, 1));
    		$smu06cDcObj->timed_test_enable = $v[1];
    		$v = unpack('s', substr($memData, 49 * 4 + 4 + 4 + 4 + 80 + 1 + 1 + 1, 2));
    		$smu06cDcObj->timed_test_interval = $v[1];
    		$v = unpack('s', substr($memData, 49 * 4 + 4 + 4 + 4 + 80 + 1 + 1 + 1 + 2, 2));
    		$smu06cDcObj->battery_testend_time = $v[1];
    		$v = unpack('s', substr($memData, 49 * 4 + 4 + 4 + 4 + 80 + 1 + 1 + 1 + 2 + 2, 2));
    		$smu06cDcObj->timed_average_interval = $v[1];
    		$v = unpack('c*', substr($memData, 49 * 4 + 4 + 4 + 4 + 80 + 1 + 1 + 1 + 2 + 2 + 2, 10));
    		$smu06cDcObj->screen_battery_packs = array_values(array_slice($v, 0, 10));
    		
    		
    		$v = unpack('v', substr($memData, 49 * 4 + 4 + 4 + 4 + 80 + 1 + 1 + 1 + 2 + 2 + 2 + 10, 2));
    		$year = $v[1];
    		$v = unpack('C*', substr($memData, 49 * 4 + 4 + 4 + 4 + 80 + 1 + 1 + 1 + 2 + 2 + 2 + 10 + 2, 5));
    		$smu06cDcObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
    	} else {
    		$smu06cDcObj->isEmpty = true;
    		$smu06cDcObj->update_datetime = date('Y-m-d H:i:s');
    	}
    	$smu06cDcObj->dynamic_config = $CI->cache->get($smu06cDcObj->data_id . '_dc');
    	return $smu06cDcObj;
    }
    
    
    
    
    
    static function Get_Amf25($dataIdStr)
    {
    	/*unsigned int data_id;
    	uint16_t l1_n;//发电机l1-n相电压
    	uint16_t l2_n;
    	uint16_t l3_n;
    	uint16_t l1_l2;//发电机l1-l2线电压
    	uint16_t l2_l3;
    	uint16_t l3_l1;
    	uint16_t l1_i;//l1负载电流
    	uint16_t l2_i;
    	uint16_t l3_i;
    	uint16_t rpm;//转速，1500/分钟
    	float freq;//Hz:501, 保存时候需要除以10
    	uint16_t p;//有功功率
    	uint16_t l1_p;//L1有功功率
    	uint16_t l2_p;
    	uint16_t l3_p;
    	uint16_t kva;//标称视在功率
    	uint16_t load_kvar;//无功功率
    	uint16_t load_kvar_l1;//l1无功功率
    	uint16_t load_kvar_l2;//l2无功功率
    	uint16_t load_kvar_l3;//l3无功功率
    	float	  pf;//总功率因数，要除2
    	float     l1_pf;//
    	float	  l2_pf;
    	float	  l3_pf;
    	uint16_t load_kva;//总视在功率
    	uint16_t load_kva_l1;//l1视在功率
    	uint16_t load_kva_l2;//l2视在功率
    	uint16_t load_kva_l3;//l3视在功率
    	uint16_t mains_l1_n;//干线l1-n相电压
    	uint16_t mains_l2_n;//干线l2-n相电压
    	uint16_t mains_l3_n;//干线l3-n相电压
    	uint16_t mains_l1_l2;//干线l1-l2线电压
    	uint16_t mains_l2_l3;//干线l2-l3线电压
    	uint16_t mains_l3_l1;//干线l3-l1线电压
    	uint16_t mains_freq;//干线频率
    	float 	 earth_fault;//接地故障,除100
    	float    battery_voltage;//电池电压,除10
    	float	 dplus;//充电电压，除10
    	float    oil_presure;//油压，除10
    	uint16_t engine_temp;//引擎温度
    	uint16_t bin_inputs;/* 0  GCB Feedback
    	1  MCB Feedback
    	2  Emergency Stop
    	3  低油压
    	4  高水温
    	5  Remote TEST
    	6  Rem Start/Stop
    	uint16_t bin_outputs;  0  Starter
    	1  Fuel Solenoid
    	2  GCB Close/Open
    	3  MCB Close/Open
    	4  Prestart
    	5  Horn
    	6  Running
    	uint16_t iom_bin_inp; 0  IOM BI1 Alarm
    	1  IOM BI2 Alarm
    	2  IOM BI3 Alarm
    	3  IOM BI4 Alarm
    	4  IOM BI5 Alarm
    	5  IOM BI6 Alarm
    	6  IOM BI7 Alarm
    	7  IOM BI8 Alarm 
    	uint16_t engine_state;//引擎状态
    	uint16_t breaker_state; 20  Init
    	21  Not ready
    	22  Prestart
    	23  Cranking
    	24  Pause
    	25  Starting
    	26  Running
    	27  Loaded
    	28  Stop
    	29  Shutdown
    	30  Ready
    	31  Cooling
    	32  EmergMan
    	33  MainsOper
    	34  MainsFlt
    	35  MainsFlt
    	36  IslOper
    	37  MainsRet
    	38  Brks Off
    	39  No Timer
    	40  MCB Close
    	41  ReturnDel
    	42  Trans Del
    	43  Idle Run
    	44  MinStabTO
    	45  MaxStabTO
    	46  AfterCool
    	47  GCB Open
    	48  StopValve
    	49  Start Del
    	50  (1Ph)
    	51  (3PD)
    	52  (3PY)
    	53  MRS Mode      
    	float run_hours;//除10
    	uint16_t maintainance;//
    	uint16_t num_starts;//
    	uint32_t genset_kwh;//总发电有功电量
    	uint32_t genset_kvarh;//总发电无功电量
    	uint32_t num_estops;//紧急停车数
    	uint32_t shutdowns;//关机数
    	tele_c_ttime update_time;*/
    	$CI = & get_instance();
    	$CI->load->driver('cache');
    	$idArr = array();
    	$amf25List = array();
    	if (strlen($dataIdStr))
    		$idArr = explode(',', $dataIdStr);
    	 
    	foreach ($idArr as $key => $val) {
    		$amf25Obj = new stdClass();
    		$amf25Obj->data_id = $val;
    		$memData = $CI->cache->get($val);
    		$amf25Obj->value = array();
    		if($memData == false)
    		{
    			$amf25Obj->isEmpty = true;
    		}else{
    			$v = unpack('S*', substr($memData, 4, 2 * 10));
    			$amf25Obj->l1_n = $v[1];
    			$amf25Obj->l2_n = $v[2];
    			$amf25Obj->l3_n = $v[3];
    			$amf25Obj->l1_l2 = $v[4];//发电机l1-l2线电压
    			$amf25Obj->l2_l3 = $v[5];
    			$amf25Obj->l3_l1 = $v[6];
    			$amf25Obj->l1_i = $v[7];//l1负载电流
    			$amf25Obj->l2_i = $v[8];
    			$amf25Obj->l3_i = $v[9];
    			$amf25Obj->rpm = $v[10];//转速，1500/分钟
    			$v = unpack('f', substr($memData, 4 + 20));
    			$amf25Obj->freq = number_format($val[1], 2);
    			$v = unpack('S*', substr($memData, 4 + 24,  2 * 9));
    			$amf25Obj->p = $v[1];
    			$amf25Obj->l1_p = $v[2];
    			$amf25Obj->l2_p = $v[3];
    			$amf25Obj->l3_p = $v[3];
    			$amf25Obj->kva = $v[4];
    			$amf25Obj->load_kvar = $v[5];
    			$amf25Obj->load_kvar_l1 = $v[6];
    			$amf25Obj->load_kvar_l2 = $v[7];
    			$amf25Obj->load_kvar_l3 = $v[8];
    			$v = unpack('f', substr($memData, 4 + 24 + 18, 16));
    			$amf25Obj->pf = $v[1];
    			$amf25Obj->l1_pf = $v[2];
    			$amf25Obj->l2_pf = $v[3];
    			$amf25Obj->l3_pf = $v[4];
    			$v = unpack('S*', substr($memData, 4 + 24+ 18 + 16,  2 * 11));
    			$amf25Obj->load_kva = $v[1];
    			$amf25Obj->load_kva_l1 = $v[2];
    			$amf25Obj->load_kva_l2 = $v[3];
    			$amf25Obj->load_kva_l3 = $v[4];
    			$amf25Obj->mains_l1_n = $v[5];
    			$amf25Obj->mains_l2_n = $v[6];
    			$amf25Obj->mains_l3_n = $v[7];
    			$amf25Obj->mains_l1_l2 = $v[8];
    			$amf25Obj->mains_l2_l3 = $v[9];
    			$amf25Obj->mains_l3_l1 = $v[10];
    			$amf25Obj->mains_freq = $v[11];
    			$v = unpack('f', substr($memData, 4 + 24 + 18 + 16 + 22, 16));
    			$amf25Obj->earth_fault = $v[1];
    			$amf25Obj->battery_voltage = $v[2];
    			$amf25Obj->dplus = $v[3];
    			$amf25Obj->oil_presure = $v[4];
    			$v = unpack('S*', substr($memData, 4 + 24+ 18 + 16 + 22 + 16,  2 * 6));
    			$amf25Obj->engine_temp = $v[1];
    			$amf25Obj->bin_inputs = $v[2];
    			$amf25Obj->bin_outputs = $v[3];
    			$amf25Obj->iom_bin_inp = $v[4];
    			$amf25Obj->engine_state = $v[5];
    			$amf25Obj->breaker_state = $v[6];
    			$v = unpack('f', substr($memData, 4 + 24+ 18 + 16 + 22 + 16 + 12, 4));
    			$amf25Obj->run_hours = number_format($val[1], 2);
    			$v = unpack('S*', substr($memData, 4 + 24+ 18 + 16 + 22 + 16 + 12 + 4,  2 * 6));
    			$amf25Obj->maintainance = $v[1];
    			$amf25Obj->num_starts = $v[2];
    			$amf25Obj->genset_kwh = $v[3];
    			$amf25Obj->genset_kvarh = $v[4];
    			$amf25Obj->num_estops = $v[5];
    			$amf25Obj->shutdowns = $v[6];    			
    		}
    		array_push($amf25List, $amf25Obj);  		
    	}
    	return $amf25List;
    }
    
    static function Get_Access4000xRtData($dataIdStr)
    {
    	/*
    	 * unsigned int data_id;
	//unsigned char bit1[4];
	unsigned char oms; //oil machine start
	unsigned char omd; //oil machine downtime
	unsigned char ems; //emergency stop
	unsigned char ra; //reset alarm
	//unsigned char bit2[28];
	unsigned char as; //auto switch
	unsigned char ga; //general alarm
	unsigned char re1; //Reserved
	unsigned char re2; //Reserved
	unsigned char hb; //Heart beat
	unsigned char rs; //remote start
	unsigned char or1; //output relay 1
	unsigned char or2; //output relay 2
	unsigned char alop; //approaching low oil pressure
	unsigned char ahet; //approaching high engine temperature
	unsigned char lct; //lowcoolant temperature
	unsigned char lbv; //low battery voltage
	unsigned char hbv; //high battery voltage
	unsigned char bcf; //battery charger fail
	unsigned char nia; //not in auto
	unsigned char fts; //fail to start
	unsigned char uf; //under frequency
	unsigned char of; //over frequency
	unsigned char uv; //under voltage
	unsigned char ov; //over voltage
	unsigned char oc; //over current
	unsigned char os; //over speed
	unsigned char es; //emergency stop
	unsigned char het; //high engine temperature
	unsigned char lop; //low oil pressure
	unsigned char sf1; //spare fault 1
	unsigned char sf2; //spare fault 2
	unsigned char sf3; //spare fault 3
	unsigned char sf4; //spare fault 4
	//unsigned short reg3[137];
	unsigned char cco; //crank cut-out
	unsigned char ct; //crank time
	unsigned char cd; //crank delay
	unsigned char cr; //crank repeats
	unsigned char ovs; //over voltage setpoint
	unsigned char ovd; //over voltage delay
	unsigned char uvs; //under voltage setpoint
	unsigned char uvd; //under voltage delay
	unsigned char ofs; //over frequency setpoint
	unsigned char ofd; //over frequency delay
	unsigned char ufd; //under frequency delay
	unsigned char oss; //over speed setpoint
	unsigned char hivs; //high battery voltage setpoint
	unsigned char hivd; //high battery voltage delay
	unsigned char hvvs; //high battery voltage setpoint
	unsigned char hvvd; //high battery voltage delay
	unsigned char lbvs; //low battery voltage setpoint
	unsigned char lbvd; //low battery voltage delay
	unsigned char bcfs; //battery changer failure setpoint
	unsigned char bcfd; //battery changer failure delay
	unsigned char lops; //low oil pressure setpoint
	unsigned char hetm; //high engine temperature
	unsigned char let; //low engine temperature
	unsigned char fpd; //FPT delay
	unsigned char sd; //start delay
	unsigned char cod; //cooling delay
	unsigned char ohva; //over high voltage action
	unsigned char olva; //over low voltage action
	unsigned char ohfd; //over high frequency delay
	unsigned char olfd; //over low frequency delay
	unsigned char lopd; //low oil pressure delay
	unsigned char hetd; //high engine temperature delay
	unsigned char niam; //not in auto mode
	unsigned char fid1; //fault input 1 delay
	unsigned char fia1; //fault input 1 action
	unsigned char fif1; //fault input 1 FPT
	unsigned char fid2; //fault input 2 delay
	unsigned char fia2; //fault input 2 action
	unsigned char fif2; //fault input 2 FPT
	unsigned char fid3; //fault input 3 delay
	unsigned char fia3; //fault input 3 action
	unsigned char fif3; //fault input 3 FPT
	unsigned char fid4; //fault input 4 delay
	unsigned char fia4; //fault input 4 action
	unsigned char fif4; //fault input 4 FPT
	unsigned char ore1; //output relay 1
	unsigned char ore2; //output relay 2
	unsigned short ep_imp; //action power
	unsigned short eq_imp; //reaction power
	unsigned short run; //running
	unsigned char crn; //Crank record number
	unsigned char sl; //select language
	unsigned char cb; //comm band
	unsigned char dtr; //data transfer rate
	unsigned char vtr; //voltage transfer rate
	unsigned char rkw; //rated KW
	unsigned char rkva; //rated KVA
	unsigned char nt; //No of teeth
	unsigned char np; //No of poles
	unsigned char vr; //VT ratio
	unsigned char ctr; //current transfer rate
	unsigned char tsm; //T-sensor mode
	unsigned char psm; //P-sensor mode
	unsigned char fit1; //fault input 1 type
	unsigned char fit2; //fault input 2 type
	unsigned char fit3; //fault input 3 type
	unsigned char fit4; //fault input 4 type
	unsigned char ccv1; //v1 Calibration correction	
	unsigned char ccv2; //v2 Calibration correction
	unsigned char ccv3; //v3 Calibration correction
	unsigned char cci1; //i1 Calibration correction
	unsigned char cci2; //i2 Calibration correction
	unsigned char cci3; //i3 Calibration correction
	unsigned char cop; //correct oil pressure
	unsigned char cwt; //correct water temperature
	unsigned char cbv; //correct battery voltage
	unsigned char opsd[20]; //oil pressure sensor data
	unsigned char wtsd[20]; //water temperature sensor data
	unsigned char ft[20]; //fault records
	//unsigned short reg4[21];
	unsigned char wt; //water temperature
	unsigned char op; //oil pressure
	unsigned char bv; //battery voltage
	unsigned char hr; //hours run
	unsigned char starts; //starts
	unsigned char rpm; //RPM
	unsigned char pha; //phase a voltage
	unsigned char phb; //phase b voltage
	unsigned char phc; //phase c voltage
	unsigned char lab; //line ab voltage
	unsigned char lbc; //line bc voltage
	unsigned char lca; //line ca voltage
	unsigned char pca; //phase a current
	unsigned char pcb; //phase b current
	unsigned char pcc; //phase c current
	unsigned char freq; //Frequency
	unsigned char pf; //power factor
	unsigned char psum; //active power total
	unsigned char ssum; //apparent power total
	unsigned char qsum; //reactive power total
	unsigned short kwh; //KWH
	
	tele_c_ttime update_time;
    	 */
    	$CI = & get_instance();
    	$CI->load->driver('cache');
    	$idArr = array();
    	$access4000xList = array();
    	if (strlen($dataIdStr))
    		$idArr = explode(',', $dataIdStr);
    	
    	foreach ($idArr as $key => $val) {
    		$access4000xObj = new stdClass();
    		$access4000xObj->data_id = $val;
    		$memData = $CI->cache->get($val);
    		$access4000xObj->value = array();
    		if($memData == false)
    		{
    			$libertUpsObj->isEmpty = true;
    		}else{
    			$v = unpack('C*', substr($memData, 176, 21));
    			foreach($v as $i=>$val)
    			{
    				switch($i)
    				{
    					case 0:
    						array_push($access4000xObj->value, $val."°C");
    						break;
    					case 1:
    						array_push($access4000xObj->value, ($val*0.1)."Bar");
    						break;
    					case 2:
    						array_push($access4000xObj->value, $val*0.1."V");
    						break;
    				}
    			}
    		}
    		array_push($access4000xList, $access4000xObj);  		
    	}
    	return $access4000xList;
    }
    static function Get_ug40RtData($dataIdStr)
    {
    	//     	unsigned int data_id;
    	//     	unsigned char system_on; //System On (Fan)
    	//     	unsigned char compressor1; //Compressor 1
    	//     	unsigned char compressor2; //Compressor 2
    	//     	unsigned char compressor3; //Compressor 3
    	//     	unsigned char compressor4; //Compressor 4
    	//     	unsigned char heater1; //El. Heater 1
    	//     	unsigned char heater2; //El. Heater 2
    	//     	unsigned char hot_gas; //Hot gas ON
    	//     	unsigned char dehumidification; //Dehumidification
    	//     	unsigned char humid; //Humidification
    	//     	unsigned char emergency; //Emergency Working
    	//     	unsigned char wrong_psword; //Wrong Password Alarm
    	//     	unsigned char high_room_temp; //High Room Temperature Alarm
    	//     	unsigned char low_room_temp; //Low Room Temperature Alarm
    	//     	unsigned char high_room_humidy; //High Room Humidity Alarm
    	//     	unsigned char low_root_humidy; //Low Room Humidity Alarm
    	//     	unsigned char sensors; //Room Temp. And Humidity Limits by External Sensors
    	//     	unsigned char clogged_filter; //Clogged Filter Alarm
    	//     	unsigned char flooding; //Flooding Alarm
    	//     	unsigned char loss_air_flow; //Loss of Air Flow Alarm
    	//     	unsigned char heater_over; //Heater Overheating Alarm
    	//     	unsigned char circuit1_high_presure;//Circuit 1 High Pressure Alarm
    	//     	unsigned char circuit2_high_presure;//Circuit 2 High Pressure Alarm
    	//     	unsigned char circuit1_low_presure;//Circuit 1 High Pressure Alarm
    	//     	unsigned char circuit2_low_presure;//Circuit 2 High Pressure Alarm
    	//     	unsigned char circuit1_elec_valve; //Circuit 1 Electronic Valve Failure
    	//     	unsigned char circuit2_elec_valve; //Circuit 2 Electronic Valve Failure
    	//     	unsigned char wrong_phase_seq; //Wrong Phase Sequence Alarm
    	//     	unsigned char smoke_fire; //Smoke-Fire Alarm
    	//     	unsigned char interrupt_lan; //Interrupted LAN Alarm
    	//     	unsigned char high_current; //Humidifier: High Current Alarm
    	//     	unsigned char power_loss; //Humidifier: Power Loss Alarm
    	//     	unsigned char water_loss; //Humidifier: Water Loss Alarm
    	//     	unsigned char cthd;//CW Temperature too High for Dehumidification
    	//     	unsigned char cvf_wftl;//CW Valve Failure or Water Flow too Low
    	//     	unsigned char loss_water_flow; //Loss of Water Flow Alarm
    	//     	unsigned char high_water_temp; //High Chilled Water Temperature Alarm
    	//     	unsigned char room_air_sensor; //Room Air Sensor Failed/Disconnected
    	//     	unsigned char hot_water_temp_sensor; //Hot Water Temp. Sensor Failed/Disconnected
    	//     	unsigned char chilled_water_temp; //Chilled Water Temp. Sensor Failed/Disconnected
    	//     	unsigned char outdoor_temp_sensor; //Outdoor Temperature Sensor Failed/Disconnected
    	//     	unsigned char deliv_air_temp_sensor; //Delivery Air Temp. Sensor Failed/Disconnected
    	//     	unsigned char room_humid; //Room Humidity Sensor Failed/Disconnected
    	//     	unsigned char water_outlet_temp; //Chilled Water Outlet Temp.Sensor Failed/Disconnected
    	//     	unsigned char compress1_alarm;  //Compressor 1: hour counter threshold Alarm
    	//     	unsigned char compress2_alarm;  //Compressor 2: hour counter threshold Alarm
    	//     	unsigned char compress3_alarm;  //Compressor 3: hour counter threshold Alarm
    	//     	unsigned char compress4_alarm;  //Compressor 4: hour counter threshold Alarm
    	//     	unsigned char air_filter; //Air filter: hour counter threshold Alarm
    	//     	unsigned char heater1_alarm; //Heater 1: hour counter threshold Alarm
    	//     	unsigned char heater2_alarm; //Heater 2: hour counter threshold Alarm
    	//     	unsigned char humid_alarm; //Humidifier: hour counter threshold Alarm
    	//     	unsigned char air_cond_unit; //Air conditioning unit: hour counter threshold Alarm
    	//     	unsigned char digital_input2; //Alarm by Digital Input 2
    	//     	unsigned char digital_input4; //Alarm by Digital Input 4
    	//     	unsigned char digital_input6; //Alarm by Digital Input 6
    	//     	unsigned char humid_general; //Humidifier General Alarm
    	//     	unsigned char unit; //Unit on Alarm
    	//     	unsigned char unit_rotation; //Unit on Rotation Alarm
    	//     	unsigned char unit_a; //Unit on Alarm Type A
    	//     	unsigned char unit_b; //Unit on Alarm Type B
    	//     	unsigned char unit_c; //Unit on Alarm Type C
    	//     	unsigned char dc_switch; //DX/CW Switch on TC Units
    	//     	unsigned char sw_switch; //Summer/Winter Switch
    	//     	unsigned char unit_switch; //Unit ON/OFF Switch
    	//     	unsigned char unit_reset; //Buzzer and Alarm Unit Reset
    	//     	unsigned char filter_reset; //Filter Run Hours Reset
    	//     	unsigned char comp1_run_reset; //Compressor 1 Run Hours Reset
    	//     	unsigned char comp2_run_reset; //Compressor 2 Run Hours Reset
    	//     	unsigned char comp3_run_reset; //Compressor 3 Run Hours Reset
    	//     	unsigned char comp4_run_reset; //Compressor 4 Run Hours Reset
    	//     	unsigned char comp1_start_reset; //Compressor 1 Starting Reset
    	//     	unsigned char comp2_start_reset; //Compressor 2 Starting Reset
    	//     	unsigned char comp3_start_reset; //Compressor 3 Starting Reset
    	//     	unsigned char comp4_start_reset; //Compressor 4 Starting Reset
    	//     	unsigned char heater1_run_reset; //Heater 1 Run Hours Reset
    	//     	unsigned char heater2_run_reset; //Heater 2 Run Hours Reset
    	//     	unsigned char heater1_start_reset;	//Heater 1 Starting Reset
    	//     	unsigned char heater2_start_reset;	//Heater 2 Starting Reset
    	//     	unsigned char humid_run_reset; //Humidifier Run Hours Reset
    	//     	unsigned char humid_start_reset; //Humidifier Starting Reset
    	//     	unsigned char unit_run_reset; //Unit Run Hours Reset
    	//     	unsigned char setback_mode; //Setback Mode (Sleep Mode)
    	//     	unsigned char sleep_mode_test; //Sleep Mode Test
    	//     	unsigned char lm_usage_values; //Local/Mean Usage of Values
    	//     	unsigned char sb_unit_no; //No. of Stand-by Units
    	//     	unsigned char unit2_rotation; //Unit 2 on Rotation Alarm
    	//     	unsigned char unit3_rotation; //Unit 3 on Rotation Alarm
    	//     	unsigned char unit4_rotation; //Unit 4 on Rotation Alarm
    	//     	unsigned char unit5_rotation; //Unit 5 on Rotation Alarm
    	//     	unsigned char unit6_rotation; //Unit 6 on Rotation Alarm
    	//     	unsigned char unit7_rotation; //Unit 7 on Rotation Alarm
    	//     	unsigned char unit8_rotation; //Unit 8 on Rotation Alarm
    	//     	unsigned char unit9_rotation; //Unit 9 on Rotation Alarm
    	//     	unsigned char unit10_rotation; //Unit 10 on Rotation Alarm
    	//     	float room_temp; //Room Temprature
    	//     	float outdoor_temp; //Outdoor Temperature
    	//     	float deliv_air_temp; //Delivery Air Temperature
    	//     	float chill_water_temp; //Chilled Water Temperature
    	//     	float hot_water_temp; //Hot Water Temperature
    	//     	float room_rela_humid; //Room Relative Humidity
    	//     	float outlet_water_temp; //Outlet Chilled Water Temperature
    	//     	float circuit1_evap_press; //Circuit 1 Evaporating Pressure
    	//     	float circuit2_evap_press; //Circuit 2 Evaporating Pressure
    	//     	float circuit1_suct_temp; //Circuit 1 Suction Temperature
    	//     	float circuit2_suct_temp; //Circuit 2 Suction Temperature
    	//     	float circuit1_evap_temp; //Circuit 1 Evaporating Temperature
    	//     	float circuit2_evap_temp; //Circuit 2 Evaporating Temperature
    	//     	float circuit1_superheat; //Circuit 1 Superheat
    	//     	float circuit2_superheat; //Circuit 2 Superheat
    	//     	float cold_water_ramp; //Cold Water Valve Ramp
    	//     	float hot_water_ramp; //Hot Water Valve Ramp
    	//     	float evap_fan_speed; //Evaporating Fan Speed
    	//     	float cool_set; //Cooling Setpoint
    	//     	float cool_sensit; //Cooling Sensitivity
    	//     	float cool_set2; //Second Cooling Setpoint
    	//     	float heat_set; //	Heating Setpoint
    	//     	float heat_set2;  //Second Heating setpoint
    	//     	float heat_sensit; //Heating Sensitivity
    	//     	float high_room_temp_thres; //High Room Temperature Alarm Threshold(1)
    	//     	float low_room_temp_thres; //Low Room Temperature Alarm Threshold(1)
    	//     	float cool_set_mode; //Setback Mode: Cooling Setpoint
    	//     	float heat_set_mode; //Setback Mode: Heating Setpoint
    	//     	float cws_to_sd; //CW Setpoint to Start Dehumidification
    	//     	float cw_high_temp_thres; //CW High Temperature Alarm Threshold
    	//     	float cws_to_scwom; //CW Setpoint to start CW Operating Mode(Only TC Units)
    	//     	float radcool_set; //Radcooler Setpoint in Energy Saving Mode
    	//     	float radcooler_set_dx; //Radcooler Setpoint in DX Mode
    	//     	float del_temp_low_set; //Delivery Temperature Low Limit Setpoint(1)
    	//     	float delta_temp; //Delta Temperature for Automatic Mean/Local Changeover
    	//     	float serial_trans; //Serial Transmission Offset
    	//     	float unit2_room_temp; //LAN Unit 2 Room Temperature
    	//     	float unit3_room_temp; //LAN Unit 3 Room Temperature
    	//     	float unit4_room_temp; //LAN Unit 4 Room Temperature
    	//     	float unit5_room_temp; //LAN Unit 5 Room Temperature
    	//     	float unit6_room_temp; //LAN Unit 6 Room Temperature
    	//     	float unit7_room_temp; //LAN Unit 7 Room Temperature
    	//     	float unit8_room_temp; //LAN Unit 8 Room Temperature
    	//     	float unit9_room_temp; //LAN Unit 9 Room Temperature
    	//     	float unit10_room_temp; //LAN Unit 10 Room Temperature
    	//     	float unit2_room_humid; //LAN Unit 2 Room Humidity
    	//     	float unit3_room_humid; //LAN Unit 3 Room Humidity
    	//     	float unit4_room_humid; //LAN Unit 4 Room Humidity
    	//     	float unit5_room_humid; //LAN Unit 5 Room Humidity
    	//     	float unit6_room_humid; //LAN Unit 6 Room Humidity
    	//     	float unit7_room_humid; //LAN Unit 7 Room Humidity
    	//     	float unit8_room_humid; //LAN Unit 8 Room Humidity
    	//     	float unit9_room_humid; //LAN Unit 9 Room Humidity
    	//     	float unit10_room_humid; //LAN Unit 10 Room Humidity
    	//     	unsigned int air_filter_run; //Air Filter Run Hours
    	//     	unsigned int unit_run; //Unit Run Hours
    	//     	unsigned int comp1_run; //Compressor 1 Run Hours
    	//     	unsigned int comp2_run; //Compressor 2 Run Hours
    	//     	unsigned int comp3_run; //Compressor 3 Run Hours
    	//     	unsigned int comp4_run; //Compressor 4 Run Hours
    	//     	unsigned int heat1_run; //Heater 1 Run Hours
    	//     	unsigned int heat2_run; //Heater 2 Run Hours
    	//     	unsigned int humid_run; //Humidifier Run Hours
    	//     	unsigned int dehumid_prop_band; //Dehumidification Prop.Band
    	//     	unsigned int humid_prop_band; //Humidification Prop.Band
    	//     	unsigned int high_humid_thres; //High Humidity Alarm Threshold
    	//     	unsigned int low_humid_thres; //Low Humidity Alarm Threshold
    	//     	unsigned int dehumid_set; //Dehumidification Setpoint
    	//     	unsigned int dehumid_set_mode; //Setback Mode: Dehumidification Setpoint
    	//     	unsigned int humid_set; //Humidification Setpoint
    	//     	unsigned int humid_set_mode; //Setback Mode: Humidification Setpoint
    	//     	unsigned int res_delay; //Restart Delay
    	//     	unsigned int regula_start_trans; //Regulation Start Transitory
    	//     	unsigned int low_press_delay; //Low Pressure Delay
    	//     	unsigned int th_limit_delay; //Temp./Humid.Limits Alarm Delay
    	//     	unsigned int anti_hunt; //Anti-Hunting Constant
    	//     	unsigned int cycle; //Stand-by Cycle Base Time
    	//     	unsigned int lan_units_num; //Number of LAN Units
    	//     	unsigned int circuit1_elec; //Circuit 1 Electronic Valve Position
    	//     	unsigned int circuit2_elec; //Circuit 2 Electronic Valve Position
    	//     	tele_c_ttime update_time;
    	$CI = & get_instance();
    	$CI->load->driver('cache');
    	$idArr = array();
    	$ug40List = array();
    	if (strlen($dataIdStr))
    		$idArr = explode(',', $dataIdStr);
    	foreach ($idArr as $key => $val) {
    		$ug40Obj = new stdClass();
    		$ug40Obj->data_id = $val;
     		$memData = $CI->cache->get($val);
    		$ug40Obj->value = array();
    		if($memData != false)
    		{
    			$v = unpack('C*', substr($memData, 4, 95));
    			foreach($v as $i=>$val)
    			{
    				array_push($ug40Obj->value, $val);
    			}
//     			$ug40Obj->system_on = $v[1];
//     			$ug40Obj->compressor1 = $v[2];
//     			$ug40Obj->compressor2 = $v[3];
//     			$ug40Obj->compressor3 = $v[4];
//     			$ug40Obj->compressor4 = $v[5];
//     			$ug40Obj->heater1 = $v[6];
//     			$ug40Obj->heater2 = $v[7];
//     			$ug40Obj->hot_gas = $v[8];
//     			$ug40Obj->dehumidification = $v[9];
//     			$ug40Obj->humid = $v[10];
//     			$ug40Obj->emergency = $v[11];
//     			$ug40Obj->wrong_psword = $v[12];
//     			$ug40Obj->high_room_temp = $v[13];
//     			$ug40Obj->low_room_temp = $v[14];
//     			$ug40Obj->high_room_humidy = $v[15];
//     			$ug40Obj->low_root_humidy = $v[16];
//     			$ug40Obj->sensors = $v[17];
//     			$ug40Obj->clogged_filter = $v[18];
//     			$ug40Obj->flooding = $v[19];
//     			$ug40Obj->loss_air_flow = $v[20];
//     			$ug40Obj->heater_over = $v[21];
//     			$ug40Obj->circuit1_high_presure = $v[22];
//     			$ug40Obj->circuit2_high_presure = $v[23];
//     			$ug40Obj->circuit1_low_presure = $v[24];
//     			$ug40Obj->circuit2_low_presure = $v[25];
//     			$ug40Obj->circuit1_elec_valve = $v[26];
//     			$ug40Obj->circuit2_elec_valve = $v[27];
//     			$ug40Obj->wrong_phase_seq = $v[28];
//     			$ug40Obj->smoke_fire = $v[29];
//     			$ug40Obj->interrupt_lan = $v[30];
//     			$ug40Obj->high_current = $v[31];
//     			$ug40Obj->power_loss = $v[32];
//     			$ug40Obj->water_loss = $v[33];
//     			$ug40Obj->cthd = $v[34];
//     			$ug40Obj->cvf_wftl = $v[35];
//     			$ug40Obj->loss_water_flow = $v[36];
//     			$ug40Obj->high_water_temp = $v[37];
//     			$ug40Obj->room_air_sensor = $v[38];
//     			$ug40Obj->hot_water_temp_sensor = $v[39];
//     			$ug40Obj->chilled_water_temp = $v[40];
//     			$ug40Obj->outdoor_temp_sensor = $v[41];
//     			$ug40Obj->deliv_air_temp_sensor = $v[42];
//     			$ug40Obj->room_humid = $v[43];
//     			$ug40Obj->water_outlet_temp = $v[44];
//     			$ug40Obj->compress1_alarm = $v[45];
//     			$ug40Obj->compress2_alarm = $v[46];
//     			$ug40Obj->compress3_alarm = $v[47];
//     			$ug40Obj->compress4_alarm = $v[48];
//     			$ug40Obj->air_filter = $v[49];
//     			$ug40Obj->heater1_alarm = $v[50];
//     			$ug40Obj->heater2_alarm = $v[51];
//     			$ug40Obj->humid_alarm = $v[52];
//     			$ug40Obj->air_cond_unit = $v[53];
//     			$ug40Obj->digital_input2 = $v[54];
//     			$ug40Obj->digital_input4 = $v[55];
//     			$ug40Obj->digital_input6 = $v[56];
//     			$ug40Obj->humid_general = $v[57];
//     			$ug40Obj->unit = $v[58];
//     			$ug40Obj->unit_rotation = $v[59];
//     			$ug40Obj->unit_a = $v[60];
//     			$ug40Obj->unit_b = $v[61];
//     			$ug40Obj->unit_c = $v[62];
//     			$ug40Obj->dc_switch = $v[63];
//     			$ug40Obj->sw_switch = $v[64];
//     			$ug40Obj->unit_switch = $v[65];
//     			$ug40Obj->unit_reset = $v[66];
//     			$ug40Obj->filter_reset = $v[67];
//     			$ug40Obj->comp1_run_reset = $v[68];
//     			$ug40Obj->comp2_run_reset = $v[69];
//     			$ug40Obj->comp3_run_reset = $v[70];
//     			$ug40Obj->comp4_run_reset = $v[71];
//     			$ug40Obj->comp1_start_reset = $v[72];
//     			$ug40Obj->comp2_start_reset = $v[73];
//     			$ug40Obj->comp3_start_reset = $v[74];
//     			$ug40Obj->comp4_start_reset = $v[75];
//     			$ug40Obj->heater1_run_reset = $v[76];
//     			$ug40Obj->heater2_run_reset = $v[77];
//     			$ug40Obj->heater1_start_reset = $v[78];
//     			$ug40Obj->heater2_start_reset = $v[79];
//     			$ug40Obj->humid_run_reset = $v[80];
//     			$ug40Obj->humid_start_reset = $v[81];
//     			$ug40Obj->unit_run_reset = $v[82];
//     			$ug40Obj->setback_mode = $v[83];
//     			$ug40Obj->sleep_mode_test = $v[84];
//     			$ug40Obj->lm_usage_values = $v[85];
//     			$ug40Obj->sb_unit_no = $v[86];
//     			$ug40Obj->unit2_rotation = $v[87];
//     			$ug40Obj->unit3_rotation = $v[88];
//     			$ug40Obj->unit4_rotation = $v[89];
//     			$ug40Obj->unit5_rotation = $v[90];
//     			$ug40Obj->unit6_rotation = $v[91];
//     			$ug40Obj->unit7_rotation = $v[92];
//     			$ug40Obj->unit8_rotation = $v[93];
//     			$ug40Obj->unit9_rotation = $v[94];
//     			$ug40Obj->unit10_rotation = $v[95];
    			$v = unpack('f*', substr($memData, 4 + 95, 4 * 54));
    			foreach($v as $i=>$val)
    			{
    				array_push($ug40Obj->value, $val);
    			}
//     			$ug40Obj->room_temp = $v[1];
//     			$ug40Obj->outdoor_temp = $v[2];
//     			$ug40Obj->deliv_air_temp = $v[3];
//     			$ug40Obj->chill_water_temp = $v[4];
//     			$ug40Obj->hot_water_temp = $v[5];
//     			$ug40Obj->room_rela_humid = $v[6];
//     			$ug40Obj->outlet_water_temp = $v[7];
//     			$ug40Obj->circuit1_evap_press = $v[8];
//     			$ug40Obj->circuit2_evap_press = $v[9];
//     			$ug40Obj->circuit1_suct_temp = $v[10];
//     			$ug40Obj->circuit2_suct_temp = $v[11];
//     			$ug40Obj->circuit1_evap_temp = $v[12];
//     			$ug40Obj->circuit2_evap_temp = $v[13];
//     			$ug40Obj->circuit1_superheat = $v[14];
//     			$ug40Obj->circuit2_superheat = $v[15];
//     			$ug40Obj->cold_water_ramp = $v[16];
//     			$ug40Obj->hot_water_ramp = $v[17];
//     			$ug40Obj->evap_fan_speed = $v[18];
//     			$ug40Obj->cool_set = $v[19];
//     			$ug40Obj->cool_sensit = $v[20];
//     			$ug40Obj->cool_set2 = $v[21];
//     			$ug40Obj->heat_set = $v[22];
//     			$ug40Obj->heat_set2 = $v[23];
//     			$ug40Obj->heat_sensit = $v[24];
//     			$ug40Obj->high_room_temp_thres = $v[25];
//     			$ug40Obj->low_room_temp_thres = $v[26];
//     			$ug40Obj->cool_set_mode = $v[27];
//     			$ug40Obj->heat_set_mode = $v[28];
//     			$ug40Obj->cws_to_sd = $v[29];
//     			$ug40Obj->cw_high_temp_thres = $v[30];
//     			$ug40Obj->cws_to_scwom = $v[31];
//     			$ug40Obj->radcool_set = $v[32];
//     			$ug40Obj->radcooler_set_dx = $v[33];
//     			$ug40Obj->del_temp_low_set = $v[34];
//     			$ug40Obj->delta_temp = $v[35];
//     			$ug40Obj->serial_trans = $v[36];
//     			$ug40Obj->unit2_room_temp = $v[37];
//     			$ug40Obj->unit3_room_temp = $v[38];
//     			$ug40Obj->unit4_room_temp = $v[39];
//     			$ug40Obj->unit5_room_temp = $v[40];
//     			$ug40Obj->unit6_room_temp = $v[41];
//     			$ug40Obj->unit7_room_temp = $v[42];
//     			$ug40Obj->unit8_room_temp = $v[43];
//     			$ug40Obj->unit9_room_temp = $v[44];
//     			$ug40Obj->unit10_room_temp = $v[45];
//     			$ug40Obj->unit2_room_humid = $v[46];
//     			$ug40Obj->unit3_room_humid = $v[47];
//     			$ug40Obj->unit4_room_humid = $v[48];
//     			$ug40Obj->unit5_room_humid = $v[49];
//     			$ug40Obj->unit6_room_humid = $v[50];
//     			$ug40Obj->unit7_room_humid = $v[51];
//     			$ug40Obj->unit8_room_humid = $v[52];
//     			$ug40Obj->unit9_room_humid = $v[53];
//     			$ug40Obj->unit10_room_humid = $v[54];
    			$v = unpack('I*', substr($memData, 4 + 95 + 4 * 54, 4 * 26));
    			foreach($v as $i=>$val)
    			{
    				array_push($ug40Obj->value, $val);
    			}
//     			$ug40Obj->air_filter_run = $v[1];
//     			$ug40Obj->unit_run = $v[2];
//     			$ug40Obj->comp1_run = $v[3];
//     			$ug40Obj->comp2_run = $v[4];
//     			$ug40Obj->comp3_run = $v[5];
//     			$ug40Obj->comp4_run = $v[6];
//     			$ug40Obj->heat1_run = $v[7];
//     			$ug40Obj->heat2_run = $v[8];
//     			$ug40Obj->humid_run = $v[9];
//     			$ug40Obj->dehumid_prop_band = $v[10];
//     			$ug40Obj->humid_prop_band = $v[11];
//     			$ug40Obj->high_humid_thres = $v[12];
//     			$ug40Obj->low_humid_thres = $v[13];
//     			$ug40Obj->dehumid_set = $v[14];
//     			$ug40Obj->dehumid_set_mode = $v[15];
//     			$ug40Obj->humid_set = $v[16];
//     			$ug40Obj->humid_set_mode = $v[17];
//     			$ug40Obj->res_delay = $v[18];
//     			$ug40Obj->regula_start_trans = $v[19];
//     			$ug40Obj->low_press_delay = $v[20];
//     			$ug40Obj->th_limit_delay = $v[21];
//     			$ug40Obj->anti_hunt = $v[22];
//     			$ug40Obj->cycle = $v[23];
//     			$ug40Obj->lan_units_num = $v[24];
//     			$ug40Obj->circuit1_elec = $v[25];
//     			$ug40Obj->circuit2_elec = $v[26];
    		}
    		array_push($ug40List, $ug40Obj);
    	}
    	return $ug40List;
    }
    static function Get_LiebertUpsRtData ($dataIdStr)
    {
        /*
         * typedef struct tele_c_liebert_ups_
         * {
         * unsigned int data_id;
         *
         * unsigned short a[32];//重要遥测-A帧
         * unsigned int d1[3];//遥信D1帧,F0-F2三个功能吗
         * tele_c_ttime update_time;
         * }tele_c_liebert_ups;
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $idArr = array();
        $libertUpsList = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        
        foreach ($idArr as $key => $val) {
            $libertUpsObj = new stdClass();
            $libertUpsObj->data_id = $val;
            $memData = $CI->cache->get($val);
            if (strlen($memData) == 87) {
                $v = unpack('S*', substr($memData, 4, 2 * 32));
                $libertUpsObj->isEmpty = false;
                $libertUpsObj->aList = array();
                foreach ($v as $k => $val) {
                    $aObj = new stdClass();
                    $aObj->val = number_format($val, 2);
                    $value = $CI->cache->get($libertUpsObj->data_id . '_alert_a_' . $k . '_value');
                    if ($value) {
                        $value = unpack("i", $value);
                        $aObj->alert = $value[1];
                    }
                    array_push($libertUpsObj->aList, $aObj);
                }
                
                $v = unpack('I*', substr($memData, 4 + 2 * 32, 4 * 3));
                $libertUpsObj->d1List = array();
                foreach ($v as $k => $val) {
                    $dValArr = str_split(strrev(sprintf('%032d', decbin($val))));
                    foreach ($dValArr as $dKey => $dVal) {
                        $d1Obj = new stdClass();
                        $d1Obj->val = $dVal;
                        $value = $CI->cache->get($libertUpsObj->data_id . '_alert_d_' . $dKey . '_value');
                        if ($value) {
                            $value = unpack("i", $value);
                            $d1Obj->alert = $value[1];
                        }
                        array_push($libertUpsObj->d1List, $d1Obj);
                    }
                }
                $v = unpack('v', substr($memData, 4 + 2 * 32 + 4 * 3, 2));
                $year = $v[1];
                $v = unpack('C*', substr($memData, 4 + 2 * 32 + 4 * 3 + 2, 5));
                $libertUpsObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
            } else {
                $libertUpsObj->isEmpty = true;
                $libertUpsObj->update_datetime = date('Y-m-d H:i:s');
            }
            $libertUpsObj->dynamic_config = $CI->cache->get($libertUpsObj->data_id . '_dc');
            array_push($libertUpsList, $libertUpsObj);
        }
        //var_dump($libertUpsList) ;
        return $libertUpsList;
    }

    static function Get_LiebertPexRtData($dataIdStr)
    {
  /*   	struct tele_c_liebert_pex
    	{
    		unsigned int data_id;
    		//unsigned char bit[109];
    		//unsigned short reg[158];
    		tele_c_ttime update_time;
    	}; */
    	$CI = & get_instance();
    	$CI->load->driver('cache');
    	$idArr = array();
    	$libertPexList = array();
    	if (strlen($dataIdStr))
    		$idArr = explode(',', $dataIdStr);
    	
    	foreach ($idArr as $key => $val) {
    		$libertPexObj = new stdClass();
    		$libertPexObj->data_id = $val;
    		$memData = $CI->cache->get($val);
    		if (strlen($memData) == 436) {
    			$v = unpack('C*', substr($memData, 4, 109));
    			$libertPexObj->isEmpty = false;
    			$libertPexObj->aList = array();
    			foreach ($v as $k => $val) {
    				$bitObj = new stdClass();
    				$bitObj->val = number_format($val, 1);
    				$value = $CI->cache->get($libertPexObj->data_id . '_alert_bit_' . $k . '_value');
    				if ($value) {
    					$value = unpack("i", $value);
    					$bitObj->alert = $value[1];
    				}
    				array_push($libertPexObj->aList, $bitObj);
    			}
    	
    			$v = unpack('S*', substr($memData, 4 + 109, 2 * 158));
    			$libertPexObj->d1List = array();
    			foreach ($v as $k => $val) {
    				$regObj = new stdClass();
    				$regObj->val = number_format($val,2);
    				$value = $CI->cache->get($libertPexObj->data_id . '_alert_reg_' . $k . '_value');
    					if ($value) {
    						$value = unpack("i", $value);
    						$regObj->alert = $value[1];
    					}
    					array_push($libertPexObj->d1List, $regObj);
    			}
    			$v = unpack('v', substr($memData, 4 + 109 + 2*158, 2));
    			$year = $v[1];
    			$v = unpack('C*', substr($memData, 4 + 109 + 2*158 + 2, 5));
    			$libertPexObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
    		} else {
    			$libertPexObj->isEmpty = true;
    			$libertPexObj->update_datetime = date('Y-m-d H:i:s');
    		}
    		$libertPexObj->dynamic_config = $CI->cache->get($libertPexObj->data_id . '_dc');
    		array_push($libertPexList, $libertPexObj);
    	}
    	return $libertPexList;
    /* 	$CI = & get_instance();
    	$CI->load->driver('cache');
    	$liebertPEXList = array();
    	if (strlen($dataIdStr))
    		$idArr = explode(',', $dataIdStr);
    	foreach ($idArr as $data_id) {
    		$liebertPEXObj = new stdClass();
    		$liebertPEXObj->data_id = $data_id;
    		$memData = $CI->cache->get($data_id);
    		if (strlen($memData) == 436) {
    			$liebertPEXObj->isEmpty = false;
    			$v = unpack('C*', substr($memData, 4, 109));
    			$liebertPEXObj->bit1 = array_values($v);
    			
    			$v = unpack('S*', substr($memData, 4 + 109, 2 * 158));
    			$liebertPEXObj->reg3 = array_values($v);
    			
    			$v = unpack('v', substr($memData, 4 + 109 + 2*158, 2));
    			$year = $v[1];
    			$v = unpack('C*', substr($memData, 4 + 109 + 2*158 + 2, 5));
    			$liebertPEXObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
    		} else {
    			$liebertPEXObj->isEmpty = true;
    			$liebertPEXObj->save_datetime = date('Y-m-d H:i:s');
    		}
    		$liebertPEXObj->dynamic_config = $CI->cache->get($data_id . '_dc');
    		array_push($liebertPEXList, $liebertPEXObj);
    	}
    	return $liebertPEXList; */
    }
    static function Get_PueData($dataIdStr)
    {
    	$CI = & get_instance();
    	$CI->load->driver('cache');
    	$stationList = array();
    	if (strlen($dataIdStr) > 0)
    		$stationList = $CI->mp_xjdh->Get_Substations_By_IdList(explode(',', $dataIdStr));
    	$dataList = array();
    	foreach ($stationList as $stationObj) {
    		$data = new stdClass();
    		$data->data_id = $stationObj->id;
    		$memData = $CI->cache->get($stationObj->id."_all_power");
    		if($memData)
    		{
    			$val = unpack('f', $memData);
    			$data->all_power = number_format($val[1], 2);
    		}else{
    			$data->all_power = 0.0;
    		}
    		$memData = $CI->cache->get($stationObj->id."_all_power_consumption");
    		if($memData)
    		{
    			$val = unpack('f', $memData);
    			$data->all_power_consumption = number_format($val[1], 2);
    		}else{
    			$data->all_power_consumption = 0.0;
    		}
    		$memData = $CI->cache->get($stationObj->id."_all_power_compensate");
    		if($memData)
    		{
    			$val = unpack('f', $memData);
    			$data->all_power_compensate = number_format($val[1], 2);
    		}else{
    			$data->all_power_compensate = 0.0;
    		}
    		$memData = $CI->cache->get($stationObj->id."_all_power_consumption_compensate");
    		if($memData)
    		{
    			$val = unpack('f', $memData);
    			$data->all_power_consumption_compensate = number_format($val[1], 2);
    		}else{
    			$data->all_power_consumption_compensate = 0.0;
    		}
    		$memData = $CI->cache->get($stationObj->id."_main_power");
    		if($memData)
    		{
    			$val = unpack('f', $memData);
    			$data->main_power = number_format($val[1], 2);
    		}else{
    			$data->main_power = 0.0;
    		}
    		$memData = $CI->cache->get($stationObj->id."_main_power_consumption");
    		if($memData)
    		{
    			$val = unpack('f', $memData);
    			$data->main_power_consumption = number_format($val[1], 2);
    		}else{
    			$data->main_power_consumption = 0.0;
    		}
    		$memData = $CI->cache->get($stationObj->id."_main_power_compensate");
    		if($memData)
    		{
    			$val = unpack('f', $memData);
    			$data->main_power_compensate = number_format($val[1], 2);
    		}else{
    			$data->main_power_compensate = 0.0;
    		}
    		if($data->main_power_compensate != 0.0)
    		{
    			$data->pue = number_format($data->all_power_compensate/$data->main_power_compensate,2);
    		}
    		$memData = $CI->cache->get($stationObj->id."_main_power_consumption_compensate");
    		if($memData)
    		{
    			$val = unpack('f', $memData);
    			$data->main_power_consumption_compensate = number_format($val[1], 2);
    		}else{
    			$data->main_power_consumption_compensate = 0.0;
    		}
    		if($data->main_power_consumption_compensate != 0.0)
    		{
    			$data->accumulated_pue = number_format($data->all_power_consumption_compensate/$data->main_power_consumption_compensate, 2);
    		}
    		$data->update_datetime = date('Y-m-d H:i:s');
    		array_push($dataList, $data);
    	}
    	return $dataList;
    }
    static function Get_FlunctuationData($dataIdStr)
    {
    	$CI = & get_instance();
    	$CI->load->driver('cache');
    	$devList = array();
    	if (strlen($dataIdStr) > 0)
    		$devList = $CI->mp_xjdh->Get_Devices(explode(',', $dataIdStr));
    	$dataList = array();
    	foreach ($devList as $devObj) {
    		$data = new stdClass();
    		$data->data_id = $devObj->data_id;
    		$memData = $CI->cache->get($devObj->data_id."_flunctuation");
    		if($memData)
    		{
	    		$val = unpack('f*', $memData);
	    		$data->load = number_format($val[1], 2);
	    		$data->i = number_format($val[2], 2);
	    		$data->stable_load = number_format($val[3], 2);
	    		$data->stable_i = number_format($val[4], 2);
	    		$data->sudden_flunctuation = number_format($val[5], 2);
	    		$data->i0 = number_format($val[6], 2);
	    		$data->i1 = number_format($val[7], 2);
	    		$data->period_flunctuation = number_format($val[9], 2);
    		}else{
    			$data->isEmpty = true;
    		}
    		$data->update_datetime = date('Y-m-d H:i:s');
    		array_push($dataList, $data);
    	}
    	return $dataList;
    }
    static function Get_AiDiRtData ($dataIdStr)
    {
        $CI = & get_instance();
        $CI->load->driver('cache');
        $roomDevList = array();
        if (strlen($dataIdStr) > 0)
        {
            $roomDevList = $CI->mp_xjdh->Get_Devices(explode(',', $dataIdStr));
            foreach ($roomDevList as $roomDevObj) {
                $memData = $CI->cache->get($roomDevObj->data_id);
                if (in_array($roomDevObj->model, array('water','smoke'))) {
                    if (strlen($memData) == 1) {
                        $val = unpack('C', $memData);
                        $roomDevObj->value = $val[1];
                    } else {
                        $roomDevObj->value = 1;
                    }
                } else if (in_array($roomDevObj->model, array('temperature','humid'))) {
                    if (strlen($memData) == 4) {
                        $val = unpack('f', $memData);
                        $roomDevObj->value = number_format($val[1], 2);
                    } else {
                        $roomDevObj->value = 0;
                    }
                }
                $roomDevObj->alert_value = 0;
                $alertValue = $CI->cache->get($roomDevObj->data_id."_alert_value");
                if($alertValue != FALSE)
                {
                    //有告警数据
                    $val = unpack('i', $alertValue);
                    if(count($val) == 1)
                    {
                        $roomDevObj->alert_value = $val[1];
                    }
                }
                unset($roomDevObj->name);
                $roomDevObj->save_datetime = date('Y-m-d H:i:s');
            }
        }
        return $roomDevList;
    }

    static function Get_MotorBatRtData ($dataIdStr)
    {
        $CI = & get_instance();
        $CI->load->driver('cache');
        $motorBatList = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        foreach ($idArr as $data_id) {
            $motorBatObj = new stdClass();
            $motorBatObj->data_id = $data_id;
            $memData = $CI->cache->get($data_id);
            if (strlen($memData) == 4) {
                $val = unpack('f', $memData);
                $motorBatObj->value = number_format($val[1], 2);
            } else {
                $motorBatObj->value = 0;
            }
            $motorBatObj->dynamic_config = $CI->cache->get($data_id . '_dc');
            $motorBatObj->save_datetime = date('Y-m-d H:i:s');
            array_push($motorBatList, $motorBatObj);
        }
        return $motorBatList;
    }

    static function Get_RoomPiData ($piKeyStr)
    {
        $keyArr = array();
        if (strlen($piKeyStr) > 0)
            $keyArr = explode(',', $piKeyStr);
        $CI = & get_instance();
        $CI->load->driver('cache');
        $roomPiList = array();
        foreach ($keyArr as $key) {
            $pi = json_decode($CI->cache->get($key));
            if ($pi != null) {
                $roomPiObj = new stdClass();
                $roomPi->key = $key;
                $roomPi->value = $pi;
                array_push($roomPiList, $roomPiObj);
            }
        }
        return $roomPiList;
    }

    static function Get_Access4000xRtData_deprecated ($dataIdStr)
    {
        /*
         * struct tele_c_access4000x
         * {
         * unsigned int data_id;
         * unsigned char bit1[4];
         * unsigned char bit2[28];
         * unsigned short reg3[137];
         * unsigned short reg4[21];
         * tele_c_ttime update_time;
         * };
         *
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $access4000xList = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        foreach ($idArr as $data_id) {
            $access400xObj = new stdClass();
            $access400xObj->data_id = $data_id;
            $memData = $CI->cache->get($data_id);
            if (strlen($memData) == 359) {
                $access400xObj->isEmpty = false;
                $v = unpack('C*', substr($memData, 4, 4));
                $access400xObj->bit1 = array_values($v);
                $v = unpack('C*', substr($memData, 4 + 4, 28));
                $access400xObj->bit2 = array_values($v);
                $v = unpack('S*', substr($memData, 4 + 4 + 28, 2 * 137));
                $access400xObj->reg3 = array_values($v);
                $v = unpack('S*', substr($memData, 4 + 4 + 28 + 2 * 137, 21 * 2));
                $access400xObj->reg4 = array_values($v);
                $v = unpack('v', substr($memData, 4 + 4 + 28 + 2 * 137 + 21 * 2, 2));
                $year = $v[1];
                $v = unpack('C*', substr($memData, 4 + 4 + 28 + 2 * 137 + 21 * 2 + 2, 5));
                $access400xObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
            } else {
                $access400xObj->isEmpty = true;
                $access400xObj->save_datetime = date('Y-m-d H:i:s');
            }
            $access400xObj->dynamic_config = $CI->cache->get($data_id . '_dc');
            array_push($access4000xList, $access400xObj);
        }
        return $access4000xList;
    }

    static function Get_AegMS10SERtData ($dataIdStr)
    {
        /*
         * struct tele_c_aeg_ms10se
         * {
         * unsigned int data_id;
         * //基本测量参数地址区,0x130 - 0x153
         * unsigned short reg1[35];
         * //电度参量地址区,0x156-0x165
         * unsigned short reg2[15];
         * //DI 数据地址区,02,0-5
         * unsigned char di[6];
         * //DO 数据地址区,01,0-5
         * unsigned char d_o[6];
         *
         * tele_c_ttime update_time;
         * };
         * 
struct tele_c_aeg_ms10se
{
	unsigned int data_id;
	//系统设置参数区
	//unsigned int reg1[5];
	unsigned int pt1; //PT1
	unsigned int pt2; //PT2
	unsigned int ct1; //CT1
	unsigned int ct2; //CT2
	
	//基本测量参数地址区,0x130 - 0x153
	//unsigned short reg2[35];
	unsigned int f; //频率
	unsigned int v1; //相电压V1
	unsigned int v2; //相电压v2
	unsigned int v3; //相电压v3
	unsigned int vvavg; //相电压均值
	unsigned int v12; //线电压v12
	unsigned int v23; //线电压v23
	unsigned int v31; //线电压v31
	unsigned int vlavg; //线电压均值
	unsigned int i1; //相电流i1
	unsigned int i2; //相电流i2
	unsigned int i3; //相电流i3
	unsigned int iavg; //三相电流均值
	unsigned int in; //中线电流
	int p1; //分相有功功率p1
	int p2; //分相有功功率p2
	int p3; //分相有功功率p3
	int psum; //系统有功功率
	int q1; //分相无功功率q1
	int q2; //分相无功功率q2
	int q3; //分相无功功率q3
	int qsum; //系统无功功率
	unsigned int s1; //分相视在功率s1
	unsigned int s2; //分相视在功率s2
	unsigned int s3; //分相视在功率s3
	unsigned int ssum; //系统视在功率
	int pf1; //分相功率因数pf1
	int pf2; //分相功率因数pf2
	int pf3; //分相功率因数pf3
	int pf; //系统功率因数
	long psum2; //系统有功功率 二次侧/10
	long qsum2; //系统无功功率 二次侧/10
	long ssum2; //系统视在功率 二次侧/10
	
	//电度参量地址区,0x156-0x165
	//unsigned short reg3[15];
	float ep_imp; //有功输入电度
	float ep_exp; //有功输出电度
	float eq_imp; //感性无功电度
	float eq_exp; //容性无功电度
	float ep_total; //总有功电度
	float ep_net; //净有功电度
	float eq_total; //总电度
	float eq_net; //净无功电度
	
	//DI 数据地址区,02,0-5
	unsigned char  di[6];
	
	//DO 数据地址区,01,0-5
	unsigned char d_o[6];
	
	tele_c_ttime update_time;
};
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $aegMS10SEList = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        foreach ($idArr as $data_id) {
            $aegMS10SEObj = new stdClass();
            $aegMS10SEObj->data_id = $data_id;
            $memData = $CI->cache->get($data_id);
            if (strlen($memData) == 4 + 4 + 28 + 2 * 137 + 21 * 2 + 2 + 5) {
                $aegMS10SEObj->isEmpty = false;
                $v = unpack('S*', substr($memData, 4, 2 * 35));
                $aegMS10SEObj->reg1 = array_values($v);
                $v = unpack('S*', substr($memData, 4 + 2 * 35, 15 * 2));
                $aegMS10SEObj->reg2 = array_values($v);
                
                $v = unpack('C*', substr($memData, 4 + 2 * 35 + 15 * 2, 6));
                $aegMS10SEObj->di = array_values($v);
                
                $v = unpack('C*', substr($memData, 4 + 2 * 35 + 15 * 2 + 6, 6));
                $aegMS10SEObj->d_o = array_values($v);
                
                $v = unpack('v', substr($memData, 4 + 2 * 35 + 15 * 2 + 6 + 6, 2));
                $year = $v[1];
                $v = unpack('C*', substr($memData, 4 + 4 + 28 + 2 * 137 + 21 * 2 + 2, 5));
                $aegMS10SEObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
            } else {
                $aegMS10SEObj->isEmpty = true;
                $aegMS10SEObj->save_datetime = date('Y-m-d H:i:s');
            }
            $aegMS10SEObj->dynamic_config = $CI->cache->get($data_id . '_dc');
            array_push($aegMS10SEList, $aegMS10SEObj);
        }
        return $aegMS10SEList;
    }

    static function Get_AegMS10MRtData ($dataIdStr)
    {
        /*
         * struct tele_c_aeg_ms10m
         * {
         * unsigned int data_id;
         * unsigned short reg1[64];
         * //单位时间内最大值统计区
         * unsigned short reg2[26];
         * //单位时间内平均值统计区
         * unsigned short reg3[26];
         * //谐波分析数据区
         * unsigned short reg4[197];
         * tele_c_ttime update_time;
         * };
struct tele_c_aeg_ms10m
{
	unsigned int data_id;
	float ua;//A相电压
	float ub;//B相电压
	float uc;//C相电压
	float uavg;//相平均电压
	float uab;//AB相电压
	float ubc;//BC相电压
	float uca;//CA相电压
	float ulavg;//线平均电压
	float ia;//A相电流
	float ib;//B相电流
	float ic;//C相电流
	float iavg;//相平均电流
	float i0;//零序电流
	float pa;//A相有功功率
	float pb;//B相有功功率
	float pc;//C相有功功率
	float ptotal;//三相有功功率
	float qa;//A相无功功率
	float qb;//B相无功功率
	float qc;//C相无功功率
	float qtotal;//三相无功功率
	float sa;//A相视在功率
	float sb;//B相视在功率
	float sc;//C相视在功率
	float stotal;//三相视在功率
	float cosfi_a;//A相功率因数
	float cosfi_b;//B相功率因数
	float cosfi_c;//C相功率因数
	float cosfi;//三相功率因数
	float freq;//频率
	unsigned short di;//开入量,二进制数bit3~0对应DI3~DI0    对应的bit为高电平表示DI合上
	float ep_imp;//有功输入电度
	float ep_exp;//有功输出电度
	float eq_imp;//无功输入电度
	float eq_exp;//无功输出电度
	unsigned short d_o;//开出量当前状态(实时),二进制数bit0,bit1对应DO0,DO1  对应的bit为高电平表示DO合上
	
	//单位时间内最大值统计区
	//unsigned short reg2[26];
	float ua_max; //A相电压
	float ub_max; //B相电压
	float uc_max; //C相电压;
	float uab_max; //AB相电压
	float ubc_max; //BC相电压
	float uca_max; //CA相电压
	float ia_max; //A相电流
	float ib_max; //B相电流
	float ic_max; //C相电流
	float i0_max; //零序电流
	float pt_max; //三相有功功率
	float qt_max; //三相无功功率
	float st_max; //三相视在功率
	float freq_max; //频率
	
	//单位时间内平均值统计区
	//unsigned short reg3[26];
	float ua_avg; //A相电压
	float ub_avg; //B相电压
	float uc_avg; //C相电压
	float uab_avg; //AB相电压
	float ubc_avg; //BC相电压
	float uca_avg; //CA相电压
	float ia_avg; //A相电流
	float ib_avg; //B相电流
	float ic_avg; //C相电流
	float i0_avg; //零序电流
	float pt_avg; //三相有功功率
	float qt_avg; //三相无功功率
	float st_avg; //三相视在功率
	float freq_avg; //频率
	
	//谐波分析数据区
	unsigned short reg[186];
	float thd_ua; //A相电压谐波畸变率
	float thd_ub; //B相电压谐波畸变率
	float thd_uc; //C相电压谐波畸变率
	float thd_ia; //A相电流谐波畸变率
	float thd_ib; //B相电流谐波畸变率
	float thd_ic; //C相电流谐波畸变率
	float ua_pha[31]; //31谐波含量数据区
	float ub_pha[31]; //31谐波含量数据区
	float uc_pha[31]; //31谐波含量数据区
	float ia_pha[31]; //31次谐波含量数据区
	float ib_pha[31]; //31次谐波含量数据区
	float ic_pha[31]; //31次谐波含量数据区
	tele_c_ttime update_time;
};
         */
        $CI = & get_instance();
        $CI->load->driver('cache');
        $aegMS10MList = array();
        if (strlen($dataIdStr))
            $idArr = explode(',', $dataIdStr);
        foreach ($idArr as $data_id) {
            $aegMS10MObj = new stdClass();
            $aegMS10MObj->data_id = $data_id;
            $memData = $CI->cache->get($data_id);
            if (strlen($memData) == 4 + 2 * 64 + 26 * 2 + 2 * 26 + 197 * 2 + 2 + 5) {
                $aegMS10MObj->isEmpty = false;
                $v = unpack('S*', substr($memData, 4, 2 * 64));
                $aegMS10MObj->reg1 = array_values($v);
                $v = unpack('S*', substr($memData, 4 + 2 * 64, 26 * 2));
                $aegMS10MObj->reg2 = array_values($v);
                $v = unpack('S*', substr($memData, 4 + 2 * 64 + 26 * 2, 2 * 26));
                $aegMS10MObj->reg3 = array_values($v);
                $v = unpack('S*', substr($memData, 4 + 2 * 64 + 26 * 2 + 2 * 26, 197 * 2));
                $aegMS10MObj->reg4 = array_values($v);
                $v = unpack('v', substr($memData, 4 + 2 * 64 + 26 * 2 + 2 * 26 + 197 * 2, 2));
                $year = $v[1];
                $v = unpack('C*', substr($memData, 4 + 2 * 64 + 26 * 2 + 2 * 26 + 197 * 2 + 2, 5));
                $aegMS10MObj->update_datetime = date('Y-m-d H:i:s', strtotime($year . '-' . $v[1] . '-' . $v[2] . ' ' . $v[3] . ':' . $v[4] . ':' . $v[5]));
            } else {
                $aegMS10MObj->isEmpty = true;
                $aegMS10MObj->save_datetime = date('Y-m-d H:i:s');
            }
            $aegMS10MObj->dynamic_config = $CI->cache->get($data_id . '_dc');
            array_push($aegMS10MList, $aegMS10MObj);
        }
        return $aegMS10MList;
    }
    static function Get_smd_status(){
    	$CI=& get_instance();
    	$CI->load->driver('cache');
    		$cache=$CI->cache->get();    		 
    	return $cache;
    }
}
?>
