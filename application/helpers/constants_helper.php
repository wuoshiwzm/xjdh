<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
class Constants{
    static $devConfigList = array(
            array(array("smd_device"), "监控设备", "smd_device"),
            array(array('temperature','humid','smoke','water'), "机房环境","enviroment"),
            array(array('imem_12','power_302a'), "智能电表","powermeter"),
            array(array('battery_24','battery24_voltage'), "蓄电池组","battery"),
    	    array(array('battery_32'),"UPS蓄电池","battery_32"),
            array(array('vpdu','aeg-ms10se','aeg-ms10m'),"低压配电","pdu"),
            array(array("fresh_air"), "新风设备", "freshair"),
            array(array('psma-ac','psma-rc','psma-dc','m810g-rc','m810g-dc','m810g-ac','zxdu-rc','zxdu-dc','zxdu-ac','smu06c-rc','smu06c-dc','smu06c-ac','dk04','psm-6'), "开关电源", "sps"),
            array(array('camera'), "视频监控", "camera"),
            array(array('DoorXJL',"EmersonDoor"), "门禁系统", "door"),
            array(array('liebert-ups'),"UPS设备", "liebert-ups"),
            array(array('liebert-pex','datamate3000','canatal','ug40'),"专用空调", "ac"),
            array(array('motor_battery'),'油机启动电池',"motor_battery"),
            array(array('mec10','meaccess4000x','amf25'),'柴油发电机组',"engine"),
    );
}


?>
