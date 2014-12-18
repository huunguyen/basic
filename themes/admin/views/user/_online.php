<?php $baseUrl = Yii::app()->request->baseUrl;?>
<?php
$onlines = User::model()->findAll(array(
  'condition' => 'level=:level',
  'limit' => 5,
  'params' => array(':level' => 8),
));
?>
<ul class="userList">
    <?php
    foreach ($onlines as $online) {
        ?>
    <li>
        <a href="#" title="">
            <img src="<?= $online->avatar; ?>" alt="<?= $online->author_name;?>" />
            <span class="contactName">
                <strong><?= $online->author_name;?></strong>
                <i>Quyền: <?= Lookup::item("AccessRole",$online->role)?></i></span>
            <span class="status_away"></span>
            <span class="clear"></span>
        </a>                        
    </li>
    
        <?php
    }
    ?>    
</ul>