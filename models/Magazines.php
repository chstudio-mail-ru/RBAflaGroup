<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "magazines".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $date_add
 *
 */

class Magazines extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'magazines';
    }

    public function rules(): array
    {
        return [
            [['id', 'date_add'], 'integer'],
            [['name', 'description'], 'string']
        ];
    }

    /**
     * @return array|ActiveRecord[]
     */
    public static function getAll(): array
    {
        return self::find()->all();
    }

    /**
     * @param int $id
     * @return ActiveRecord|null
     */
    public static function findById(int $id): ?ActiveRecord
    {
        return self::find()
            ->where(['id' => $id])
            ->one();
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Authors::class, ['id' => 'author_id'])
            ->viaTable(MagazinesAuthors::tableName(), ['magazine_id' => 'id']);
    }
}