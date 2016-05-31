<?php
/**
* �������ṩ���ͻ��˽�������XML-RPC�������˵ĺ���
* ������
* $host  ��Ҫ���ӵ�����
* $port  ���������Ķ˿�
* $rpc_server XML-RPC���������ļ�
* $request  ��װ��XML������Ϣ
* ���أ����ӳɹ��ɹ������ɷ������˷��ص�XML��Ϣ��ʧ�ܷ���false
*/
function rpc_client_call($host, $port, $rpc_server, $request) {
   //��ָ���ķ�������
   $fp = fsockopen($host, $port);
   //������Ҫ����ͨ�ŵ�XML-RPC�������˵Ĳ�ѯPOST������Ϣ
   $query = "POST $rpc_server HTTP/1.0\nUser_Agent: XML-RPC Client\nHost: ".$host."\nContent-Type: text/xml\nContent-Length: ".strlen($request)."\n\n".$request."\n";
   //�ѹ���õ�HTTPЭ�鷢�͸���������ʧ�ܷ���false
   if (!fputs($fp, $query, strlen($query))) {
       $errstr = "Write error";
       return false;
   }
   
   //��ȡ�ӷ������˷��ص�������Ϣ������HTTPͷ��XML��Ϣ
   $contents = '';
   while (!feof($fp)){
       $contents .= fgets($fp);
   }
   //�ر�������Դ�󷵻ػ�ȡ������
   fclose($fp);
   return $contents;
}
//��������RPC�������˵���Ϣ
//$host  = '172.27.23.1';
$host  = '192.168.254.128';
$port  = 80;

$rpc_server = '/rpc_server.php';
//����Ҫ���͵�XML������б����XML����Ҫ���õķ�����rpc_server��������get
$request = xmlrpc_encode_request('rpc_server', 'get');
//����rpc_client_call���������������͸�XML-RPC�������˺��ȡ��Ϣ
$response = rpc_client_call($host, $port, $rpc_server, $request);
//�����ӷ������˷��ص�XML��ȥ��HTTPͷ��Ϣ�����Ұ�XMLתΪPHP��ʶ����ַ���
$split = '<?xml version="1.0" encoding="iso-8859-1"?>';
$xml =  explode($split, $response);
$xml = $split . array_pop($xml);
$response = xmlrpc_decode($xml);
//�����RPC�������˻�ȡ����Ϣ
print_r($response);
?>