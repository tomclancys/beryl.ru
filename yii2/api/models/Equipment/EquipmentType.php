<?php

namespace api\models\Equipment;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Модель для работы с оборудованием
 */
class EquipmentType extends ActiveRecord
{
    /**
     * Название таблицы в базе данных
     */
    public static function tableName()
    {
        return '{{%equipment_type}}';
    }

    /**
     * Правила для валидации полей
     */
    public function rules()
    {
        return [
            [['name', 'mask'], 'required'],
            ['id', 'integer'],
            ['name', 'string', 'min' => 1, 'max' => '255'],
            ['mask', 'string', 'min' => 1, 'max' => '10'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'mask'], 'filter', 'filter' => function ($value) {
                return \yii\helpers\HtmlPurifier::process(strip_tags($value), ENT_QUOTES, 'UTF-8');
            }],
        ];
    }

    /**
     * Названия полей
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'mask' => 'Маска серийного номера',
            'created_at' => 'Добавлено',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * Автоматическая установка даты и времени
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Ограничиваем поля которые доступны в API
     */
    public function fields()
    {
        return ['id', 'name', 'mask'];
    }
}
