<div style="width: 100%">
    <div class="title_cm">Nhận xét mới</div>
    <div id = 'ajaxRowcomment'>
        <?php foreach ($Feature['data_comment'] as $value): ?>
            <ul>
                <li class="ngh">Ngày <?php echo date("d-m-Y", strtotime($value->date_add)); ?></li>
                <li  id="title_comment"><?php echo StringHelper::Limit($value->message, 150); ?></li>
                <li  id="content_comment" style="display:none"><?php echo $value->message; ?></li>
                <li class="ngh1"><span class="boder_ctl"> <a href="javascript:void(0)"><?= $value->idCustomerThread->idCustomer->email ?></a></span></li>
                <li style="border-bottom: 1px solid #CCC;">&nbsp;</li>
            </ul>
        <?php endforeach; ?>
    </div>
</div>