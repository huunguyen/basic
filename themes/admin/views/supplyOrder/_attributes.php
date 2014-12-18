<?php $autoid = uniqid(); ?>
<script type="text/javascript">
    var baseUrl = "<?= Yii::app()->request->baseUrl ?>";
    var autoid = "<?= $autoid; ?>";
</script>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'id' => $autoid,
    'dataProvider' => $pro_att->searchByProduct($product->id_product),
    'pagerCssClass' => 'pagination pagination-right',
    'template' => '{summary} {items} {pager}',
    'enablePagination' => true,
    'summaryText' => 'Tất cả Nhà sản xuất. Hiển thị từ {start}-{end} của {count} kết quả.',
    'columns' => array(
        array('name' => 'fullname', 'header' => 'Tên sản phẩm'),
        array('name' => 'price', 'header' => 'Giá bán lẻ'),
        array('name' => 'wholesale_price', 'header' => 'Giá sỉ'),
        array('name' => 'quantity', 'header' => 'Số lượng'),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Xử lý',
            'template' => '{add}',
            'buttons' => array
                (
                'add' => array(
                    'label' => 'Thêm Sản phẩm vào đơn hàng',
                    'icon' => 'shopping-cart',
                    //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                    'url' => 'Yii::app()->createUrl("supplyOrder/addProduct", array("id_supply_order"=>' . $model->id_supply_order . ', "id_product"=>$data["id_product"], "id_product_attribute"=>$data["id_product_attribute"]) )',
                    'click' => "function() {
                        $.fn.yiiGridView.update('product3-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('product1-grid');
                                $.fn.yiiGridView.update('product2-grid');
                                $.fn.yiiGridView.update('product3-grid');
                            },
                            error:function(data) {
                                console.log(data);                                
                            }
                        });
                        return false;
                        }",
                ),
            ),
            'htmlOptions' => array(
                'style' => 'width: 20px; text-align: center; vertical-align: middle',
            ),
        ),
    ),
));
?>
<script type="text/javascript">
    /*<![CDATA[*/
    jQuery(function($) {
        jQuery(document).on('click', '#' + autoid + ' a.add', function() {
            if (!confirm('Bạn muốn thêm thuộc tính này?'))
                return false;
            $.fn.yiiGridView.update(autoid, {
                type: 'POST',
                url: $(this).attr('href'),
                success: function(data) {
                    console.log(data);
                    $.fn.yiiGridView.update('product1-grid');
                    $.fn.yiiGridView.update('product2-grid');
                },
                error: function(data) {
                    console.log(data);
                }
            });
            return false;
        });
        jQuery('#'.$autoid).yiiGridView({'ajaxUpdate': [autoid], 'ajaxVar': 'ajax', 'pagerClass': 'pagination pagination-right', 'loadingClass': 'grid-view-loading', 'filterClass': 'filters', 'tableClass': 'items table table-striped table-bordered table-condensed', 'selectableRows': 1, 'enableHistory': false, 'updateSelector': '{page}, {sort}', 'filterSelector': '{filter}', 'pageVar': 'Product_page', 'afterAjaxUpdate': function() {
                jQuery('.popover').remove();
                jQuery('[data-toggle=popover]').popover();
                jQuery('.tooltip').remove();
                jQuery('[data-toggle=tooltip]').tooltip();
            }});
    });
    /*]]>*/
</script>