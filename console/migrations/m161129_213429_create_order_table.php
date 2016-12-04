<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m161129_213429_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime(),
            'meal_id' => $this->integer(),
            'seat_id' => $this->integer(),
            'status' => $this->boolean(),
            'waiter_id' => $this->integer(),
            'cooking_time' => $this->integer()
        ]);
        $this->addForeignKey('meal_id-fk', 'order', 'meal_id', 'meals', 'id');
        $this->addForeignKey('seat_id-fk', 'order', 'seat_id', 'seat', 'id');
        $this->addForeignKey('waiter_id-fk', 'order', 'waiter_id', 'user', 'id');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
