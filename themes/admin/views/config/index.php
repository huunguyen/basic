 <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <div class="tab-pane active" id="tab_0">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Thông tin <?php echo Yii::t('app', 'Options'); ?></span>
                                <span class="caption-helper"> 
                                    <?php if (Yii::app()->user->hasFlash('config')): ?>                                    
                                        <?php echo Yii::app()->user->getFlash('config'); ?>
                                    <?php endif; ?></span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'login-form',
                                'enableClientValidation' => true,
                                'enableAjaxValidation' => false,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                ),
                                'htmlOptions' => array('class' => 'form-horizontal'),
                            ));
                            ?>
                            <div class="form-body">

                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button>
                                    <span><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.</span>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->label($model, 'adminEmail', array('class' => 'col-md-3 control-label')); ?>
                                    <div class="col-md-4">
                                         <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                            <?php
                                    echo $form->textField($model, 'adminEmail', array('class' => 'form-control form-control-solid placeholder-no-fix',
                                        'autocomplete' => "off",
                                        'placeholder' => "adminEmail")
                                    );
                                    ?>	
                                        </div>                                        
                                    </div>                                        	
                                </div>
                                <div class="form-group">
                                    <?php echo $form->label($model, 'paramName', array('class' => 'col-md-3 control-label')); ?>
                                    <div class="col-md-4">
                                         <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            <?php
                                    echo $form->textField($model, 'paramName', array('class' => 'form-control form-control-solid placeholder-no-fix',
                                        'autocomplete' => "off",
                                        'placeholder' => "paramName")
                                    );
                                    ?>	
                                        </div>                                        
                                    </div>                                        	
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div> 
                            <?php $this->endWidget(); ?>
                            <!-- END FORM-->
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->