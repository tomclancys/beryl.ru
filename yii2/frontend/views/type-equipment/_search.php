<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

Yii::$app->request->get("EquipmentTypeSearch") !== NULL || !empty(Yii::$app->request->get("EquipmentTypeSearch")) ? $filter_open = ' show' : $filter_open = null;
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

            <div class="col col-lg-4">
                <?= $form->field($model, 'name')->input('text', ['placeholder' => "Наименование"])->label(false) ?>
            </div>

            <div class="col col-lg-4">
                <?= $form->field($model, 'mask')->input('text', ['placeholder' => "Маска серийного номера"])->label(false) ?>
            </div>

            <div class="col-md-auto">
                <?= Html::submitButton(Yii::t('frontend', 'Найти'), ['class' => 'btn btn-primary send']) ?>
                <?= Html::a(Yii::t('frontend', 'Сбросить'), Url::toRoute(['index']), ['class' => 'btn btn-outline-secondary reset']) ?>
            </div>

        </div>

    <?php ActiveForm::end(); ?>
</div>
