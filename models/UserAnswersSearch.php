<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\UserAnswers`.
 */
class UserAnswersSearch extends UserAnswers
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','ankets_id'], 'integer'],
            [['anketsName','userName','userNames'], 'string'],
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
        $query = UserAnswers::find()
            ->select([
                'user_id'=>'user.id',
                'ankets_id' => 'ankets.id',
                'userName' => 'user.username',
                'anketsName' => 'ankets.name'
            ])
            ->join('join','ankets')
            ->join('join',
                'user',
                'user_answers.ankets_id = ankets.id
                AND user_answers.user_id = user.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'userName',
                'anketsName'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'user.username', $this->userName])
            ->andFilterWhere(['like', 'ankets.name', $this->anketsName]);

        return $dataProvider;
    }
}
