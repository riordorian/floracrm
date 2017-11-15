<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrdersSchedule;

/**
 * OrdersScheduleSearch represents the model behind the search form about `app\models\OrdersSchedule`.
 */
class OrdersScheduleSearch extends OrdersSchedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'CLIENT_ID', 'GIFT_RECIPIENT_ID', 'EVENT_ID', 'NEED_DELIVERY', 'OPERATOR_ID'], 'integer'],
            [['SUM', 'PREPAYMENT'], 'number'],
            [['RECEIVING_DATE_START', 'RECEIVING_DATE_END', 'STATUS'], 'safe'],
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
        $query = OrdersSchedule::find();

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
            'ID' => $this->ID,
            'CLIENT_ID' => $this->CLIENT_ID,
            'GIFT_RECIPIENT_ID' => $this->GIFT_RECIPIENT_ID,
            'EVENT_ID' => $this->EVENT_ID,
            'SUM' => $this->SUM,
            'RECEIVING_DATE_START' => $this->RECEIVING_DATE_START,
            'RECEIVING_DATE_END' => $this->RECEIVING_DATE_END,
            'NEED_DELIVERY' => $this->NEED_DELIVERY,
            'OPERATOR_ID' => $this->OPERATOR_ID,
            'PREPAYMENT' => $this->PREPAYMENT,
        ]);

        $query->andFilterWhere(['like', 'STATUS', $this->STATUS]);

        return $dataProvider;
    }
}
