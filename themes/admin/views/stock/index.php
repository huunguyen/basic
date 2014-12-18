<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Lô Hàng'),
        ));
?>
<?php
//$rs = $stock->searchProductInStock();
//dump($rs->getData());
?>
<?php
    echo $this->renderPartial('instock', array(            
        'model' => $stock,
            'pageSize' => $pageSize)
            ); 
    ?>
<?php
    echo $this->renderPartial('outstock', array(  
            'model' => $stock_ava,
            'pageSize' => $pageSize)
            );  
    ?>