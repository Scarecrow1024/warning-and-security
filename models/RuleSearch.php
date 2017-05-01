<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rule;

/**
 * RuleSearch represents the model behind the search form about `app\models\Rule`.
 */
class RuleSearch extends Rule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 's_level', 'r_level', 'r_par'], 'integer'],
            [['name', 'request_body', 'method', 'par_route', 'route', 'reg'], 'safe'],
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
        $query = Rule::find();

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
            'type' => $this->type,
            's_level' => $this->s_level,
            'r_level' => $this->r_level,
            'r_par' => $this->r_par,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'request_body', $this->request_body])
            ->andFilterWhere(['like', 'method', $this->method])
            ->andFilterWhere(['like', 'par_route', $this->par_route])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'reg', $this->reg]);

        return $dataProvider;
    }
}
