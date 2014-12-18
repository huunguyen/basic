<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Login'),
        ));
?>
<div class="fluid">    
    <h3>Gửi mail <?= $status; ?></h3>
    <?php
    require_once (Yii::getPathOfAlias('common.vendors.google') . '/Google_Client.php');
    require_once (Yii::getPathOfAlias('common.vendors.google') . '/contrib/Google_PredictionService.php');
    if (isset($authUrl)) {
        print "<a class='login' href='$authUrl'>Login</a>";
        $result = "";
    } else {
        print "<a class='login' href='?logout'>Logout</a>";
        /* prediction logic follows...  */
        $id = "languages";
        $predictionText = "Nguyen Huu Nguyen";
        $predictionData = new Google_InputInput();
        $predictionData->setCsvInstance(array($predictionText));
        $input = new Google_Input();
        $input->setInput($predictionData);
        $result = $predictionService->trainedmodels->predict($id, $input);
        print("</div><br><br><h2>Prediction Result:</h2>");
        print_r($result);
    }
    ?>
</div>