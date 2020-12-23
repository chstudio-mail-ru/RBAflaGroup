<?php

use yii\db\Migration;

/**
 * Class m201222_122742_magazines
 */
class m201222_122742_magazines extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `magazines` (
              `id` int(11) NOT NULL,
              `name` varchar(255) NOT NULL,
              `description` varchar(1024) NOT NULL,
              `date_add` timestamp NOT NULL DEFAULT current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("INSERT INTO `magazines` (`id`, `name`, `description`, `date_add`) VALUES
            (1, 'Журнал номер 1', 'Журнал про жизнь', '2020-06-09 21:00:00'),
            (2, 'Журнал номер 2', 'Журнал про людей', '2020-12-19 21:00:00'),
            (13, 'Моховая', 'про город', '2020-12-21 21:00:00');
        ");

        $this->execute("ALTER TABLE `magazines`
            ADD PRIMARY KEY (`id`);
        ");

        $this->execute("ALTER TABLE `magazines`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
            COMMIT;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('magazines');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201222_122742_magazines cannot be reverted.\n";

        return false;
    }
    */
}
