<?php $this->pageTitle = $category->name; ?>

<?php $this->renderpartial("categorys", array('groups'=>$groups,'category' => $category, 'parent' => $parent, 'child' => $child, 'model1' => $model1, 'model2' => $model2, 'model3' => $model3)); ?>

<div id="title" style="margin-top: 10px;width:98%;float: left;color: red">
    <?= $category->name; ?>
</div>
<?php $this->renderpartial('products',array('models' => $models,'pages' => $pages)); ?>