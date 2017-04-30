<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PrAntecedente;

/**
 * PrAntecedenteSearch represents the model behind the search form about `backend\models\PrAntecedente`.
 */
class PrAntecedenteSearch extends PrAntecedente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['rut_med', 'tipoAntecedente', 'nombreArchivo', 'fechaSubida'], 'safe'],
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
        $query = PrAntecedente::find()->where(['<>','tipoAntecedente','5']);
		
		//$query->joinWith(['profespecialidad']);

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
            'id' => $this->id,
			'tipoAntecedente' => $this->tipoAntecedente,
        ]);

        $query->andFilterWhere(['like', 'rut_med', $this->rut_med])
            ->andFilterWhere(['like', 'fechaSubida', $this->fechaSubida])
			
            ->andFilterWhere(['like', 'nombreArchivo', $this->nombreArchivo]);

        return $dataProvider;
    }
	public function searchConvenios($params)
    {
        $query = PrAntecedente::find()->where(['tipoAntecedente'=>'5']);
		
		//$query->joinWith(['profespecialidad']);

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
            'id' => $this->id,
			'tipoAntecedente' => $this->tipoAntecedente,
        ]);

        $query->andFilterWhere(['like', 'rut_med', $this->rut_med])
            ->andFilterWhere(['like', 'fechaSubida', $this->fechaSubida])
			
            ->andFilterWhere(['like', 'nombreArchivo', $this->nombreArchivo]);

        return $dataProvider;
    }
	
}
