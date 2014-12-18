<!-- Require the header -->
<?php require_once('tpl_header.php') ?>

<!-- Require the navigation -->
<?php require_once('tpl_navigation.php') ?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <?php require_once('tpl_sidebar.php') ?>
    <!-- Include content pages -->
  <?php echo $content; ?>
    <?php require_once('tpl_quick_sidebar.php') ?>
</div>
<!-- END CONTAINER -->
<!-- Require the footer -->
<?php require_once('tpl_footer.php') ?>
