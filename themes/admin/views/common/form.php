<!-- The file upload form used as target for the file upload widget -->
<div style="clear:both;height: 10px;"></div>
<?php echo CHtml::beginForm($this->url, 'post', $this->htmlOptions); ?>
<div class="fileupload-buttonbar" >
    <div class="controls">
        <!-- The fileinput-button span is used to style the file input field as button -->
        <div class="span5">
           <span class="btn btn-success fileinput-button"> <i class="icon-plus icon-white"></i> <span>Chọn...</span>
            <?php
            if ($this->hasModel()) :
                echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this->value, $htmlOptions) . "\n";
            endif;
            ?>
        </span> 
        </div>        
        <div class="span5">
            <button type="submit" class="btn btn-primary start">
            <i class="icon-upload icon-white"></i>
            <span>Lưu dữ Liệu</span>
        </button>
        <button type="reset" class="btn btn-warning cancel">
            <i class="icon-ban-circle icon-white"></i>
            <span>Hủy bỏ</span>
        </button>
        <button type="button" class="btn btn-danger delete">
            <i class="icon-trash icon-white"></i>
            <span>Xóa dữ liệu</span>
        </button>
        <input type="checkbox" class="toggle">
        </div>        
    </div>
    <div class="controls">
        <!-- The global progress bar -->
        <div class="progress progress-success progress-striped active fade">
            <div class="bar" style="width:0%;"></div>
        </div>
    </div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>
<!-- The table listing the files available for upload/download -->
<div class="row-fluid control-group">
    <table class="table table-striped">
        <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
    </table>
</div>
<?php echo CHtml::endForm(); ?>

