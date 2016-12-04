<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "meals".
 *
 * @property integer $id
 * @property string $name
 * @property integer $cooking_time
 *
 * @property Order[] $orders
 */
class Meals extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'meals';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['meal_id' => 'id']);
    }
}
