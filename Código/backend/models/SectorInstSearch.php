<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SectorInst;

/**
 * SectorInstSearch represents the model behind the search form about `backend\models\SectorInst`.
 */
class SectorInstSearch extends SectorInst
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sector', 'id_piso'], 'integer'],
            [['nombre_sector'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
		$scenarios['create'][]   = 'field';
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
        $query = SectorInst::find();

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
            'id_sector' => $this->id_sector,
            'id_piso' => $this->id_piso,
        ]);

        $query->andFilterWhere(['like', 'nombre_sector', $this->nombre_sector]);

        return $dataProvider;
    }
}
