<?php
$file = dirname(__FILE__).'/params.inc';
$content = file_get_contents($file);
$arr = unserialize(base64_decode($content));
return CMap::mergeArray(
        $arr,
        array(
            'salt'=>'P@bl0',
            'secret'=>'12345678',
            'size'=>'20',
            'color'=>'red',
        )
    )
;
?>