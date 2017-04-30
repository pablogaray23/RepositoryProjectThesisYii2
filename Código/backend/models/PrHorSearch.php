<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PrHor;

/**
 * PrHorSearch represents the model behind the search form about `backend\models\PrHor`.
 */
class PrHorSearch extends PrHor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pr_horario', 'dia_semana'], 'integer'],
            [['rut_profesional', 'hora_inicio', 'hora_fin'], 'safe'],
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
        $query = PrHor::find();

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
            'id_pr_horario' => $this->id_pr_horario,
            'dia_semana' => $this->dia_semana,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
        ]);

        $query->andFilterWhere(['like', 'rut_profesional', $this->rut_profesional]);

        return $dataProvider;
    }
}
