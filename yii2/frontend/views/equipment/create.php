<?php

use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Добавление оборудования');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Список оборудования'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="equipment-create">

    <h1><?= $this->title; ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
