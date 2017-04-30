<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PrMed;

/**
 * PrMedSearch represents the model behind the search form about `backend\models\PrMed`.
 */
class PrMedSearch extends PrMed
{
    /**
     * @inheritdoc
     */
   	
	 public $profespecialidad;
	 
    public function rules()
    {
        return [
            [['rut', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'email', 'direccion', 'profespecialidad'], 'safe'],
            [['telefono'], 'integer'],
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
        $query = PrMed::find();
		
		$query->joinWith(['profespecialidad']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['rut' => SORT_DESC]]
        ]);
		
		$dataProvider->sort->attributes['profespecialidad'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['pr_esp.rut' => SORT_ASC],
        'desc' => ['pr_esp.rut' => SORT_DESC],
    ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'telefono' => $this->telefono,
			'pr_esp.codigoEspecialidad' => $this->profespecialidad,
        ]);

        $query->andFilterWhere(['like', 'pr_med.rut', $this->rut])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellidoPaterno', $this->apellidoPaterno])
            ->andFilterWhere(['like', 'apellidoMaterno', $this->apellidoMaterno])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'direccion', $this->direccion]);

        return $dataProvider;
    }
}
