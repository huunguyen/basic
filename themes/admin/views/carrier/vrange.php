<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà vận chuyển'),
        ));
?>

<div class="widgetrow-fluid">
    <h1>Thông tin Nhà Phân Phối [<?php echo $model->id_carrier; ?>] [<?php echo $model->name; ?>]</h1>
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id_carrier',
        'name',
        'url',
        'shipping_handling',
        'range_behavior',
        'is_free',
        'shipping_external',
        'need_range',
        'shipping_method',
        'max_width',
        'max_height',
        'max_depth',
        'max_weight'
    ),
        )
);
?>
</div>
<div class="row-fluid">      
    <?= $this->renderPartial('view_delivery', array('model' => $model),false,false);   ?>
</div>
<br/>
<div class="widgetrow-fluid">
    <?php
if ($model->range_behavior <= 1):
    $this->widget(
            'bootstrap.widgets.TbButtonGroup', array(
        'buttons' => array(
            array('label' => 'Tạo Bản Giá Vận Chuyển Theo [<b>Tổng Giá Của Hóa Đơn</b>]',
                'encodeLabel' => false,
                'url' => Yii::app()->createUrl('carrier/createRange', array('id' => $model->id_carrier)
                )
            ),
        ),
            )
    );
elseif ($model->range_behavior == 2):
    $this->widget(
            'bootstrap.widgets.TbButtonGroup', array(
        'buttons' => array(
            array('label' => 'Tạo Bản Giá Vận Chuyển Theo [<b>Tổng Cân Nặng Của Hàng Hóa</b>]',
                'encodeLabel' => false,
                'url' => Yii::app()->createUrl('carrier/createRange', array('id' => $model->id_carrier)
                )
            ),
        ),
            )
    );
elseif ($model->range_behavior == 3):
    $this->widget(
            'bootstrap.widgets.TbButtonGroup', array(
        'buttons' => array(
            array('label' => 'Tạo Bản Giá Vận Chuyển Theo [<b>Tổng Quảng Đường Vận Chuyển Của Hàng Hóa</b>]',
                'encodeLabel' => false,
                'url' => Yii::app()->createUrl('carrier/createRange', array('id' => $model->id_carrier)
                )
            ),
        ),
            )
    );
else:
    $this->widget(
            'bootstrap.widgets.TbButtonGroup', array(
        'buttons' => array(
            array('label' => 'Tạo Mới Giá - Giá Trị & Cân Nặng & Khoản Cách',
                'encodeLabel' => false,
                'url' => Yii::app()->createUrl('carrier/createRange', array('id' => $model->id_carrier)
                )
            ),
        ),
            )
    );
endif;

$this->widget(
            'bootstrap.widgets.TbButtonGroup', array(
        'buttons' => array(
            array('label' => 'Tạo Mới Giá - Giá Trị & Cân Nặng & Khoản Cách',
                'encodeLabel' => false,
                'url' => Yii::app()->createUrl('carrier/sCRange', array('id' => $model->id_carrier)
                )
            ),
        ),
            )
    );
?>
</div>
