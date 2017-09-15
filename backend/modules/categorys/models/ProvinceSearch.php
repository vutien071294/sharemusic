<?php

namespace backend\modules\categorys\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\categorys\models\Province;
use backend\components\ComponentBase;
/**
 * ProvinceSearch represents the model behind the search form about `backend\modules\categorys\models\Province`.
 */
class ProvinceSearch extends Province
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_valid', 'create_user_id', 'update_user_id'], 'integer'],
            [['code', 'name', 'country', 'description', 'begin_time', 'end_time', 'create_time', 'update_time','search_text'], 'safe'],
            [['search_text'],'trim'],
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
        $query = Province::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>['code'=> SORT_ASC],
            ],
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
            'begin_time' => $this->begin_time,
            'end_time' => $this->end_time,
            'is_valid' => $this->is_valid,
            'create_time' => $this->create_time,
            'create_user_id' => $this->create_user_id,
            'update_time' => $this->update_time,
            'update_user_id' => $this->update_user_id,
        ]);
        if ($this->search_text) {
            $arr = array();
            $arr_id = array();
            $components = new ComponentBase();
            $search_text_convert = $components->convert_vi_to_en($this->search_text);
            $data_province = Province::find()->select('id, name')->all();
            foreach ($data_province as $key => $value) {
                $temp = array();
                array_push($temp, $value['id']);
                array_push($temp, $components->convert_vi_to_en(trim($value['name'])));
                array_push($arr, $temp);
            }
            foreach ($arr as $key => $value) {
                if (stripos($value[1], $search_text_convert) !== false) {
                    array_push($arr_id, $value[0]);
                }
            }
            $query->andFilterWhere(['ilike', 'code',$this->search_text])
                    ->orFilterWhere(['IN','id', $arr_id]);
        }

        return $dataProvider;
    }
}
