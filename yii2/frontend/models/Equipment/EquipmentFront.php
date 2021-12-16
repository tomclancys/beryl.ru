<?php

namespace frontend\models\Equipment;

use Yii;
use api\models\Equipment\Equipment;

/**
 * Модель для работы с типами оборудованием
 */
class EquipmentFront extends Equipment
{
    public $numbers;
    
    /**
     * Правила для валидации полей
     */
    public function rules()
    {
        // Добавляем новое правила валидации
        $rulesFix = [
            [['numbers'], 'required'],
            [['numbers'], 'string'],
        ];

        return array_merge(parent::rules(), $rulesFix);
    }

    /**
     * Названия полей
     */
    public function attributeLabels()
    {
        // Добавляем новое поле
        $attributeLabelsFix = [
            'type_id' => 'Тип оборудования',
            'numbers' => 'Серийные номера',
        ];

        return array_merge(parent::attributeLabels(), $attributeLabelsFix);
    }

    /**
     * Функция для валидация и сохранении номеров оборудования
     */
    public function saveNumbers($data)
    {
        $numbersArray = explode(',', $data['EquipmentFront']['numbers']);
        $numbers = !is_array($numbersArray) ? [$numbersArray] : $numbersArray;

        $success = 0;
        $errors = 0;

        $success_number = null;
        $errors_number = null;

        if($numbers != null && is_array($numbers)) {
            foreach($numbers as $number) {
                $form = new EquipmentFront();
                $form->load($data);
                $form->number = trim(strip_tags($number));
    
                if($form->save()) {
                    $success_number .= $number .',';
                    $success++;
                } else {
                    $errors_number .= $number .',';
                    $errors++;
                }
            }
    
            if($success >= 1) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Оборудование c номером '. rtrim($success_number, ',') .' успешно добавлено.'));
            }
    
            if($errors >= 1) {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'Оборудование c номером '. rtrim($errors_number, ',') .' не добавлено.<br>Возможно данные номера уже используется или содержат ошибку.'));
                //var_dump($form->errors);
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'Необходимо заполнить поле с серийными номерами.'));
        }

        return true;
    }
}
