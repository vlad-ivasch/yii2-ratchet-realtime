<?php

use yii\db\Migration;

/**
 * Handles the creation of table `meals`.
 */
class m161129_213116_create_meals_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('meals', [
            'id' => $this->primaryKey(),
            'name' => $this->string(250),
        ]);

    }

    public function down()
    {
        $this->dropTable('meals');
    }
}
