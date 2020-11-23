<?php

namespace frontend\models;

use Yii;
use frontend\models\query\TaskQuery;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $implementer_id
 * @property int $category_id
 * @property int $city_id
 * @property string $address
 * @property string $status
 * @property string $title
 * @property string $description
 * @property int $budget
 * @property float $longitude
 * @property float $latitude
 * @property string $end_date
 * @property string $date_created
 *
 * @property ChatMessage[] $chatMessages
 * @property Response[] $responses
 * @property Reviews[] $reviews
 * @property Category $category
 * @property City $city
 * @property User $customer
 */
class Task extends \yii\db\ActiveRecord
{
	const STATUS_NEW = 'new';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'implementer_id', 'category_id', 'city_id', 'address', 'status', 'title', 'description', 'budget', 'longitude', 'latitude', 'end_date', 'date_created'], 'required'],
            [['customer_id', 'implementer_id', 'category_id', 'city_id', 'budget'], 'integer'],
            [['description'], 'string'],
            [['longitude', 'latitude'], 'number'],
            [['end_date', 'date_created'], 'safe'],
            [['address', 'title'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 45],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
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
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'address' => 'Address',
            'status' => 'Status',
            'title' => 'Title',
            'description' => 'Description',
            'budget' => 'Budget',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'end_date' => 'End Date',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * Gets query for [[ChatMessages]].
     *
     * @return \yii\db\ActiveQuery|ChatMessageQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery|ResponseQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
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
     * {@inheritdoc}
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
