<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà vận chuyển'),
        ));
?>
<div class="row-fluid">      
    <?= $this->renderPartial('view_delivery', array('model' => $model),false,false);   ?>
</div>
<div id="data" class="row-fluid">
    <?php
    if ($model->range_behavior <= 1):
        echo $this->renderPartial('_form_rprice', array('model' => $model,
            'delivery' => $delivery,
            'prange' => $prange
                )
        );
    elseif ($model->range_behavior == 2):
        echo $this->renderPartial('_form_rweight', array('model' => $model,
            'delivery' => $delivery,
            'wrange' => $wrange,
                )
        );
    elseif ($model->range_behavior == 3):
        echo $this->renderPartial('_form_rdistant', array('model' => $model,
            'delivery' => $delivery,
            'drange' => $drange
                )
        );
    else:
        echo $this->renderPartial('_form_range', array('model' => $model,
            'delivery' => $delivery,
            'prange' => $prange,
            'wrange' => $wrange,
            'drange' => $drange
                )
        );
    endif;
    ?>
</div>