<?php
$roles = null;
$tasks = null;
$operators = null;
$show = false;
$uniqid = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@roles@tasks@operators');
Yii::app()->user->setState('childDiv', $uniqid);
//Yii::app()->user->setState($uniqid, null);
?>
<div class="widget grid12"  id="parentDiv">
    <span id="systemDiv">
            <p><span class="label" style="color: red"><?= strtoupper(basename("QUYỀN CƠ BẢN MẶC ĐỊNH CÓ TRONG HỆ THỐNG:"));?></span></p>            
                <?php
                foreach (RoleHelper::getLevelRoleList() as $rolename) {
                    echo CHtml::ajaxLink(
                            '<i class="icon-user"></i>' . $rolename, Yii::app()->createUrl('user/updateRTO'), array(// ajaxOptions
                        'type' => 'POST',
                        'beforeSend' => "function( request )
                     {
                       $('#AjaxLoader').show();
                     }",
                        'success' => "function( data )
                  {                  
                    $('#AjaxLoader').hide();                    
                    $('#childDiv').html(data);
                    $('#roleDiv').hide();    
                  }",
                        'data' => array('name' => $rolename, 'type' => 2)
                            ), array(//htmlOptions
                        'href' => Yii::app()->createUrl('user/updateRTO'),
                        'id' => $rolename . uniqid(),
                        'class' => "btn btn-info btn-mini"
                            )
                    );
                    if (Yii::app()->user->checkAccess('supper')) {
                        echo CHtml::ajaxLink(
                                '<i class="icon-white icon-trash"></i>', Yii::app()->createUrl('user/deleteRPC'), array(// ajaxOptions
                            'type' => 'POST',
                            'beforeSend' => "function( jqXHR, settings )
                     {                     
                        var parent = '" . $rolename . "';  
                           settings.url +=  '?role='+parent; 
                           var patern = new String('" . $rolename . "');
                           var main = new String('Bạn có muốn xóa quyền ' + patern +' và Quyền con của nó?. Nếu bạn không chắc chắn những gì đang làm xin vui lòng hủy lệnh này');
                           if(confirm(main)){
                                if(confirm('Bạn thật sự muốn xóa quyền ' + parent +' và Quyền con của nó?. Bạn không thể hồi phục lại quyền này sau khi đã xóa')){
                                    $('#AjaxLoader').show();
                                    return true;
                                } else
                                     return false;
                           } else
                                return false;
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
                            'class' => "btn btn-danger btn-mini"
                                )
                        );
                    }
                }
                ?>
    </span>
    </div>
    <div class="widget grid12">
    <div id="parentDiv1">
            <p><span class="label">CÁC QUYỀN PHÂN CHO TỪNG THÀNH VIÊN. MỖI THÀNH VIÊN CÓ 1 QUYỀN NÀY:</span></p>
                <?php
                foreach ($authitems_role as $role) {
                    if (in_array($role->name, RoleHelper::getLevelRoleList())) {
                        continue;
                    }
                    echo CHtml::ajaxLink(
                            '<i class="icon-user"></i>' . $role->name, Yii::app()->createUrl('user/updateRTO'), array(// ajaxOptions
                        'type' => 'POST',
                        'cache'=>false,
                        'beforeSend' => "function( request )
                     {
                       $('#AjaxLoader').show();
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
                    if (Yii::app()->user->checkAccess('supper')) {
                        echo CHtml::ajaxLink(
                                '<i class="icon-white icon-trash"></i>', Yii::app()->createUrl('user/deleteRPC'), array(// ajaxOptions
                            'type' => 'POST',
                        'cache'=>false,
                            'beforeSend' => "function( jqXHR, settings )
                     {                     
                        var parent = '" . $role->name . "';  
                           settings.url +=  '?role='+parent; 
                           var patern = new String('" . $role->name . "');
                           var main = new String('Bạn có muốn xóa quyền ' + patern +' và Quyền con của nó?. Nếu bạn không chắc chắn những gì đang làm xin vui lòng hủy lệnh này');
                           if(confirm(main)){
                                if(confirm('Bạn thật sự muốn xóa quyền ' + parent +' và Quyền con của nó?. Bạn không thể hồi phục lại quyền này sau khi đã xóa')){
                                    $('#AjaxLoader').show();
                                    return true;
                                } else
                                     return false;
                           } else
                                return false;
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
                            'class' => "btn btn-danger btn-mini"
                                )
                        );
                    }
                }
                ?>  
    </div>

    <div id="parentDiv2">
            <p><span class="label">QUYỀN CHO NHÓM - QUYỀN NÀY BAO GỒM MỘT NHÓM CÁC QUYỀN NHỎ (QUYỀN THAO TÁC):</span></p>
                <?php
                foreach ($authitems_task as $task) {
                    echo CHtml::ajaxLink(
                            '<i class="icon-th-large"></i>' . $task->name, Yii::app()->createUrl('user/updateRTO'), array(// ajaxOptions
                        'type' => 'POST',
                        'cache'=>false,
                        'beforeSend' => "function( request )
                     {
                       $('#AjaxLoader').show();
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
                    if (Yii::app()->user->checkAccess('supper')) {
                        echo CHtml::ajaxLink(
                                '<i class="icon-white icon-trash"></i>', Yii::app()->createUrl('user/deleteRPC'), array(// ajaxOptions
                            'type' => 'POST',
                        'cache'=>false,
                            'beforeSend' => "function( jqXHR, settings )
                     {                     
                        var parent = '" . $task->name . "';  
                           settings.url +=  '?role='+parent; 
                           if(confirm('Bạn có muốn xóa quyền <b>' + parent +'</b> và Quyền con của nó?. Nếu bạn không chắc chắn những gì đang làm xin vui lòng hủy lệnh này')){
                                if(confirm('Bạn thật sự muốn xóa quyền <b>' + parent +'</b> và Quyền con của nó?. Bạn không thể hồi phục lại quyền này sau khi đã xóa')){
                                    $('#AjaxLoader').show();
                                    return true;
                                } else
                                     return false;
                           } else
                                return false;
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
                            'class' => "btn btn-danger btn-mini"
                                )
                        );
                    }
                }
                ?>
    </div>

    <div id="parentDiv3">
            <p><span class="label">QUYỀN CHO TỪNG TÁC VỤ ĐƠN - MỖI QUYỀN NÀY LÀ MỖI THAO TÁC TRONG HỆ THỐNG:</span></p>
                <?php
                foreach ($authitems_operator as $operator) {
                    echo CHtml::ajaxLink(
                            '<i class="icon-play-circle"></i>' . $operator->name, Yii::app()->createUrl('user/updateRTO'), array(// ajaxOptions
                        'type' => 'POST',
                        'cache'=>false,
                        'beforeSend' => "function( request )
                     {
                       $('#AjaxLoader').show();
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
                    if (Yii::app()->user->checkAccess('supper')) {
                        echo CHtml::ajaxLink(
                                '<i class="icon-white icon-trash"></i>', Yii::app()->createUrl('user/deleteRPC'), array(// ajaxOptions
                            'type' => 'POST',
                        'cache'=>false,
                            'beforeSend' => "function( jqXHR, settings )
                     {                     
                        var parent = '" . $operator->name . "';  
                           settings.url +=  '?role='+parent; 
                           if(confirm('Bạn có muốn xóa quyền <b>' + parent +'</b> và Quyền con của nó?. Nếu bạn không chắc chắn những gì đang làm xin vui lòng hủy lệnh này')){
                                if(confirm('Bạn thật sự muốn xóa quyền <b>' + parent +'</b> và Quyền con của nó?. Bạn không thể hồi phục lại quyền này sau khi đã xóa')){
                                    $('#AjaxLoader').show();
                                    return true;
                                } else
                                     return false;
                           } else
                                return false;
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
                            'class' => "btn btn-danger btn-mini"
                                )
                        );
                    }
                }
                ?>
    </div>
</div>
<div style="clear:both;"></div>
<div id="AjaxLoader" style="display: none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></img></div> 
<div id="childDiv" class="grid12">   
    <?php
    $params = array();
    if (($roles != null) & (count($roles) > 0))
        $params = $params + array('roles' => $roles);
    if (($tasks != null) & (count($tasks) > 0))
        $params = $params + array('tasks' => $tasks);
    if (($operators != null) & (count($operators) > 0))
        $params = $params + array('operators' => $operators);
    if (!empty($params))
        $show = true;
    elseif (Yii::app()->user->hasState($uniqid)) {
        $authitem = Yii::app()->user->getState($uniqid);
        $auth = Yii::app()->authManager;
        if (($authitem != null) && ($authitemchilds = $auth->getItemChildren($authitem->name))) {
            $this->getRTO($authitem->name, $roles, $tasks, $operators);
            if (($roles != null) & (count($roles) > 0))
                $params += array('roles' => $roles);
            if (($tasks != null) & (count($tasks) > 0))
                $params += array('tasks' => $tasks);
            if (($operators != null) & (count($operators) > 0))
                $params += array('operators' => $operators);
            if (!empty($params))
                $show = true;
        }
    }
    if ($show) {
        $params += array('show' => true);
        $params += array('name' => Yii::app()->user->getState('nameofparent'));
        echo $this->renderPartial('_subrto', $params);
    }
    ?>
</div>
<div style="clear:both;height: 10px;"></div>
<?php
echo CHtml::ajaxLink(
        '<i class="icon-qrcode"></i>Cập nhật Quyền hiện tại', Yii::app()->createUrl('user/createRTO'), array(// ajaxOptions
    'type' => 'POST',
    'cache'=>false,
    'beforeSend' => "function( jqXHR, settings )
                     {
                     $('#AjaxLoader').show();
                    if ($('#currentrole').length > 0) {
                       var name = $('#currentrole').text();
                       settings.url +=  '?child='+name;                            
                    }
                        //alert(settings.url);
                     }",
    'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#roleDiv').html(data);
                    $('#roleDiv').show();   
                  }",
    'complete' => "js:function(){                                           
                                            
                                        }",
        ), array(//htmlOptions
    'href' => Yii::app()->createUrl('user/createRTO'),
    'id' => 'name' . uniqid(),
    'class' => "buttonS bLightBlue"
        )
);
echo CHtml::ajaxLink(
        '<i class="icon-barcode"></i>Tạo Quyền Mới', Yii::app()->createUrl('user/createRTO'), array(// ajaxOptions
    'type' => 'POST',
            'cache' => false,
    'beforeSend' => "function( jqXHR, settings )
                     {
                     $('#AjaxLoader').show();  
                     var action = 'create';                           
                     settings.url +=  '?action='+action;  
                     //alert(settings.url);
                     }",
    'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#roleDiv').html(data);
                    $('#roleDiv').show();   
                  }",
    'complete' => "js:function(){                                           
                                            
                                        }",
        ), array(//htmlOptions
    'href' => Yii::app()->createUrl('user/createRTO'),
    'id' => 'name' . uniqid(),
    'class' => "buttonS bLightBlue"
        )
);
echo CHtml::ajaxLink(
        '<i class="icon-random"></i>' . 'Tạo RPC Mới', Yii::app()->createUrl('user/createRPC'), array(// ajaxOptions
    'type' => 'POST',
            'cache' => false,
    'beforeSend' => "function( jqXHR, settings )
                     {
                     $('#AjaxLoader').show();  
                     var action = 'createRPC';                           
                           settings.url +=  '?action='+action;  
                     //alert(settings.url);
                     }",
    'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#roleDiv').html(data);
                    $('#roleDiv').show();   
                  }",
    'complete' => "js:function(){                                           
                                            
                                        }",
        ), array(//htmlOptions
    'href' => Yii::app()->createUrl('user/createRPC'),
    'id' => 'name' . uniqid(),
    'class' => "buttonS bLightBlue"
        )
);

echo CHtml::ajaxLink(
        '<i class="icon-retweet"></i>Tạo Quyền Con Cho QHT', Yii::app()->createUrl('user/createRTO'), array(// ajaxOptions
    'type' => 'POST',
            'cache' => false,
    'beforeSend' => "function( jqXHR, settings )
                     {
                     $('#AjaxLoader').show();
                        if ($('#currentrole').length > 0) {
                           var parent = $('#currentrole').text();                           
                           settings.url +=  '?parent='+parent; 
                        }
                        else {
                            alert('chưa chọn Quyền cha');
                            $('#AjaxLoader').hide();
                            return false;
                        }
                        //alert(settings.url);
                        $(this).unbind('click');
                     }",
    'success' => "function( data )
                  {
                    $('#AjaxLoader').hide();
                    $('#roleDiv').html(data);
                    $('#roleDiv').show();   
                  }",
    'complete' => "js:function(){                                           
                          $(this).bind('click');                  
                                        }",
        ), array(//htmlOptions
    'href' => Yii::app()->createUrl('user/createRTO'),
    'id' => 'parent' . uniqid(),
    'class' => "buttonS bLightBlue"
        )
);
?>
<script type="text/javascript">
    $(document).ready(function () {

    // add a handler for the click event to the specific element
    $('#action_link').click( function(event) {
        $(this).unbind('click');
        // prevent default action of the link - this is not really necessary as the link has no "href"-attribute
        event.preventDefault();
    });

});
</script>
<?php
$uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@parent@child');
Yii::app()->user->setState('roleDiv', $uni_id);
if (Yii::app()->user->hasState($uni_id)) {
    $data = Yii::app()->user->getState($uni_id);
    $parent = isset($data["parent"]) ? $data["parent"] : new AuthItem;
    $child = isset($data["model"]) ? $data["model"] : new AuthItem;
} else {
    $data = array();
    $parent = isset($parent) ? $parent : new AuthItem;
    $child = isset($child) ? $child : new AuthItem;
}
?>
<div class="widget grid12" id="roleDiv">
    <?php if (isset($data["parent"]) || isset($data["child"])) echo $this->renderPartial('_ajaxrto', array('model' => $child, 'parent' => $parent)); ?>
</div>
