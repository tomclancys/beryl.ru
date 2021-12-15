<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use api\models\Equipment\EquipmentType;

Yii::$app->request->get("EquipmentSearch") !== NULL || !empty(Yii::$app->request->get("EquipmentSearch")) ? $filter_open = ' show' : $filter_open = null;
?>

<div class="filter-search collapse<?= $filter_open; ?>" id="collapseFilter"">
    
    <?php $form = ActiveForm::begin([
        'action' => [''],
        'method' => 'get',
        'enableClientValidation' => true,
        'enableAjaxValidation'   => false,
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

        <div class="row">

            <div class="col col-lg-1">
                <?= $form->field($model, 'id')->input('number', ['placeholder' => "ID"])->label(false) ?>
            </div>

            <div class="col col-lg-2">
                <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(EquipmentType::find()->all(), 'id', 'name'), ['prompt' => 'Выберите...', 'placeholder' => 'Тип оборудования'])->label(false) ?>
            </div>

            <div class="col col-lg-3">
                <?= $form->field($model, 'number')->input('text', ['placeholder' => "Серийный номер"])->label(false) ?>
            </div>

            <div class="col col-lg-3">
                <?= $form->field($model, 'note')->input('text', ['placeholder' => "Примечание"])->label(false) ?>
            </div>

            <div class="col-md-auto">
                <?= Html::submitButton(Yii::t('frontend', 'Найти'), ['class' => 'btn btn-primary send']) ?>
                <?= Html::a(Yii::t('frontend', 'Сбросить'), Url::toRoute(['index']), ['class' => 'btn btn-outline-secondary reset']) ?>
            </div>

        </div>

    <?php ActiveForm::end(); ?>
</div>
