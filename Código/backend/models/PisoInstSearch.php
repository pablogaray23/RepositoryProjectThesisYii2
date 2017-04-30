<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PisoInst;

/**
 * PisoInstSearch represents the model behind the search form about `backend\models\PisoInst`.
 */
class PisoInstSearch extends PisoInst
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_piso', 'id_edificio'], 'integer'],
            [['nombre_piso'], 'safe'],
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
        $query = PisoInst::find();

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
            'id_piso' => $this->id_piso,
            'id_edificio' => $this->id_edificio,
        ]);

        $query->andFilterWhere(['like', 'nombre_piso', $this->nombre_piso]);

        return $dataProvider;
    }
}
