<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BoxGeneral;

/**
 * BoxGeneralSearch represents the model behind the search form about `backend\models\BoxGeneral`.
 */
class BoxGeneralSearch extends BoxGeneral
{
    /**
     * @inheritdoc
     */
	 
	 public $sector;
	 public $boxatencion;
	 
    public function rules()
    {
        return [
            [['id_box', 'id_sector'], 'integer'],
            [['nombre_box', 'sector', 'boxatencion'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
		$scenarios['create'][]   = 'field';
		$scenarios['create'][]   = 'campo';
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
        $query = BoxGeneral::find();
		
		$query->joinWith(['boxatencion']);
		
		/*
		
		$query->leftJoin([
				'box_atencion'
				], 'box_atencion.id_boxGeneral = box_general');
		*/
		

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['nombre_box' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_box' => $this->id_box,
			'box_atencion.id_atn' => $this->boxatencion,
            'id_sector' => $this->id_sector,
			'box_general.paraedificio' => $this->paraedificio,
		    'box_general.parapiso' => $this->parapiso,
			
        ]);

        $query->andFilterWhere(['like', 'nombre_box', $this->nombre_box]);
		//$query->andFilterWhere(['like', 'box_general.paraedificio', $this->paraedificio]);
		//$query->andFilterWhere(['like', 'box_general.parapiso', $this->parapiso]);
	//	$query->andFilterWhere(['like', 'atn', $this->paraAtencion]);

        return $dataProvider;
    }
}
