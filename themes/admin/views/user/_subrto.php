<div style="clear:both;height: 10px;"></div>
<?php
if (Yii::app()->user->checkAccess('supper')) {
    echo CHtml::ajaxLink(
            '<i class="icon-white icon-trash"></i>' . Yii::app()->user->hasState('nameofparent')?'Xóa Quyền [['.Yii::app()->user->getState("nameofparent").']]':'Xóa Quyền Đang Xem', Yii::app()->createUrl('user/deleteRPC'), array(// ajaxOptions
        'type' => 'POST',
        'beforeSend' => "function( jqXHR, settings )
                     {                     
                        if ($('#currentrole').length > 0) {
                           var parent = $('#currentrole').text();                           
                           settings.url +=  '?role='+parent; 
                           if(confirm('Bạn có muốn xóa quyền <b>' + parent +'</b> và Quyền con của nó?. Nếu bạn không chắc chắn những gì đang làm xin vui lòng hủy lệnh này')){
                                if(confirm('Bạn thật sự muốn xóa quyền <b>' + parent +'</b> và Quyền con của nó?. Bạn không thể hồi phục lại quyền này sau khi đã xóa')){
                                    $('#AjaxLoader').show();
                                    return true;
                                } else
                                     return false;
                           } else
                                return false;
                        }
                        else {
                            alert('chưa chọn <b>Quyền</b> cần xóa');
                            $('#AjaxLoader').hide();
                            return false;
                        }
                     }",
        'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#roleDiv').hide();  
                    window.location.assign(baseUrl+'/user/viewRTO');                       
                  }",
        'complete' => "js:function(){                                           
                                            
                                        }",
            ), array(//htmlOptions
        'href' => Yii::app()->createUrl('user/deleteRPC'),
        'id' => 'name' . uniqid(),
        'class' => "buttonS btn-danger"
            )
    );
}
?>
<?php if(isset($show) && $show){ ?>
<span class="label" style="color: blue">Tất cả các [[QUYỀN KẾ THỪA]] của QUYỀN: <b>[[<?= strtoupper(basename(isset($name)?$name:"Không xác định được"));?>]]</b></span>

<div class="widget grid12">
<div id="childDiv1">
        <p><span class="label">Quyền kế thừa:</span></p>
            <?php
            if (isset($roles)) {
                foreach ($roles as $role) {
                    echo CHtml::ajaxLink(
                            '<i class="icon-th-large"></i>'.$role->name, Yii::app()->createUrl('user/updateRTO'), array(// ajaxOptions
                        'type' => 'POST',
                        'beforeSend' => "function( request )
                     {
                       // Set up any pre-sending stuff like initializing progress indicators
                     }",
                        'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#childDiv').html(data);
                    $('#roleDiv').hide();  
                  }",
                        'data' => array('name' => $role->name, 'type' => $role->type)
                            ), array(//htmlOptions
                        'href' => Yii::app()->createUrl('user/updateRTO'),
                        'id' => $role->name . uniqid(),
                        'class' => "btn btn-info btn-mini"
                            )
                    );
                    echo CHtml::ajaxLink(
        '<i class="icon-white icon-trash"></i>', Yii::app()->createUrl('user/deleteRTO'), array(// ajaxOptions
    'type' => 'POST',
    'beforeSend' => "function( jqXHR, settings )
                     {                     
                        if ($('#currentrole').length > 0) {
                           var parent = $('#currentrole').text(); 
                           var child = '".$role->name."';   
                           settings.url +=  '?prole='+parent + '&crole='+child; 
                           if(confirm('Bạn có muốn xóa quyền ' + parent + child +' và Quyền con của nó?.')){
                                $('#AjaxLoader').show();
                                return true;
                           } else
                                return false;
                        }
                        else {
                            alert('chưa chọn Quyền cần xóa');
                            $('#AjaxLoader').hide();
                            return false;
                        }
                     }",
    'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#roleDiv').hide();  
                    window.location.assign(baseUrl+'/user/viewRTO');                       
                  }",
    'complete' => "js:function(){                                           
                                            
                                        }",
        ), array(//htmlOptions
    'href' => Yii::app()->createUrl('user/deleteRTO'),
    'id' => 'name' . uniqid(),
    'class' => "btn btn-danger btn-mini"
        )
);
                }
            }
            ?>
