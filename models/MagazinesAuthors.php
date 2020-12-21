<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "magazines_ref_authors".
 *
 * @property integer $id
 * @property integer $magazine_id
 * @property integer $author_id
 *
 */
class MagazinesAuthors extends ActiveRecord
{

    public static function tableName()
    {
        return 'magazines_ref_authors';
    }

    public function rules()
    {
        return [
            [['magazine_id', 'author_id'], 'integer'],
        ];
    }

    public static function findByBond($magazine_id, $author_id)
    {
        return self::find()
            ->where(['magazine_id' => $magazine_id])
            ->andWhere(['author_id' => $author_id])
            ->one();
    }

    public static function getRelations($author_id): array
    {
        return self::find()
            ->where(['author_id' => $author_id])
            ->all();
    }

    public static function findByMagazineId($magazine_id): array
    {
        return self::find()
            ->where(['magazine_id' => $magazine_id])
            ->all();
    }

    public static function deleteMagazine($magazine_id)
    {
        $relations = self::findByMagazineId($magazine_id);
        foreach ($relations as $model) {
            $model->delete();
        }
    }
}