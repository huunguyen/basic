<?php
$uni_id = Yii::app()->user->getState('RTOuid');
$_mRTOsById = Yii::app()->user->getState($uni_id . '_mRTOsById');
?>

<h5>QUYỀN SẼ CẤP:</h5>
<?php
if (is_array($_mRTOsById) && (count($_mRTOsById) > 0)) {
    foreach ($_mRTOsById as $_mRTOById) {
        echo "{<input type='checkbox' name='_mRTOsById[]' id='_mRTOsById_" . $_mRTOById->name . "' data-unchecked='0' value='" . $_mRTOById->name . "'>[" . $_mRTOById->name . "]} ";
    }
}
?>
