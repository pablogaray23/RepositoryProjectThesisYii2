<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PrEsp;

/**
 * PrEspSearch represents the model behind the search form about `backend\models\PrEsp`.
 */
class PrEspSearch extends PrEsp
{
    /**
     * @inheritdoc
     */
	 
	 public $especialidad;
	 
    public function rules()
    {
        return [
            [['id_pr_esp', 'codigoEspecialidad', 'anio'], 'integer'],
            [['rut', 'institucion','especialidad'], 'safe'],
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
        $query = PrEsp::find();
		
		$query->joinWith(['especialidad']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['especialidad.nombreEspecialidad' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pr_esp' => $this->id_pr_esp,
			'especialidad.codigoEspecialidad' => $this->especialidad,
            'codigoEspecialidad' => $this->codigoEspecialidad,
            'anio' => $this->anio,
        ]);

        $query->andFilterWhere(['like', 'rut', $this->rut])
            ->andFilterWhere(['like', 'institucion', $this->institucion]);

        return $dataProvider;
    }
}
