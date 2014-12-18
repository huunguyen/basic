<div class="nNote nSuccess">
    <p>Chúc mừng bạn đã giao dịch thành công!!! Xin chân thành cám ơn</p>
</div>
<?php if(isset($_GET['model'])):?>
 Nội dung thanh toán:<strong style="font-weight: bold;color: red">thanh toan don hang <?=$_GET['model']?></strong>. <br>
 Khi chuyển khoản quý khách vui lòng điền thông tin này vào ghi chú.<br>
 Quý khách vui lòng ghi đúng nội dung chuyển khoản theo cú pháp sau:<strong style="font-weight: bold;color: red">thanh toan don hang <?=$_GET['model']?></strong>.<br>
 Quý khách có thể vào trang cá nhân lấy lại mã này(<b style="color: red">Mã đơn hàng</b>) trong đơn hàng.

<?php endif; ?>