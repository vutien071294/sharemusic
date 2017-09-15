<?php

namespace backend\modules\systems\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\systems\models\Log;
use backend\components\ComponentBase;
/**
 * LogSearch represents the model behind the search form about `backend\modules\systems\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'create_time'], 'integer'],
            [['action', 'resource', 'decription','user_id'], 'safe'],
            ['resource', 'trim'],
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
        $query = Log::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'sort'=>[
                'defaultOrder'=>['create_time'=>SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        if ($this->resource) 
            {
                $arr = array();
                $arr_id = array();
                $components = new ComponentBase();
                $resource_convert = $components->convert_vi_to_en($this->resource);
                $data_resource = Log::find()->select('id, resource')->all();
                foreach ($data_resource as $key => $value) {
                    $temp = array();
                    array_push($temp, $value['id']);
                    array_push($temp, $components->convert_vi_to_en(trim($value['resource'])));
                    array_push($arr, $temp);
                }
                foreach ($arr as $key => $value) {
                    if (stripos($value[1], $resource_convert) !== false) {
                        array_push($arr_id, $value[0]);
                    }
                }
                if ($arr_id) 
                    {
                        $query->andFilterWhere(['IN', 'id', $arr_id]);
                    }
                else
                    {
                        $query->andFilterWhere(['id' => 0]);
                    }
               
            }

        if ($this->user_id) 
            {
                $query->andFilterWhere(['user_id' => $this->user_id]);
            }

        return $dataProvider;
    }
}
