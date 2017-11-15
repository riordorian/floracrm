<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogSections */
/* @var $form yii\widgets\ActiveForm */

$this->context->fixHeading = 'true';
?>

<div class="catalog-sections-form js-replaceable-container js-reload-elems">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <?if( !empty($model->ID) ){
            echo $form->field($model, 'ID')->hiddenInput()->label(false);
        }?>

        <?= $form->field($model, 'NAME', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
        <div class="clearfix"></div><?
        
        if( !empty($model->IMAGE) ){
            ?><div class="col-md-4 m-b-sm"><?
                echo Html::img($model->IMAGE, ['class' => 'img-responsive']);
            ?></div><?
        }
        ?><div class="clearfix"></div>
        
        <?= $form->field($model, 'UPLOAD', ['options' => ['class' => 'col-md-4']])->fileInput(['class' => 'js-widget uploadpicker', 'placeholder' => 'Выберите файл']) ?>
    </div>

    <div class="clearfix m-b-lg"></div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
