<?
//add FancyBox files, either use widget or do manually.
//have used widget for ease of explanation.  Manually would be a 'lighter' approach
$this->widget('application.modules.admin.extensions.fancybox.EFancyBox', array());
 
//create an ajax link which will call fancybox AFTER the ajax call completes
echo CHtml::ajaxLink('NameOfLink',Yii::app()->createUrl('fancy'),
     array('type'=>'POST', 'update'=>'#preview', 'complete'=>'afterAjax'));
?>
 
//add the div which will hold our ajax response
<div style="display:none;">
<div id="preview">
<!-- space here will be updated by ajax -->
</div>
</div>
<script>
    function reloadGrid(data) {
        $.fn.yiiGridView.update('books-grid');
    }
    function afterAjax()
{
$.fancybox({
        href : '#preview',
        scrolling : 'no',
        transitionIn : 'fade',
        transitionOut : 'fade', 
        //check the fancybox api for additonal config to add here   
        onClosed: function() { $('#preview').html(''); }, //empty the preview div
});
}
</script> 