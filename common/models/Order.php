<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $date
 * @property integer $meal_id
 * @property integer $seat_id
 *
 * @property Meals $meal
 * @property Seat $seat
 */
class Order extends \yii\db\ActiveRecord
{
    const ORDER_STATUS = array('1' => 'cooking', '2' => 'done');

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'cooking_time'], 'integer'],
            [['date'], 'safe'],

            [['waiter_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['waiter_id' => 'id']],

            [['meal_id', 'seat_id'], 'integer'],
            [['meal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Meals::className(), 'targetAttribute' => ['meal_id' => 'id']],
            [['seat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seat::className(), 'targetAttribute' => ['seat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'meal_id' => 'Meal',
            'seat_id' => 'Table',
            'status' => 'Status',
            'waiter_id' => 'Waiter'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeal()
    {
        return $this->hasOne(Meals::className(), ['id' => 'meal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeat()
    {
        return $this->hasOne(Seat::className(), ['id' => 'seat_id']);
    }

    public function getWaiter()
    {
        return $this->hasOne(User::className(), ['id' => 'waiter_id']);
    }
}
