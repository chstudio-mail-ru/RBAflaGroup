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

    private static function relationIsExists($magazineId, $authorId)
    {
        return self::find()
            ->where(['magazine_id' => $magazineId])
            ->andWhere(['author_id' => $authorId])
            ->one();
    }

    public static function addRelation($magazineId, $authorId)
    {
        if (!self::relationIsExists($magazineId, $authorId)) {
            try {
                $relation = new MagazinesAuthors();
                $relation->magazine_id = $magazineId;
                $relation->author_id = $authorId;
                return $relation->save();
            } catch (\Throwable $e) {
                return false;
            }
        }

        return false;
    }

    public static function findByAuthorId($authorId): array
    {
        return self::find()
            ->where(['author_id' => $authorId])
            ->all();
    }

    public static function findByMagazineId($magazineId): array
    {
        return self::find()
            ->where(['magazine_id' => $magazineId])
            ->all();
    }

    public static function deleteMagazineRelations($magazineId)
    {
        $relations = self::findByMagazineId($magazineId);
        foreach ($relations as $model) {
            $model->delete();
        }
    }
}