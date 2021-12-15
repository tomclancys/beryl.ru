<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use api\models\Equipment\EquipmentType;
?>

<div class="equipment-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'equipment-form',
        'enableClientValidation' => true,
        'enableAjaxValidation'   => false,
        ]); ?>
    
        <div class="row">
            <div class="col-md-6">

                <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(EquipmentType::find()->all(), 'id', 'name'), ['prompt' => 'Выберите...'])->label('Тип оборудования') ?>

                <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'note')->textArea(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('frontend', $model->isNewRecord ? 'Добавить' : 'Сохранить'), ['class' => 'btn btn-primary']) ?>
                </div>
                
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
