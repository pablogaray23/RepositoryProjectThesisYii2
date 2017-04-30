<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BoxAtencion;

/**
 * BoxAtencionSearch represents the model behind the search form about `backend\models\BoxAtencion`.
 */
class BoxAtencionSearch extends BoxAtencion
{
    /**
     * @inheritdoc
     */
	 
	 public $atencion;
	 
    public function rules()
    {
        return [
            [['id_boxAtencion', 'id_boxGeneral', 'id_atn'], 'integer'],
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
        $query = BoxAtencion::find();

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
            'id_boxAtencion' => $this->id_boxAtencion,
            'id_boxGeneral' => $this->id_boxGeneral,
            'id_atn' => $this->id_atn,
        ]);

        return $dataProvider;
    }
}
