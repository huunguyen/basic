<script type="text/javascript">
function getDynamicDataForPost(){
    Obj=new Object();
    Obj.w=encodeURIComponent($("#searchpost").val());  
    Obj.s=1;  
    return $.param(Obj);
}
</script>
<ul class="messagesOne" id="messagesOne">
    <!-- Enter message -->      
        <li>     
            <div class="enterMessage">
                <input type="text" name="Tìm kiếm Tin Hệ Thống" id="searchpost" placeholder="tìm kiếm tin ..." />
                <div class="sendBtn">
                    <?php
                    echo CHtml::ajaxSubmitButton('Tìm kiếm', CHtml::normalizeUrl(array('site/search')), array(
                        'error' => 'js:function(){
                                            alert(\'error\');
                                        }',
                        'beforeSend' => 'js:function( jqXHR, settings ){
                                        var search = $.trim($("#searchpost").val());                            
                                        if((search=="") || (search.length <= 2)){ 
                                            alert("Bạn chưa nhập dữ liệu để tìm kiếm Hoặc Chuổi tìm kiếm nhỏ hơn 3 ký tự. Ok để thoát");                                    
                                            return false;
                                        }
                                        else{
                                        var list=search.split(" ");
                                            var newsearch = "";
                                        try {
                                            for(si=0; si< list.length; si++){
                                                var level = list[si];
                                                if( ( 3 <= level.length) && (level.length <= 32) ) {
                                                    newsearch += (newsearch == "")?level:(" "+level);
                                                }
                                            }
                                            if(newsearch.length >= 3){
                                                search = newsearch;
                                            }
                                            else 
                                            {
                                                return false;
                                            }
                                        }
                                        catch(exception){ 
                                            return false;
                                        }                                       
                                            settings.url +=  "?w="+encodeURIComponent(search)+"&s=1";  
                                            if(confirm("Bạn muốn hiển thị kết quả ở một của sổ khác?")){
                                                $("#searchpost").val(""); 
                                                window.open(settings.url,"search");
                                                return false;
                                            }
                                            else{ 
                                                $("#AjaxLoader").show();
                                                }
                                            }
                                        }',
                        'success' => 'js:function(data){
                                            $("#resultsearchpost").html(data);
                                            $("#searchpost").val(""); 
                                        }',
                        'complete' => 'js:function(){                             
                                            $("#AjaxLoader").hide();                                             
                                        }',
                        'type' => 'post',
                        //'dataType'=>'json',
                        'data'=>'js:jQuery(this).parents("form").serialize()+"&"+getDynamicDataForPost()',
                        'cache' => 'false',
                            ), 
                            array('class' => "buttonS bLightBlue",'id' => 'post-message-'.uniqid()));
                    ?>
                </div>
            </div>
        </li>  
        </ul>  
<div style="clear:both;"></div>
<div id="resultsearchpost"></div>             

<?php
$form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation' => true,
    'id' => 'post-grid' . uniqid(),
        ));
?>
<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'post-grid',
    'dataProvider' => $dataProvider,
    //'filter'=>$dataProvider,
    //'ajaxUrl'=> Yii::app()->createUrl('post/grid', array('catid' => $catid)),
    'pagerCssClass' => 'pagination pagination-right',
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Hiển thị từ {start}-{end} của {count} kết quả.',
    'columns' => array(
        array(
            'id' => 'autoId',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        array('name' => 'title',
            'header' => 'Tựa đề',
            'value' => 'CHtml::link($data->title, Yii::app()->controller->createUrl("/$data->slug"), array("target"=>"_self"))',
            'htmlOptions' => array('style' => 'width: auto'),
            'type' => 'html',
        ),
        /*
          array('name' => 'content',
          'header' => 'Nội dung chính',
          'value' => 'preg_match(\'/<section\s+id="info"\s+class="info"[^>]*>(.*)<\/section>/siU\', $data->content,$data->info) ? $data->info[1] : preg_match(\'/<section id="info" class="info"[^>]*>(.*)<\/section>/siU\', $data->content,$data->info)? $data->info[1] : $data->content',
          'type' => 'raw',
          'htmlOptions' => array('style' => 'width: auto')
          ), */
        array(
            'name' => 'create_time',
            'header' => 'Ngày tạo',
            'value' => '$data->create_time',
            'htmlOptions' => array('style' => 'width: 100px'),
            'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
        ),
        array(
            'name' => 'categories',
            'header' => 'Danh mục',
            'value' => 'Lookup::item("categories",$data->categories)',
            'htmlOptions' => array('style' => 'width: 100px'),
            'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
        ),
        array('name' => 'category.name', 
            'header' => 'Mục con', 
            'htmlOptions' => array('style' => 'width: 100px'),
            'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
            ),
        array(
            'name' => 'status',
            'header' => 'Trạng thái',
            'value' => 'Lookup::item("PostStatus",$data->status)',
            'htmlOptions' => array('style' => 'width: 40px'),
            'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Chức năng',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("post/view",array("id"=>$data["id"],"title"=>PostHelper::TitleVNtoEN($data["title"])))',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("post/update",array("id"=>$data["id"]))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("post/delete",array("id"=>$data["id"]))',
            'htmlOptions' => array('style' => 'width: 80px'),
        ),
    /*
      array(
      'class'=>'bootstrap.widgets.TbButtonColumn',
      'header' => 'Phần phụ',
      'template'=>'{add} {print_act}',
      'buttons'=>array
      (
      'add' => array
      (
      'label'=>'Thêm trả lời',
      'icon'=>'plus',
      'url'=>'Yii::app()->createUrl("post/answer", array("post_id"=>$data["id"]))',
      'options'=>array(
      'class'=>'view',
      ),
      ),
      'print_act' => array
      (
      'label'=>'In thông tin',
      'icon'=>'print',
      'url'=>'Yii::app()->createUrl("post/printAct", array("id"=>$data["id"]))',
      'options'=>array(
      'class'=>'view',
      ),
      ),
      ),
      'htmlOptions'=>array(
      'style'=>'width: 55px',
      ),
      ) */
    ),
));
?>
<script>
    function reloadGrid(data) {
        $.fn.yiiGridView.update('post-grid');
    }
</script>
<?php echo CHtml::ajaxSubmitButton('Filter', array('post/ajaxupdate'), array(), array("style" => "display:none;")); ?>

<?php echo CHtml::ajaxSubmitButton('Đang soạn', array('post/ajaxupdate', 'act' => 'doDRAFT'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>

<?php echo CHtml::ajaxSubmitButton('Xuất bản', array('post/ajaxupdate', 'act' => 'doPUBLISHED'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>


<?php echo CHtml::ajaxSubmitButton('Chờ duyệt', array('post/ajaxupdate', 'act' => 'doPENDING'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>
<?php echo CHtml::ajaxSubmitButton('Xóa Tạm', array('post/ajaxupdate', 'act' => 'doSUSPEND'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>

<?php echo CHtml::ajaxSubmitButton('Xóa', array('post/ajaxupdate', 'act' => 'doDELETED'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>

<?php $this->endWidget(); ?>
<div style="clear:both; height: 5px;"></div>