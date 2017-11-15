<?

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\TerminalLoginAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

TerminalLoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?=( !empty($this->context->bodyClass) ) ? $this->context->bodyClass : ''?>">
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>