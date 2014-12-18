<h5>QUYỀN ĐÃ CẤP:</h5>
<?php                
if (is_array($_mRTOsById) && (count($_mRTOsById) > 0)) {
    foreach ($_mRTOsById as $_mRTOById) {
        echo $_mRTOById->name . ' ';
    }
}
?>  