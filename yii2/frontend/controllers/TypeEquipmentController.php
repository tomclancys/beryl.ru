<?php

namespace frontend\controllers;

use Yii;
use api\models\Equipment\EquipmentType;
use api\models\Equipment\EquipmentTypeSearch;

/**
 * Контроллер для управления типами оборудования
*/
class TypeEquipmentController extends DefaultController
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
        $searchModel = new EquipmentTypeSearch();
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
        $model = new EquipmentType();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Новый тип оборудования успешно добавлен.'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'Произошла ошибка при добавлении типа оборудования.'));
                return $this->render('create', [
                    'model' => $model,
                ]);
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
            if($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Тип оборудования успешно сохранён.'));
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                var_dump($model->getErrors());
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'Произошла ошибка при редактировании типа оборудования.'));
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

        if($model->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('frontend', 'Тип оборудования успешно удалён.'));
            return $this->redirect('index');
        } else {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'Возникла ошибка при удалении типа оборудования. Пожалуйста попробуйте ещё раз.'));
            return $this->redirect('index');
        }
    }

    /**
     * Поиск модели
    */
    private function findModel($id)
    {
        return EquipmentType::findOne($id);
    }
}
