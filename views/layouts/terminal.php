<?

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\TerminalAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

TerminalAsset::register($this);
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

<div class="terminal__info p-h-xxs bg-info">
    <div class="col-md-3">
        <a class="navbar-minimalize btn btn-primary js-widget popover-widget" href="javascript:;" data-toggle="popover" data-placement="auto right" data-popover-content="#terminal-menu"><i class="fa fa-bars"></i> </a>
        <div id="terminal-menu" class="hidden">
            <p><a class="text-navy" href="/terminal/calendar/"><i class="fa fa-calendar m-r-xs"></i>Календарь</a></p>
            <p><a class="text-navy" href="/terminal/orders/"><i class="fa fa-shopping-cart m-r-xs"></i>Терминал</a></p>
            <p><a class="text-navy" href="/logout/"><i class="fa fa-sign-out m-r-xs"></i>Сменить оператора</a></p>
        </div>
    </div>
    <div class="col-md-4 pull-right text-right">
        <p class="p-xxs m-n"><?=Yii::$app->user->identity->username?></p>
    </div>
    <div class="clearfix"></div>
</div>


<div class="terminal__content">
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
