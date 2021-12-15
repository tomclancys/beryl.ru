<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'Типы оборудования');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="buttons mb-4">
    <a class="btn btn-primary" href="/type-equipment/create" role="button">Добавить</a>
    <?= Html::a(Yii::t('frontend', 'Фильтр'), '#collapseFilter', ['class' => 'btn btn-secondary float-right', 'data-toggle' => 'collapse']) ?>
</div>

<div class="equipmenttype-index">

    <?php Pjax::begin(); ?>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => 'Вопросы-ответы отсутствуют.',
        'tableOptions'=>['class'=>'table table-bordered', 'role' => 'grid'],
        'columns' => [
            'id',
            'name',
            'mask',
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'contentOptions' =>['class' => 'updated_at'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '#', 
                'headerOptions' => ['width' => '60'],
                'template' =>  '{update} {delete}',
            ],
        ],
        'layout' => "{items} \n {pager}",
        'options' => ['class' => 'grid-view box-body table-responsive no-padding'],
    ]) ?>

    <?php Pjax::end(); ?>

</div>
