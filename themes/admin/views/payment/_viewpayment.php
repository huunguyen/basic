<div class="fluid">
    <div class="widget grid6">
        <div class="whead">
            <h6>Giỏ Hàng #<?php echo $model->id; ?> đặt bởi 
                <?php
                $cus = User::model()->findByPk($model->custommer_id);
                echo ($cus != null) ? $cus->author_name : 'Không xác ';
                ?></h6>
            <div class="clear"></div>            
        </div>
        <div class="body">           
            <div style="border-bottom:1px #dfdfdf solid; border-left:1px #dfdfdf solid; 
                 border-right:1px #dfdfdf solid;">  
                 <?php
                 $this->widget('bootstrap.widgets.TbDetailView', array(
                     'data' => $model,
                     'type' => 'striped condensed',
                     'attributes' => array(
                         'create_date',
                         'description',
                         array(
                             'name' => 'categories',
                             'header' => 'Loại',
                             'value' => Lookup::item("BooksCategories", $model->categories),
                             'htmlOptions' => array('style' => 'width: auto'),
                         ),
                         array(
                             'name' => 'status',
                             'header' => 'Trạng thái',
                             'value' => Lookup::item("BooksStatus", $model->status),
                             'htmlOptions' => array('style' => 'width: 80px'),
                         ),
                         'cause_effect',
                         'shoppingcartkey',
                         'paymentkey',
                         'totalofmoney',
                     ),
                 ));
                 ?>
            </div>
        </div>
    </div>
    <div class="widget grid6">
        <div class="whead">
            <h6>Chi Tiết Giỏ Hàng:</h6>
            <div class="clear"></div></div>
        <div class="body">           
            <div style="border-bottom:1px #dfdfdf solid; border-left:1px #dfdfdf solid; 
                 border-right:1px #dfdfdf solid;">                     
                <table class="table table-condensed table-hover" id="table_area" name="table_area">
                    <tbody> 
                        <?php
                        $pattern = '/\d+/';
                        if (isset($model->books_news)) {
                            foreach ($model->books_news as $banner) {
                                preg_match($pattern, $banner->cost, $matches);
                                ?>
                                <tr> 
                                    <th><?= '[' . $banner->booksnews_news->title . ']: <br/>Từ ngày [' . $banner->_start_books_date . '] đến ngày [' . $banner->_end_books_date . ']<br/>Đơn Giá: ' . $banner->cost . ' <br/>Bằng chữ: ' . FinanceHelper::changeNumberToString($matches[0]); ?></th>
                                </tr>
                                <?php
                            }
                        }
                        if (isset($model->books_banner)) {
                            foreach ($model->books_banner as $banner) {
                                preg_match($pattern, $banner->cost, $matches);
                                ?>
                                <tr> 
                                    <th><?= '[' . $banner->banner->title . ']: <br/>Từ ngày [' . $banner->_start_books_date . '] đến ngày [' . $banner->_end_books_date . ']<br/>Đơn Giá: ' . $banner->cost . ' <br/>Bằng chữ: ' . FinanceHelper::changeNumberToString($matches[0]); ?></th>
                                </tr>
                                <?php
                            }
                        }
                        ?>                        
                    </tbody>               
                </table>
            </div>
        </div>
    </div>
</div>

<?php
if (($cus != null) && isset($cus->address)) {
    ?>
    <h1>Địa chỉ #<?php echo $cus->address->id; ?></h1>
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $cus->address,
        'attributes' => array(
            'address',
            'distric',
            'city_id',
            'postal_code',
            'phone',
            'email',
        ),
    ));
    $address = Address::model()->findAllByAttributes(array(
        'parent_id' => $cus->address->id
    ));
    foreach ($address as $value) {
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $value,
            'attributes' => array(
                'address',
                'distric',
                'city_id',
                'postal_code',
                'phone',
                'email',
            ),
        ));
    }
}
?>
<div class="fluid">
    <div class="grid12">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $payment,
            'attributes' => array(
                'amount',
                'money_total',
                'methodsofpayment',
                'payment_date',
                'payerid',
            ),
        ));
        ?>
    </div>    
</div>