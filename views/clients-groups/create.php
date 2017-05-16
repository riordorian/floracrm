<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ClientsGroups */

$this->title = 'Create Clients Groups';
$this->params['breadcrumbs'][] = ['label' => 'Clients Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-groups-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
