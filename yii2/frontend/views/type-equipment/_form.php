<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
?>

<div class="equipmenttype-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'equipmenttype-form',
        'enableClientValidation' => true,
        'enableAjaxValidation'   => false,
        ]); ?>
    
        <div class="row">
            <div class="col-md-6">

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'mask')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('frontend', $model->isNewRecord ? 'Добавить' : 'Сохранить'), ['class' => 'btn btn-primary']) ?>
                </div>
                
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
