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
                    'template' => '{show} {modify}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("user/roview", array("role"=>$data["name"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật NCC',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("user/roupdate", array("role"=>$data["name"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        )
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 120px; text-align: center;',
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
        'id' => 'InRoleGroup-grid',
        'dataProvider' => $userItem->searchInRoleGroup($rolegroup = $model->name),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà cung cấp. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'img',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("user/view", array("id"=>$data["id_user"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'email', 'header' => 'Thư điện tử'),
            array('name' => 'username', 'header' => 'Quyền Dành Riêng'),
            array('name' => 'default_role', 'header' => 'Quyền mặc định'),
            array('name' => 'max_level', 'header' => 'Mức quyền cao nhất'),
            array('name' => 'active', 
                 'header' => 'Trạng Thái',
                 'value'=>'Lookup::item("ActiveStatus", $data->active)',
                        'type'=>'html'),    
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{addSub}',
                'buttons' => array (
             'addSub' => array(
                'label' => "Thêm Quyền này đến Nhóm Quyền [$model->name]",
                'icon' => 'minus',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("user/removeSubRole", array("child"=>"'.$model->name.'", "parent"=>$data["username"]) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn them thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('InRoleGroup-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);    
                                $.fn.yiiGridView.update('InRoleGroup-grid');
                                $.fn.yiiGridView.update('NotInRoleGroup-grid');
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
        'id' => 'NotInRoleGroup-grid',
        'dataProvider' => $userItem->searchNotInRoleGroup($rolegroup = $model->name),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà cung cấp. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'img',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("user/view", array("id"=>$data["id_user"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'email', 'header' => 'Thư điện tử'),
            array('name' => 'username', 'header' => 'Quyền Dành Riêng'),
            array('name' => 'default_role', 'header' => 'Quyền mặc định'),
            array('name' => 'max_level', 'header' => 'Mức quyền cao nhất'),
            array('name' => 'active', 
                 'header' => 'Trạng Thái',
                 'value'=>'Lookup::item("ActiveStatus", $data->active)',
                        'type'=>'html'),    
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{addSub}',
                'buttons' => array (
             'addSub' => array(
                'label' => "Thêm Quyền này đến Nhóm Quyền [$model->name]",
                'icon' => 'tasks',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("user/addSubRole", array("child"=>"'.$model->name.'", "parent"=>$data["username"]) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn them thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('NotInRoleGroup-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);    
                                $.fn.yiiGridView.update('InRoleGroup-grid');
                                $.fn.yiiGridView.update('NotInRoleGroup-grid');
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

