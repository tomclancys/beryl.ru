<?php

namespace api\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

/**
 * Контроллер для управления оборудованием
 */
class EquipmentController extends DefaultController
{
    public $modelClass = 'api\models\Equipment\Equipment';

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
        $data = Yii::$app->getRequest()->getBodyParams();
        $result = null;

        $data["number"] = !is_array($data["number"]) ? [$data["number"]] : $data["number"];

        foreach($data["number"] as $key => $number) {
            $model_item = new $this->modelClass();
            $model_item->load($data, '');
            $model_item->number = $number;

            if ($model_item->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $id = implode(',', array_values($model_item->getPrimaryKey(true)));
                $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            } elseif (!$model_item->hasErrors()) {
                throw new ServerErrorHttpException('Не удалось создать.');
            }

            $result[$key] = $model_item;
        }

        return $result;
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
