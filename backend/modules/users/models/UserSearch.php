<?php

namespace backend\modules\users\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\users\models\User;
use backend\components\ComponentBase;

/**
 * UserSearch represents the model behind the search form about `backend\modules\users\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'create_user_id', 'update_user_id', 'type_login', 'last_login_time', 'create_time', 'update_time', 'type'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'serialcert', 'userdisplay', 'image'], 'safe'],
            [['search_text','dai_ly_id'], 'trim']
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
        $query = User::find();

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
         $query->andFilterWhere([
            'id' => $this->id
            ]);
        // grid filtering conditions

        $query->andFilterWhere([
            'or',
            ['like', 'username', $this->username],
            ['like', 'userdisplay', $this->username],
        ]);
        if ($this->search_text) {
            $arr = array();
            $arr_id = array();
            $components = new ComponentBase();
            $search_text_end = strtoupper($components->convert_vi_to_en($this->search_text));
            // convert dữ liệu lấy ra từ db thành chữ hoa không dấu
            $data = User::find()->select('id, username, userdisplay')->all();
            
            foreach ($data as $key => $value) {
                $temp = array();
                array_push($temp, $value->id);
                array_push($temp, strtoupper($components->convert_vi_to_en(trim($value->username))));
                array_push($temp, strtoupper($components->convert_vi_to_en(trim($value->userdisplay))));
                array_push($arr, $temp);
            }
            foreach ($arr as $key => $value) {
                if (strpos($value[1], $search_text_end) !== false) {
                    array_push($arr_id, $value[0]);
                }else{
                    if (strpos($value[2], $search_text_end) !== false) {
                        array_push($arr_id, $value[0]);
                    }
                }
            }
            array_values($arr_id);
            if ($arr_id) {
                $query->andFilterWhere([
                    'or',
                    ['IN', 'id', $arr_id],
                    ['IN', 'id', $arr_id],
                ]);
            }else{
                $query->andFilterWhere([
                    'id' => 0,
                ]);
            }
        }

        return $dataProvider;
    }
}
