
<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\DashboardAsset;
use common\widgets\Alert;
//------
DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="<?= Yii::$app->charset ?>">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
 	 <link rel="icon" href="<?= Yii::$app->request->baseUrl; ?>/backend/web/img/iconteca.png">
 	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<?= Html::csrfMetaTags() ?>
  	<title><?= Html::encode($this->title) ?></title>

  	<?php $this->head() ?>
 
</head>
	<body>
	<?php $this->beginBody() ?>

	<?= $content ?>

	<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>