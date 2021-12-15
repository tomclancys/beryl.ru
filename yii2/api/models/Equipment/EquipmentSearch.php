<?php

namespace api\models\Equipment;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\Equipment\Equipment;

/**
 * Модель для поиска оборудования
 */
class EquipmentSearch extends Equipment
{
    public function rules()
    {
        return [
            [['id', 'type_id'], 'integer'],
            ['number', 'string', 'max' => '10'],
            ['note', 'string', 'max' => '255'],
            [['created_at', 'updated_at'], 'datetime'],
            [['number', 'note'], 'filter', 'filter' => function ($value) {
                return \yii\helpers\HtmlPurifier::process(strip_tags($value), ENT_QUOTES, 'UTF-8');
            }],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Equipment::find()->with('type');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'number' => $this->number,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]);

        return $dataProvider;
    }
}