</div>
<div id="childDiv2">
        <p><span class="label">Nhóm Quyền kế thừa:</span></p>
            <?php
            if (isset($tasks)) {
                foreach ($tasks as $task) {
                    echo CHtml::ajaxLink(
                            '<i class="icon-th"></i>'.$task->name, Yii::app()->createUrl('user/updateRTO'), array(// ajaxOptions
                        'type' => 'POST',
                        'beforeSend' => "function( request )
                     {
                       // Set up any pre-sending stuff like initializing progress indicators
                     }",
                        'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#childDiv').html(data);
                    $('#roleDiv').hide(); 
                  }",
                        'data' => array('name' => $task->name, 'type' => $task->type)
                            ), array(//htmlOptions
                        'href' => Yii::app()->createUrl('user/updateRTO'),
                        'id' => $task->name . uniqid(),
                        'class' => "btn btn-info btn-mini"
                            )
                    );
                    echo CHtml::ajaxLink(
        '<i class="icon-white icon-trash"></i>', Yii::app()->createUrl('user/deleteRTO'), array(// ajaxOptions
    'type' => 'POST',
    'beforeSend' => "function( jqXHR, settings )
                     {                     
                        if ($('#currentrole').length > 0) {
                           var parent = $('#currentrole').text(); 
                           var child = '".$task->name."';   
                           settings.url +=  '?prole='+parent + '&crole='+child; 
                           if(confirm('Bạn có muốn xóa quyền ' + parent + child +' và Quyền con của nó?.')){
                                $('#AjaxLoader').show();
                                return true;
                           } else
                                return false;
                        }
                        else {
                            alert('chưa chọn Quyền cần xóa');
                            $('#AjaxLoader').hide();
                            return false;
                        }
                     }",
    'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#roleDiv').hide();  
                    window.location.assign(baseUrl+'/user/viewRTO');                       
                  }",
    'complete' => "js:function(){                                           
                                            
                                        }",
        ), array(//htmlOptions
    'href' => Yii::app()->createUrl('user/deleteRTO'),
    'id' => 'name' . uniqid(),
    'class' => "btn btn-danger btn-mini"
        )
);
                }
            }
            ?>
</div>
<div style="clear:both;"></div>
<div id="childDiv3">
        <p><span class="label">Tác vụ kế thừa:</span></p>
<?php
if (isset($operators)) {
    foreach ($operators as $operator) {
        echo CHtml::ajaxLink(
                '<i class="icon-th-list"></i>'.$operator->name, Yii::app()->createUrl('user/updateRTO'), array(// ajaxOptions
            'type' => 'POST',
            'beforeSend' => "function( request )
                     {
                       // Set up any pre-sending stuff like initializing progress indicators
                     }",
            'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#childDiv').html(data);
                    $('#roleDiv').hide(); 
                  }",
            'data' => array('name' => $operator->name, 'type' => $operator->type)
                ), array(//htmlOptions
            'href' => Yii::app()->createUrl('user/updateRTO'),
            'id' => $operator->name . uniqid(),
            'class' => "btn btn-info btn-mini"
                )
        );
        echo CHtml::ajaxLink(
        '<i class="icon-white icon-trash"></i>', Yii::app()->createUrl('user/deleteRTO'), array(// ajaxOptions
    'type' => 'POST',
    'beforeSend' => "function( jqXHR, settings )
                     {                     
                        if ($('#currentrole').length > 0) {
                           var parent = $('#currentrole').text(); 
                           var child = '".$operator->name."';   
                           settings.url +=  '?prole='+parent + '&crole='+child; 
                           if(confirm('Bạn có muốn xóa quyền ' + parent + child +' và Quyền con của nó?.')){
                                $('#AjaxLoader').show();
                                return true;
                           } else
                                return false;
                        }
                        else {
                            alert('chưa chọn Quyền cần xóa');
                            $('#AjaxLoader').hide();
                            return false;
                        }
                     }",
    'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#roleDiv').hide();  
                    window.location.assign(baseUrl+'/user/viewRTO');                       
                  }",
    'complete' => "js:function(){                                           
                                            
                                        }",
        ), array(//htmlOptions
    'href' => Yii::app()->createUrl('user/deleteRTO'),
    'id' => 'name' . uniqid(),
    'class' => "btn btn-danger btn-mini"
        )
);
    }
}
?>
</div>
</div>
<?php } ?>
<?php $authitem = Yii::app()->user->getState(Yii::app()->user->getState('childDiv')); ?>
<div id="currentrole" style="display: none;"><?=  isset($authitem->name)?$authitem->name:'';?></div>