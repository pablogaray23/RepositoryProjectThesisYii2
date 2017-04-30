<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BoxEquipamiento;

/**
 * BoxEquipamientoSearch represents the model behind the search form about `backend\models\BoxEquipamiento`.
 */
class BoxEquipamientoSearch extends BoxEquipamiento
{
    /**
     * @inheritdoc
     */
	 
	  public $equipamiento;
	 
    public function rules()
    {
        return [
            [['id_box_equipamiento', 'id_equipamiento', 'id_box'], 'integer'],
			[['comentario'], 'safe'],
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
        $query = BoxEquipamiento::find();

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
            'id_box_equipamiento' => $this->id_box_equipamiento,
            'id_equipamiento' => $this->id_equipamiento,
            'id_box' => $this->id_box,
        ]);

        return $dataProvider;
    }
}
