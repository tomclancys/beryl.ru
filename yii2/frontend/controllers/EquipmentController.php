<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Equipment\EquipmentFront;
use api\models\Equipment\EquipmentSearch;

/**
 * Контроллер для управления оборудованием
 */
class EquipmentController extends DefaultController
{
    /**
     * Фильтрация запросов для их ограничения по типам
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'index'  => ['GET'],
                    'view'   => ['GET'],
                    'create' => ['POST', 'GET'],
                    'update' => ['POST', 'GET'],
                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * Список
     */
    public function actionIndex()
    {
        $searchModel = new EquipmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 15;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Добавление
     */
    public function actionCreate()
    {
        $model = new EquipmentFront();

        if(Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            if(!$model->saveNumbers($data)) {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'Произошла ошибка при добавлении оборудования.'));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Редактирование
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Оборудование успешно сохранён.'));
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'Произошла ошибка при редактировании оборудования.'));
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Удаление
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('frontend', 'Оборудование успешно удалено.'));
            return $this->redirect('index');
        } else {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'Возникла ошибка при удалении оборудования. Пожалуйста попробуйте ещё раз.'));
            return $this->redirect('index');
        }
    }

    /**
     * Поиск модели
     */
    private function findModel($id)
    {
        return EquipmentFront::findOne($id);
    }
}
