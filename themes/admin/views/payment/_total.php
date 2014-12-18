<?php
    if (preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/", isset($start_date)?$start_date:'') && preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/", isset($end_date)?$end_date:'')) {
        $format = 'Y-m-d H:i:s';
        $sdate = DateTime::createFromFormat($format, $start_date);
        $start_date = $sdate->format("d/m/Y");
        $edate = DateTime::createFromFormat($format, $end_date);
        $end_date = $edate->format("d/m/Y");
    }
    ?>
<div class="whead">
    <h6>Kết Quả Thống Kê Từ Ngày:[<?=  isset($start_date)?$start_date:''; ?>]-[<?=  isset($end_date)?$end_date:''; ?>]</h6>
            <div class="clear"></div>            
        </div>
        <div class="body">           
            <div style="border-bottom:1px #dfdfdf solid; border-left:1px #dfdfdf solid; 
                 border-right:1px #dfdfdf solid;">                     
               <table class="table table-condensed table-hover" id="table_area" name="table_area">
    <tbody> 
        <tr> 
            <th><?= "Tổng tiền: " . $total; ?></th>
        </tr>  
        <tr> 
            <th><?= "Tổng tiền bằng chữ: " . FinanceHelper::changeNumberToString($total); ?></th>
        </tr> 
    </tbody>               
</table>
            </div>
        </div>