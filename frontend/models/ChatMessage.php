<?php

namespace frontend\models;

use Yii;
use frontend\models\query\ChatMessageQuery;

/**
 * This is the model class for table "chat_message".
 *
 * @property int $id
 * @property int|null $customer_id
 * @property int|null $implementer_id
 * @property int|null $task_id
 * @property string|null $message
 * @property string|null $date_created
 *
 * @property Task $task
 */
class ChatMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'implementer_id', 'task_id'], 'integer'],
            [['message'], 'string'],
            [['date_created'], 'safe'],
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
            'date_created' => 'Date Created',
        ];
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
     * @return ChatMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChatMessageQuery(get_called_class());
    }
}
