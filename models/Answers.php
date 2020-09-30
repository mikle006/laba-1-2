<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answers".
 *
 * @property int $id
 * @property string $name
 * @property int $isCorrect
 * @property int $id_test
 * @property int $id_questions
 *
 * @property Questions $questions
 * @property Tests $test
 * @property UserAnswers[] $userAnswers
 */
class Answers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_test', 'id_questions'], 'required'],
            [['isCorrect', 'id_test', 'id_questions'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_questions'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['id_questions' => 'id']],
            [['id_test'], 'exist', 'skipOnError' => true, 'targetClass' => Tests::className(), 'targetAttribute' => ['id_test' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'isCorrect' => 'Is Correct',
            'id_test' => 'Id Test',
            'id_questions' => 'Id Questions',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasOne(Questions::className(), ['id' => 'id_questions']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Tests::className(), ['id' => 'id_test']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAnswers()
    {
        return $this->hasMany(UserAnswers::className(), ['id_answers' => 'id']);
    }
}
