<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

require_once './Thrift/ClassLoader/ThriftClassLoader.php';

use Thrift\ClassLoader\ThriftClassLoader;

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;

class SMDThrift
{
    public function RefreshVDevice($device_no)
    {
        return $this->StatusChange("RefreshVDevice", $device_no);
    }
	public function SMDDeviceChange($id)
	{
		return $this->StatusChange("SmdDeviceChange", $id);
	}
	public function DeviceChange($id)
	{
		return $this->StatusChange("DeviceChange", $id);
	}
	
	public function reloadCamera($id)
	{
                   
				return $this->StatusChange("reloadCamera", $id, 9001);		
	}
	
	public function cameraDoMonitor($id)
	{
	    return $this->StatusChange("cameraDoMonitor", $id, 9001);
	}
	public function DeviceThresholdChange($id)
	{
		return $this->StatusChange("DeviceThresholdChange", $id);
	}
	
	public function DeviceThresholdFieldChange($id, $field)
	{
		$GEN_DIR = '.';
		
		$loader = new ThriftClassLoader();
		$loader->registerNamespace('Thrift', './');
		$loader->registerDefinition('shared', $GEN_DIR);
		$loader->registerDefinition('smd_api', $GEN_DIR);
		$loader->register();
		include_once './ApiCall.php';
		try
		{
			$socket = new TSocket ('localhost', 9000);
			$transport = new TBufferedTransport ($socket, 1024, 1024);
			$protocol = new TBinaryProtocol ($transport);
			$client = new \smd_api\ApiCallClient($protocol);
		
			$transport->open ();
		
			$ret = $client->DeviceThresholdFieldChange($id, $field);
		
			$transport->close ();
			$socket->close();
			return $ret;
		}
		
		catch (TException $tx)
		{
			return -1;
		}
		
		return -2;
	}
	
	public function DeviceDynamicSettingChange($id)
	{
		return $this->StatusChange('DeviceDynamicSettingChange', $id);
	}

/***********************************************************************************/
/**********************************************************************************/	
	public function DeviceTypeThresholdChange($partid,$type, $port=9000)
	{
		$GEN_DIR = '.';

        $loader = new ThriftClassLoader();
        $loader->registerNamespace('Thrift', './');
        $loader->registerDefinition('shared', $GEN_DIR);
        $loader->registerDefinition('smd_api', $GEN_DIR);
        $loader->register();
        include_once './ApiCall.php';
        try
        {
                $socket = new TSocket ('localhost', $port);
                $transport = new TBufferedTransport ($socket, 1024, 1024);
                $protocol = new TBinaryProtocol ($transport);
                $client = new \smd_api\ApiCallClient($protocol);

                $transport->open ();

                $ret = $client->DeviceTypeThresholdChange($partid,$type);

                $transport->close ();
                $socket->close();
                return $ret;
        }

        catch (TException $tx)
        {
                return -1;
        }

        return -2;

	}
	/**********************************************************************/
/************************************************************************************/

	public function DeviceTypePiSettingChange($type)
	{
		return $this->StatusChange('DeviceTypePiSettingChange', $type);
	}
	
	public function ReloadStationSetting()
	{
		$GEN_DIR = '.';
		
		$loader = new ThriftClassLoader();
		$loader->registerNamespace('Thrift', './');
		$loader->registerDefinition('shared', $GEN_DIR);
		$loader->registerDefinition('smd_api', $GEN_DIR);
		$loader->register();
		include_once './ApiCall.php';
		try
		{
			$socket = new TSocket ('localhost', 9000);
			$transport = new TBufferedTransport ($socket, 1024, 1024);
			$protocol = new TBinaryProtocol ($transport);
			$client = new \smd_api\ApiCallClient($protocol);
		
			$transport->open ();
		
			$ret = $client->ReloadStationSetting();
		
			$transport->close ();
			$socket->close();
			return $ret;
		}
		
		catch (TException $tx)
		{
			return -1;
		}
		
		return -2;
	}
	public function StatusChange($func, $id, $port=9000)
	{
		$GEN_DIR = '.';		
		$loader = new ThriftClassLoader();
		$loader->registerNamespace('Thrift', './');
		$loader->registerDefinition('shared', $GEN_DIR);
		$loader->registerDefinition('smd_api', $GEN_DIR);
		$loader->register();
		include_once './ApiCall.php';
		try
		{
			$socket = new TSocket ('localhost', $port);
			$transport = new TBufferedTransport ($socket, 1024, 1024);
			$protocol = new TBinaryProtocol ($transport);
			$client = new \smd_api\ApiCallClient($protocol);
		
			$transport->open ();
		
			$ret = $client->$func($id);
		
			$transport->close ();
			$socket->close();
			return $ret;
		}		
		catch (TException $tx)
		{
			var_dump($tx);
			return -1;
		}		
		return -2;
	}
	
	public function DoorControl($data_id, $mode)
	{
	    $GEN_DIR = '.';
	    $loader = new ThriftClassLoader();
	    $loader->registerNamespace('Thrift', './');
	    $loader->registerDefinition('shared', $GEN_DIR);
	    $loader->registerDefinition('smd_api', $GEN_DIR);
	    $loader->register();
	    include_once './ApiCall.php';
	    try
	    {
	        $socket = new TSocket ('localhost', 9000);
	        $transport = new TBufferedTransport ($socket, 1024, 1024);
	        $protocol = new TBinaryProtocol ($transport);
	        $client = new \smd_api\ApiCallClient($protocol);
	        $transport->open ();
	        $ret = $client->DoorControl($data_id,$mode);
	        $transport->close ();
	        $socket->close();
	        return $ret;
	    }
	    catch (TException $tx)
	    {
	        //var_dump($tx);
	        return -1;
	    }
	    return -2;
	}
		
// 		public function remoteForceOpenDoor($id)
// 		{
// 			$GEN_DIR = '.';
// 			$loader = new ThriftClassLoader();
// 			$loader->registerNamespace('Thrift', './');
// 			$loader->registerDefinition('shared', $GEN_DIR);
// 			$loader->registerDefinition('smd_api', $GEN_DIR);
// 			$loader->register();
// 			include './ApiCall.php';
// 			try
// 			{
// 				$socket = new TSocket ('localhost', 9000);
// 				$transport = new TBufferedTransport ($socket, 1024, 1024);
// 				$protocol = new TBinaryProtocol ($transport);
// 				$client = new \smd_api\ApiCallClient($protocol);
// 				$transport->open ();
// 				$ret = $client->remoteForceOpenDoor($id);
// 				$transport->close ();
// 				$socket->close();
// 				return $ret;
// 			}
// 			catch (TException $tx)
// 			{
// 				return -1;
// 			}
// 			return -2;
// 		}
}


