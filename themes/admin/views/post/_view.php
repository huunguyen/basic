<div class="view">
    <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
        'heading'=>CHtml::encode($data->title),
    )); ?>
    <p><?php echo 'preg_match("/<section id=\'info\' class=\'info\'[^>]*>(.*)<\/section>/iU", $data->content,$data->info) ? $data->info[0] : $data->content'; ?></p>
    <p>
        Post date: <?php echo CHtml::encode($data->create_time);?> By <?php echo $data->author->username; ?>
    </p>
    <?php $this->endWidget(); ?>
</div>