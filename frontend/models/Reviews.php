<?php

namespace frontend\models;

use Yii;
use frontend\models\query\ReviewsQuery;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $implementer_id
 * @property int $task_id
 * @property string $message
 * @property int $rate
 * @property string $date_created
 *
 * @property User $customer
 * @property User $implementer
 * @property Task $task
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'implementer_id', 'task_id', 'message', 'date_created'], 'required'],
            [['customer_id', 'implementer_id', 'task_id', 'rate'], 'integer'],
            [['message'], 'string'],
            [['date_created'], 'safe'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['implementer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['implementer_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'implementer_id' => 'Implementer ID',
            'task_id' => 'Task ID',
            'message' => 'Message',
            'rate' => 'Rate',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Implementer]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getImplementer()
    {
        return $this->hasOne(User::className(), ['id' => 'implementer_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReviewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewsQuery(get_called_class());
    }
}
