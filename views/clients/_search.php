<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); 
    ?>

    <div class="row">
        <?= $form->field($model, 'NAME', [
                'options' => [
                    'class' => 'col-md-4'
                ]
            ]
        ) ?>

        <?= $form->field($model, 'TYPE', [
                'options' => [
                    'class' => 'col-md-4'
                ]
            ]
        ) ?>

        <?= $form->field($model, 'CLIENT_GROUP', [
                'options' => [
                    'class' => 'col-md-4'
                ]
            ]
        ) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
