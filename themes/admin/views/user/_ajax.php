
<!-- View Popup  -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'viewModal')); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>View User Details</h4>
</div>
<!-- Popup Content -->
<div class="modal-body">
<p>User Details</p>
</div>
<!-- Popup Footer -->
<div class="modal-footer">

<!-- close button -->
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Close',
    'url'=>'#',
    'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>
<!-- close button ends-->
</div>
<?php $this->endWidget(); ?>
<!-- View Popup ends -->