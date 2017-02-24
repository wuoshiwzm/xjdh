<?php
require_once './Thrift/ClassLoader/ThriftClassLoader.php';

use Thrift\ClassLoader\ThriftClassLoader;

$GEN_DIR = '.';

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', './');
$loader->registerDefinition('shared', $GEN_DIR);
$loader->registerDefinition('smd_api', $GEN_DIR);
$loader->register();
include './ApiCall.php';
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;
try
{
  $socket = new TSocket ('localhost', 9090);
  $transport = new TBufferedTransport ($socket, 1024, 1024);
  $protocol = new TBinaryProtocol ($transport);
  $client = new \smd_api\ApiCallClient($protocol);

  $transport->open ();

  $ret = $client->SmdDeviceChange(1);

  $transport->close ();
  echo $ret;
}

catch (TException $tx)
{
}
