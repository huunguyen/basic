<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- Require the content_header -->
        <?php require_once('content_header.php') ?>        
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            <?= $this->pageTitle = Yii::app()->name; ?>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="index.html">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">Dashboard</a>
                </li>
            </ul>
            <div class="page-toolbar">
                <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range">
                    <i class="icon-calendar"></i>&nbsp;
                    <span class="thin uppercase visible-lg-inline-block">&nbsp;</span>&nbsp;
                    <i class="fa fa-angle-down"></i>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <?php
        $flashMessages = Yii::app()->user->getFlashes();
        if ($flashMessages):
            ?>    
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN ALERTS PORTLET-->
                    <div class="portlet purple box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Cảnh báo hệ thống
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>                            
                                <a href="javascript:;" class="remove">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php foreach ($flashMessages as $key => $message): ?>    
                                <div class="alert alert-<?= $key ?> alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong><?= strtoupper($key); ?></strong> <?= $message ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- END ALERTS PORTLET-->
                </div>
            </div>  

        <?php else: ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN ALERTS PORTLET-->
                    <div class="portlet yellow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Thông tin hướng dẫn
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>                           
                                <a href="javascript:;" class="reload">
                                </a>
                                <a href="javascript:;" class="remove">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php
                            /* success info danger warning */
                            foreach (Yii::app()->user->getFlashes() as $key => $message) {
                                echo '<div class="note note-' . $key . ' alert-dismissable"><strong>' . $key . '!</strong>' . $message . "</div>\n";
                            }
                            ?>
                            <div class="note note-success">
                                <h4 class="block">Quản trị hệ thống Cty Quảng cáo đồng nai</h4>
                                <p>
                                    Bạn đang đăng nhập vào hệ thống quản trị công ty quảng cáo đồng nai.<br/> 
                                    Thông tin đăng tại đây ảnh hưởng đến hệ thống. <br/> 
                                    Cần phâỉ cẩn trọng trong việc đăng và xóa thông tin hệ thống.
                                </p>
                            </div>                       
                        </div>
                    </div>
                    <!-- END ALERTS PORTLET-->
                </div>
            </div>
        
                <?php endif; ?>
<!-- BAT DAU NOI DUNG CHINH CUA TRANG -->
        <?php echo $content; ?>
<!-- KET THUC NOI DUNG CHINH CUA TRANG -->
        <!-- Require the content_footer -->
        <?php require_once('content_footer.php') ?>    
    </div>
</div>
<!-- END CONTENT -->

<?php $this->endContent(); ?>