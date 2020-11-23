<?php

namespace frontend\models;

use Yii;
use frontend\models\query\UserQuery;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $city_id
 * @property string $address
 * @property float $longitude
 * @property float $latitude
 * @property string $role
 * @property string $birthday
 * @property string $about
 * @property string $phone
 * @property string $skype
 * @property string $telegram
 * @property int $new_message
 * @property int $actions_task
 * @property int $new_review
 * @property int $show_contacts
 * @property int $now_show_profile
 * @property int $rate
 * @property int $views
 * @property string $last_active
 * @property string $date_created
 *
 * @property Response[] $responses
 * @property Reviews[] $customerReviews
 * @property Reviews[] $implementerReviews
 * @property Specialization[] $specializations
 * @property Task[] $customerTasks
 * @property Task[] $implementerTasks
 * @property City $city
 */
class User extends \yii\db\ActiveRecord
{
	const ROLE_CUSTOMER = 'customer';
	const ROLE_IMPLEMENTER = 'implementer';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'city_id', 'address', 'longitude', 'latitude', 'role', 'birthday', 'about', 'phone', 'skype', 'telegram', 'rate', 'views', 'last_active', 'date_created'], 'required'],
            [['city_id', 'new_message', 'actions_task', 'new_review', 'show_contacts', 'now_show_profile', 'rate', 'views'], 'integer'],
            [['longitude', 'latitude'], 'number'],
            [['birthday', 'last_active', 'date_created'], 'safe'],
            [['about'], 'string'],
            [['name', 'email', 'address'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 64],
            [['role', 'phone', 'skype', 'telegram'], 'string', 'max' => 45],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'email' => 'Email',
            'password' => 'Password',
            'city_id' => 'City ID',
            'address' => 'Address',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'role' => 'Role',
            'birthday' => 'Birthday',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'new_message' => 'New Message',
            'actions_task' => 'Actions Task',
            'new_review' => 'New Review',
            'show_contacts' => 'Show Contacts',
            'now_show_profile' => 'Now Show Profile',
            'rate' => 'Rate',
            'views' => 'Views',
            'last_active' => 'Last Active',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery|ResponseQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['implementer_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getCustomerReviews()
    {
        return $this->hasMany(Reviews::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getImplementerReviews()
    {
        return $this->hasMany(Reviews::className(), ['implementer_id' => 'id']);
    }

    /**
     * Gets query for [[Specializations]].
     *
     * @return \yii\db\ActiveQuery|SpecializationQuery
     */
    public function getSpecializations()
    {
        return $this->hasMany(Specialization::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerTasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Task::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[ImplementerTasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getImplementerTasks()
    {
        return $this->hasMany(Task::className(), ['implementer_id' => 'id']);
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
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
