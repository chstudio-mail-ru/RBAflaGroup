<?php

use yii\db\Migration;

/**
 * Class m201222_122815_magazines_ref_authors
 */
class m201222_122815_magazines_ref_authors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `magazines_ref_authors` (
              `id` int(11) NOT NULL,
              `magazine_id` int(11) NOT NULL,
              `author_id` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("INSERT INTO `magazines_ref_authors` (`id`, `magazine_id`, `author_id`) VALUES
            (23, 1, 8),
            (24, 1, 2),
            (25, 2, 8),
            (26, 2, 1),
            (27, 13, 8),
            (28, 13, 2);
        ");

        $this->execute("ALTER TABLE `magazines_ref_authors`
            ADD PRIMARY KEY (`id`);
        ");

        $this->execute("ALTER TABLE `magazines_ref_authors`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
            COMMIT;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201222_122815_magazines_ref_authors cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201222_122815_magazines_ref_authors cannot be reverted.\n";

        return false;
    }
    */
}
