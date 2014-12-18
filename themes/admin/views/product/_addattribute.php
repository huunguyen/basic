<?php
$uni_id = Yii::app()->user->getState('uni_id');
$_attributeList = Yii::app()->user->getState($uni_id . '_attributeList');
?>

<h5>Thuộc Tính Sẽ Tạo:</h5>
<?php
if (is_array($_attributeList) && (count($_attributeList) > 0)) {
    foreach ($_attributeList as $_attribute) {
        echo "[<input type='checkbox' checked name='_attribute[]' id='_attribute_" . $_attribute["id_attribute"] . "' data-unchecked='".$_attribute["id_attribute"]."' value='" . $_attribute["id_attribute"] . "'> - <b>" . $_attribute["name"] . "</b>]";
    }
}
?>