<?php
$file = dirname(__FILE__).'/params.inc';
$content = file_get_contents($file);
$commonEnvParams = unserialize(base64_decode($content));
$commonParams = array(
    'com_name' => 'Cty QCDN',
    'com_email' => 'mail.khachhang.info@gmail.com',
    'com_address'=>'???',
    'com_phone'=>'???',
    'com_map' => ''
);
return CMap::mergeArray(        
        array(
            'salt'=>'P@bl0',
            'someOption'=>true,
        ),
        CMap::mergeArray($commonEnvParams, $commonParams)
    )
;
?>