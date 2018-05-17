<?php

$client=new SoapClient('http://localhost/soap_and_rope/web/index.php/soap/wsdl', [
    'login' => 'admin',
    'password' => 'admin'
]);
/*$header = new SoapHeader('NAMESPACE', 'authorization', ['login' => 'admin', 'password' => '1234'], false);
$client->__setSoapHeaders($header);*/

echo $client->getHello('1212!');  //Hello,World!

