<div class="widget">
   <?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
//		'id_pack_group',
		'name',

    array(
                'name' => 'description_short',
                'type' => 'html',
                'value'=> $model->description_short
            ),
     array(
                'name' => 'description',
                'type' => 'html',
                'value'=> $model->description
            ),
		'date_add',
		'date_upd',
array(
                'name' => 'total_paid',
                'type' => 'number',
                'value'=> $model->total_paid
            ),
    array(
                'name' => 'Tổng tiền trả bằng chữ',
                'type' => 'html',
                'value'=> FinanceHelper::changeNumberToString($model->total_paid)
            ),
    array(
                'name' => 'total_paid_real',
                'type' => 'number',
                'value'=> $model->total_paid_real
            ),
    array(
                'name' => 'Tổng thực trả bằng chữ',
                'type' => 'html',
                'value'=> FinanceHelper::changeNumberToString($model->total_paid_real)
            ),
		'available_date',
		'active',
		'reduction_type',
		'reduction',
),
)); ?> 
</div>