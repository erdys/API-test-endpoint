<?php
    $url = "http://localhost/test_api";
function do_post_request($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
                array(
                     'Content-Type: application/json',
                     'Content-Length: ' . strlen($data)
                )
    );

    return curl_exec($ch);
}

    $clientId = '';
    $apiKey = '';
    $apiSecret = ''; 
    $endpoint = "www.salesmanago.pl"; 

   $data = array( 
     'clientId' => $clientId,
     'apiKey' => $apiKey, 
     'requestTime' => time(), 
     'sha' => sha1($apiKey . $clientId . $apiSecret), 
     'contact' => array(
          'company' => 'Testowa', 
          'email' => 'test.api@gmail.com', 
          'name' => 'TEST API', 
          'phone' => '666', 
          'state' => 'CUSTOMER',
           ), 
     'owner' => 'admin@localhost.pl',
     'tags' => array('TEST_API'), 
     'removeTags' => array(''),
     'properties' => array('page' => 'rejestracja'), 
     'lang' => 'PL',
     'useApiDoubleOptIn' => true,
     'forceOptIn' => true,
     'forceOptOut' => false,
     'forcePhoneOptIn' => true,  
     'forcePhoneOptOut' => false,        
     'birthday' => '19800207'
     );

    $json = json_encode($data);

    $result = do_post_request('http://' . $endpoint .'/api/contact/upsert', $json);

    echo 'JSON Request:<br/><br/><pre>' . $json . '</pre>';
    echo 'JSON Response:<br/><br/><pre>' . $result . '</pre>';

    $r = json_decode($result);

    $contactId = $r->{'contactId'};

   echo 'New contact ID: <pre>' . $contactId . '</pre><br/><br/>';

?>