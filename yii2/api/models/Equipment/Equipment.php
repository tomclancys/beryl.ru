<?php

namespace api\models\Equipment;

use api\models\Equipment\EquipmentType;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Модель для работы с типами оборудованием
 */
class Equipment extends ActiveRecord
{
    /**
     * Название таблицы в базе данных
     */
    public static function tableName()
    {
        return '{{%equipment}}';
    }

    /**
     * Связь с таблицей "Типы оборудования"
     * api\models\Equipment\EquipmentType
     */
    public function getType()
    {
        return $this->hasOne(EquipmentType::className(), ['id' => 'type_id']);
    }

    /**
     * Правила для валидации полей
     */
    public function rules()
    {
        return [
            [['type_id', 'number'], 'required'],
            ['number', 'uniqueByNumber'],
            [['id', 'type_id'], 'integer'],
            ['note', 'string', 'max' => '255'],
            ['number', 'string', 'min' => 1, 'max' => '10'],
            [['created_at', 'updated_at'], 'safe'],
            [['type_id', 'number', 'note'], 'filter', 'filter' => function ($value) {
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
            'type_id' => 'ID типа оборудования',
            'number' => 'Серийный номер',
            'note' => 'Примечание',
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
        return ['id', 'type_id', 'note', 'number'];
    }

    /**
     * Проверка поля "number" на уникальность
     */
    public function uniqueByNumber($attribute, $params)
    {
        $existModel = self::find()->where(['type_id' => $this->type_id, 'number' => $this->$attribute])->one();

        if ($this->$attribute) {
            if (!$this->isNewRecord && (string) $existModel->number == (string) $this->oldAttributes["number"]) {
                $badNumber = false;
            } elseif (!empty($existModel)) {
                $badNumber = true;
            } else {
                $badNumber = false;
            }

            if ($badNumber) {
                $this->addError($attribute, 'Серийный номер '. $this->$attribute .' уже используется. Пожалуйста проверьте его или введите другой серийный номер.');
            } else {
                if (self::checkMask($this->$attribute, $this->type->mask)) {
                    return true;
                } else {
                    $this->addError($attribute, 'Введён неверный серийный номер '. $this->$attribute .'. Пожалуйста проверьте его или введите другой серийный номер.');
                }
            }
        }
    }

    /**
     * Проверка поля "number" по маске типа оборудования
     */
    public function checkMask($number, $mask)
    {
        //var_dump($number); exit;
        if (strlen($number) != strlen($mask)) {
            return false;
        }

        $pregRules = [
            'N' => '[0-9]',
            'A' => '[A-Z]',
            'a' => '[a-z]',
            'X' => '[A-Z0-9]',
            'Z' => '[-|_|@]',
        ];

        $maskToArray = str_split($mask);

        $pregMatchRule = '/^';
        foreach ($maskToArray as $maskItem) {
            $pregMatchRule .= $pregRules[$maskItem];
        }
        $pregMatchRule .= '/';

        $checkMask = preg_match($pregMatchRule, $number) > 0 ? true : false;

        return $checkMask;
    }
}
