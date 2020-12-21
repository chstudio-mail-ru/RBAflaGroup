<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "authors".
 *
 * @property integer $id
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 *
 */

class Authors extends ActiveRecord
{
    public $title = "Авторы";

    public static function tableName(): string
    {
        return 'authors';
    }

    public function rules(): array
    {
        return [
            [['name', 'patronymic'], 'string'],
            [['surname'], 'string', 'min' => 3],
            [['surname', 'name'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
        ];
    }

    /**
     * @return array|ActiveRecord[]
     */
    public static function getAll(): array
    {
        return self::find()
            ->orderBy(['surname' => SORT_ASC])
            ->all();
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
    public function getMagazines(): ActiveQuery
    {
        return $this->hasMany(Magazines::class, ['id' => 'magazine_id'])
            ->viaTable(MagazinesAuthors::tableName(), ['author_id' => 'id']);
    }
}
