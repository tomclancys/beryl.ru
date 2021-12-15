<?php

namespace api\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

/**
 * Контроллер для управления типами оборудованием
 */
class EquipmenttypeController extends DefaultController
{
    public $modelClass = 'api\models\Equipment\EquipmentType';

    /**
     * Фильтрация запросов для их ограничения по типам
     */
    public function verbs()
    {
        return [
            'index' => ['GET'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT'],
            'delete' => ['DELETE'],
        ];
    }

    /**
     * Переопределяем экшены yii\rest\ActiveController
     * @return array
     */
    public function actions() {

        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['view']);
        unset($actions['delete']);

        return $actions;
    }

    /**
     * Список
     */
    public function actionIndex()
    {
        return $this->modelClass::find()->all();
    }

    /**
     * Просмотр
     */
    public function actionView(int $id)
    {
        return $this->modelClass::find()->where(['id' => $id])->one();
    }

    /**
     * Добавление
     */
    public function actionCreate()
    {
        $model = new $this->modelClass();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Не удалось создать.');
        }

        return $model;
    }

    /**
     * Редактирование
     */
    public function actionUpdate(int $id)
    {
        $model = $this->modelClass::find()->where(['id' => $id])->one();
        
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Не удалось обновить.');
        }

        return $model;
    }

    /**
     * Удаление
     */
    public function actionDelete(int $id)
    {
        $model = $this->modelClass::find()->where(['id' => $id])->one();

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Не удалось удалить.');
        }

        Yii::$app->getResponse()->setStatusCode(204);
    }
}
