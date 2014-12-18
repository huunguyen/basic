<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'sub-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'beforeValidate' => "js:function(form) {
            return true;
        }",
        'afterValidate' => "js:function(form, data, hasError) {
            if(hasError) {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = 'Bạn đã nhập thông tin nhưng chưa lưu lại trên server. Nếu bạn rời khỏi trang này lúc này dữ liệu bạn mới nhập sẽ mất và không được lưu lại';
                    return event.returnValue;
                });
                return false;
            }
            else {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = null;
                    return event.returnValue;
                });
                if(confirm('Dữ liệu bạn nhập đã chính xác. Bạn có muốn lưu thông tin này nhấn okie nếu không hãy nhân cancel.'))
                    return true;
                else
                    return false;
            }
        }"
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<div class="widget">
    <fieldset>
        <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
        <?php echo $form->errorSummary($model); ?>
    </fieldset>
    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 64, 'disabled' => $model->isNewRecord ? false : true)); ?>
    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 64)); ?>
    <?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
</div>

<div class="form-actions">    
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
</div>
<?php $this->endWidget(); ?>
<span class="clear"></span>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'old_rto-grid',
        'dataProvider' => $aOItem->searchByParent($parent = $model->name, $operator = 0),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà cung cấp. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Tên Quyền'),
            array('name' => 'title', 'header' => 'Tên dễ nhớ'),
            array('name' => 'type', 'header' => 'Loại quyền', 'value'=>'Lookup::item("TypeRoles", $data["type"])'),
            array('name' => 'name', 'header' => 'Quyền con[Kế thừa]','value'=>'$data["str_operator"]'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{removeSub}',
                'buttons' => array (
             'removeSub' => array(
                'label' => "Hủy Quyền này trong Nhóm Quyền [$model->name]",
                'icon' => 'minus',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("user/removeSubRole", array("parent"=>"'.$model->name.'", "child"=>$data["name"]) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn xóa thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('old_rto-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);    
                                $.fn.yiiGridView.update('old_rto-grid');
                                $.fn.yiiGridView.update('rto-grid');
                            },
                            error:function(data) {
                                console.log(data);                                
                            }
                        });
                        return false;
                        }",
            ),
        ),
                    'htmlOptions' => array(
                        'style' => 'width: 60px; text-align: center;',
                    ),
                )
        ),
    ));
    ?>
</div>
<span class="clear"></span>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'rto-grid',
        'dataProvider' => $aOItem->searchByNoParent($parent = $model->name, $operator = 0),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà cung cấp. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Tên Quyền'),
            array('name' => 'title', 'header' => 'Tên dễ nhớ'),
            //array('name' => 'type', 'header' => 'Loại quyền', 'value'=>'Lookup::item("TypeRoles", $data["type"])'),
            array('name' => 'name', 'header' => 'Quyền con[Kế thừa]','value'=>'$data["str_operator"]'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{addSub}',
                'buttons' => array (
             'addSub' => array(
                'label' => "Thêm Quyền này đến Nhóm Quyền [$model->name]",
                'icon' => 'tasks',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("user/addSubRole", array("parent"=>"'.$model->name.'", "child"=>$data["name"]) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn them thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('rto-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);    
                                $.fn.yiiGridView.update('old_rto-grid');
                                $.fn.yiiGridView.update('rto-grid');
                            },
                            error:function(data) {
                                console.log(data);                                
                            }
                        });
                        return false;
                        }",
            ),
        ),
                    'htmlOptions' => array(
                        'style' => 'width: 60px; text-align: center;',
                    ),
                )
        ),
    ));
    ?>
</div>
<span class="clear"></span>

