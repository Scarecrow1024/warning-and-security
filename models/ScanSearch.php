<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Scan;

/**
 * ScanSearch represents the model behind the search form about `app\models\Scan`.
 */
class ScanSearch extends Scan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'status', 'alarm_status', 'alarm_group'], 'integer'],
            [['name', 'domail', 'node', 'user', 'time', 'alarm_condition'], 'safe'],
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
        $query = Scan::find();

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
            'status' => $this->status,
            'time' => $this->time,
            'alarm_status' => $this->alarm_status,
            'alarm_group' => $this->alarm_group,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'domail', $this->domail])
            ->andFilterWhere(['like', 'node', $this->node])
            ->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'alarm_condition', $this->alarm_condition]);

        return $dataProvider;
    }
}
