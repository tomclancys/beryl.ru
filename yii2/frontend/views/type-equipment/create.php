<?php

use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Добавление типа оборудования');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Типы оборудования'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="equipmenttype-create">

    <h1><?= $this->title; ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
