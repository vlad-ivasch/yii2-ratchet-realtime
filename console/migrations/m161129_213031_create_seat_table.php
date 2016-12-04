<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seat`.
 */
class m161129_213031_create_seat_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('seat', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('seat');
    }
}
