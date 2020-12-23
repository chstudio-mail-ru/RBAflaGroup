<?php

use yii\db\Migration;

/**
 * Class m201222_122722_authors
 */
class m201222_122722_authors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `authors` (
              `id` int(11) NOT NULL,
              `surname` varchar(255) NOT NULL,
              `name` varchar(255) NOT NULL,
              `patronymic` varchar(255) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("INSERT INTO `authors` (`id`, `surname`, `name`, `patronymic`) VALUES
            (1, 'Семенов', 'Петр', 'Сергеевич'),
            (2, 'Андреев', 'Иван', ''),
            (7, 'Автор', 'Без журналов', ''),
            (8, 'Автор', 'с журналами', '');
        ");

        $this->execute("ALTER TABLE `authors`
          ADD PRIMARY KEY (`id`);
        ");

        $this->execute("ALTER TABLE `authors`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('authors');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201222_122722_authors cannot be reverted.\n";

        return false;
    }
    */
}
