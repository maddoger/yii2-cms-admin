<?php

namespace maddoger\admin\models\search;

use maddoger\admin\models\Log;
use yii\data\ActiveDataProvider;

class LogSearch extends Log
{
    public function rules()
    {
        return [
            ['level', 'integer'],
            [['category', 'prefix', 'message', 'log_time'], 'string'],
        ];
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
        $query = Log::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->defaultOrder = ['log_time' => SORT_DESC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'level' => $this->level,
        ]);

        $query
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'prefix', $this->prefix])
            ->andFilterWhere(['like', 'message', $this->message]);

        //Smart log time filter
        if ($this->log_time) {
            $startTime = strtotime($this->log_time);
            if ($startTime !== false) {
                $query->andWhere(['>=', 'log_time', $startTime]);
            }
        }

        return $dataProvider;
    }
}