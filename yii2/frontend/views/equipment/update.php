<?php

use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Редактирование оборудования ID:{name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Список оборудования'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Редактирование ID: '. $model->id);
?>

<div class="equipment-update">

    <h1><?= $this->title; ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>