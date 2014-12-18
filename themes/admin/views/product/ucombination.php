<?php

$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'sản phẩm'),
        ));
?>
<?php

$uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($pro_att));
Yii::app()->user->setState('uni_id', $uni_id);
//if (Yii::app()->user->hasState($uni_id . '_attributeList')) {
//    $data = Yii::app()->user->getState($uni_id . '_attributeList');
//} else
//    $data = array();
$data = array();
if (!$pro_att->isNewRecord) {
    if (isset($pro_att->tblAttributes)) {
        foreach ($pro_att->tblAttributes as $value) {
            $pro_att->_list[] = $value->id_attribute;
            $list = array("id_attribute" => $value->id_attribute, "name" => $value->name);
            $flag = false;
            if (empty($data))
                $data[] = $list;
            else {
                foreach ($data as $row) {
                    $diff = array_diff($list, $row);
                    if (empty($diff))
                        $flag = true;
                }
                if (!$flag)
                    $data[] = $list;
            }
        }
        Yii::app()->user->setState($uni_id . '_attributeList', $data);
    }
}
?>
<?php echo $this->renderPartial('_combination', array('model' => $model, 'pro_att' => $pro_att, 'files' => $files)); ?>
