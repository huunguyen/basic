    <?php
    $count = 1; $flag = false;
    if ($model->range_behavior <= 1):
        if (!empty($model->deliveries)):
            foreach ($model->deliveries as $value) {
            if(($count>1)&&($count%4==1)) {
                echo '</div><div class="row-fluid">';
                $flag = true;
            }
                ?>
                <div class="widget grid3">
                    <?php
                    $this->widget('bootstrap.widgets.TbDetailView', array(
                        'data' => $value,
                        'attributes' => array(
                            'id_delivery',
                            array(
                                'label' => $value->idZone->getAttributeLabel('name'),
                                'value' => "<b>".$value->idZone->name."</b>[".$value->idZone->idCity->iso_code."]",
                                'type' => 'html'
                            ),
                            'range_price',
                            array(
                                'label' => $value->rangePrice->getAttributeLabel('delimiter1'),
                                'value' => $value->rangePrice->delimiter1
                            ),
                            array(
                                'label' => $value->rangePrice->getAttributeLabel('delimiter2'),
                                'value' => $value->rangePrice->delimiter2
                            ),
                            'price'
                        ),
                            )
                    );
                    ?>
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbButton', array(
                        'encodeLabel' => false,
                        'buttonType' => 'submit',
                        'type' => 'danger',
                        'label' => "Xóa Giá Trong [<b>$value->id_zone</b>]",
                        'htmlOptions' => array(
                            'style' => 'float:center;',
                            'id' => uniqid(), //has to be in htmlOptions ...
                            'ajax' => array(
                                'type' => 'POST',
                                'data' => "js:$(this).serialize()",
                                //'dataType'=>'json',
                                'url' => Yii::app()->createUrl('carrier/viewRange', array('id' => $model->id_carrier, 'id_delivery' => $value->id_delivery, 'id_range_price' => $value->rangePrice->id_range_price, 'act' => 'del')
                                ),
                                'beforeSend' => "js:function(jqXHR, settings) {
                                   console.log(jqXHR);
                                   console.log(settings);                                   
                                   if(!confirm('Bạn muốn xóa [Giá] trong [khu vực [$value->id_zone]] này?')) return false;
                                   }",
                                'success' => "js:function(data) {
                                   //console.log(data);                                   
                                   location.reload();
                                   }",
                                'error' => "js:function(textStatus) {
                                     console.log(textStatus);
                                     }",
                                //'replace' => '#price-form',
                            ),
                        )
                            )
                    );
                    ?>      
                </div>
                <?php
                $count++;
            }
            echo ($flag)?'</div>':"";
        endif; 
        elseif ($model->range_behavior == 2):
        if (!empty($model->deliveries)):
            foreach ($model->deliveries as $value) {
            if(($count>1)&&($count%4==1)) {
                echo '</div><div class="row-fluid">';
                $flag = true;
            }
                ?>
                <div class="widget grid3">
                    <?php
                    $this->widget('bootstrap.widgets.TbDetailView', array(
                        'data' => $value,
                        'attributes' => array(
                            'id_delivery',
                            array(
                                'label' => $value->idZone->getAttributeLabel('name'),
                                'value' => "<b>".$value->idZone->name."</b>[".$value->idZone->idCity->iso_code."]",
                                'type' => 'html'
                            ),
                            'range_weight',
                            array(
                                'label' => $value->rangeWeight->getAttributeLabel('delimiter1'),
                                'value' => $value->rangeWeight->delimiter1
                            ),
                            array(
                                'label' => $value->rangeWeight->getAttributeLabel('delimiter2'),
                                'value' => $value->rangeWeight->delimiter2
                            ),
                            'price'
                        ),
                            )
                    );
                    ?>
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbButton', array(
                        'encodeLabel' => false,
                        'buttonType' => 'submit',
                        'type' => 'danger',
                        'label' => "Xóa Khối Lượng Trong [<b>$value->id_zone</b>]",
                        'htmlOptions' => array(
                            'style' => 'float:center;',
                            'id' => uniqid(), //has to be in htmlOptions ...
                            'ajax' => array(
                                'type' => 'POST',
                                'data' => "js:$(this).serialize()",
                                //'dataType'=>'json',
                                'url' => Yii::app()->createUrl('carrier/viewRange', array('id' => $model->id_carrier, 'id_delivery' => $value->id_delivery, 'id_range_weight' => $value->rangeWeight->id_range_weight, 'act' => 'del')
                                ),
                                'beforeSend' => "js:function(jqXHR, settings) {
                                   console.log(jqXHR);
                                   console.log(settings);                                   
                                   if(!confirm('Bạn muốn xóa [Khối Lượng] trong [khu vực [$value->id_zone]] này?')) return false;
                                   }",
                                'success' => "js:function(data) {
                                   //console.log(data);                                   
                                   location.reload();
                                   }",
                                'error' => "js:function(textStatus) {
                                     console.log(textStatus);
                                     }",
                                //'replace' => '#price-form',
                            ),
                        )
                            )
                    );
                    ?>      
                </div>
                <?php
                $count++;
            }
            echo ($flag)?'</div>':"";
        endif; 
        elseif ($model->range_behavior == 3):
        if (!empty($model->deliveries)):
            foreach ($model->deliveries as $value) {
            if(($count>1)&&($count%4==1)) {
                echo '</div><div class="row-fluid">';
                $flag = true;
            }
                ?>
                <div class="widget grid3">
                    <?php
                    $this->widget('bootstrap.widgets.TbDetailView', array(
                        'data' => $value,
                        'attributes' => array(
                            'id_delivery',
                            array(
                                'label' => $value->idZone->getAttributeLabel('name'),
                                'value' => "<b>".$value->idZone->name."</b>[".$value->idZone->idCity->iso_code."]",
                                'type' => 'html'
                            ),
                            'range_distant',
                            array(
                                'label' => $value->rangeDistant->getAttributeLabel('delimiter1'),
                                'value' => $value->rangeDistant->delimiter1
                            ),
                            array(
                                'label' => $value->rangeDistant->getAttributeLabel('delimiter2'),
                                'value' => $value->rangeDistant->delimiter2
                            ),
                            'price'
                        ),
                            )
                    );
                    ?>
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbButton', array(
                        'encodeLabel' => false,
                        'buttonType' => 'submit',
                        'type' => 'danger',
                        'label' => "Xóa Khoản Cách Trong [<b>$value->id_zone</b>]",
                        'htmlOptions' => array(
                            'style' => 'float:center;',
                            'id' => uniqid(), //has to be in htmlOptions ...
                            'ajax' => array(
                                'type' => 'POST',
                                'data' => "js:$(this).serialize()",
                                //'dataType'=>'json',
                                'url' => Yii::app()->createUrl('carrier/viewRange', array('id' => $model->id_carrier, 'id_delivery' => $value->id_delivery, 'id_range_distant' => $value->rangeDistant->id_range_distant, 'act' => 'del')
                                ),
                                'beforeSend' => "js:function(jqXHR, settings) {
                                   console.log(jqXHR);
                                   console.log(settings);                                   
                                   if(!confirm('Bạn muốn xóa [Khoản Cách] trong [khu vực [$value->id_zone]] này?')) return false;
                                   }",
                                'success' => "js:function(data) {
                                   //console.log(data);                                   
                                   location.reload();
                                   }",
                                'error' => "js:function(textStatus) {
                                     console.log(textStatus);
                                     }",
                                //'replace' => '#price-form',
                            ),
                        )
                            )
                    );
                    ?>      
                </div>
                <?php
                $count++;
            }
            echo ($flag)?'</div>':"";
        endif; 
        else:
            $this->widget(
                    'bootstrap.widgets.TbButtonGroup', array(
                'buttons' => array(
                    array('label' => 'Tạo Mới Giá - Giá Trị & Cân Nặng & Khoản Cách',
                        'encodeLabel' => false,
                        'url' => Yii::app()->createUrl('carrier/createRange', array('id' => $model->id_carrier)
                        )
                    ),
                ),
                    )
            );
        endif;
        ?>