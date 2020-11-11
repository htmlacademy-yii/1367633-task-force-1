<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "response".
 *
 * @property int $id
 * @property int $task_id
 * @property int $implementer_id
 * @property string $description
 * @property int $price
 * @property int $rate
 * @property string $date_created
 *
 * @property User $implementer
 * @property Task $task
 */
class Response extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'implementer_id', 'description', 'price', 'rate', 'date_created'], 'required'],
            [['task_id', 'implementer_id', 'price', 'rate'], 'integer'],
            [['description'], 'string'],
            [['date_created'], 'safe'],
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
            'task_id' => 'Task ID',
            'implementer_id' => 'Implementer ID',
            'description' => 'Description',
            'price' => 'Price',
            'rate' => 'Rate',
            'date_created' => 'Date Created',
        ];
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
     * @return ResponseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResponseQuery(get_called_class());
    }
}
