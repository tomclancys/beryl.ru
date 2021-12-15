<?php

namespace api\models\Equipment;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\Equipment\EquipmentType;

/**
 * Модель для поиска типов оборудования
 */
class EquipmentTypeSearch extends EquipmentType
{
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['name', 'string', 'max' => '255'],
            ['mask', 'string', 'max' => '10'],
            [['created_at', 'updated_at'], 'datetime'],
            [['name', 'mask'], 'filter', 'filter' => function ($value) {
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
        $query = EquipmentType::find();

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
            'name' => $this->name,
            'mask' => $this->mask,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]);

        return $dataProvider;
    }
}
