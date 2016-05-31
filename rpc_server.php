<?php
/**
* �������ṩ��RPC�ͻ��˵��õĺ���
* ������
* $method �ͻ�����Ҫ���õĺ���
* $params �ͻ�����Ҫ���õĺ����Ĳ�������
* ���أ�����ָ�����ý��
*/
function rpc_server_func($method, $params) {
	$parameter = $params[0];
   	if ($parameter == "get"){
       $return = array('zbc'=>'123','bcd'=>'456');
   	}else{
       $return = 'Not specify method or params';
   	}
   return $return;
}
//����һ��XML-RPC�ķ�������
$xmlrpc_server = xmlrpc_server_create();
//ע��һ���������˵��õķ���rpc_server��ʵ��ָ�����rpc_server_func����
xmlrpc_server_register_method($xmlrpc_server, "rpc_server", "rpc_server_func");
//���ܿͻ���POST������XML����
$request = $HTTP_RAW_POST_DATA;
//ִ�е��ÿͻ��˵�XML������ȡִ�н��
$xmlrpc_response = xmlrpc_server_call_method($xmlrpc_server, $request, null);
//�Ѻ��������Ľ��XML�������
header('Content-Type: text/xml');
echo $xmlrpc_response;
//����XML-RPC����������Դ
xmlrpc_server_destroy($xmlrpc_server);
?>