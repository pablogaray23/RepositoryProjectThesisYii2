<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Equipamiento;

/**
 * EquipamientoSearch represents the model behind the search form about `backend\models\Equipamiento`.
 */
class EquipamientoSearch extends Equipamiento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_equipamiento'], 'integer'],
            [['nombre_equipamiento', 'descripcion'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Equipamiento::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_equipamiento' => $this->id_equipamiento,
        ]);

        $query->andFilterWhere(['like', 'nombre_equipamiento', $this->nombre_equipamiento])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
