<?php

namespace app\models;

use yii\base\InvalidConfigException;
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
    public $magazines;

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
            'magazines' => 'Журналы',
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
     * @return array|ActiveRecord[]
     * @throws InvalidConfigException
     */
    public function getMagazines(): array
    {
        return $this->hasMany(Magazines::class, ['id' => 'magazine_id'])
            ->viaTable(MagazinesAuthors::tableName(), ['author_id' => 'id'])
            ->select('*')
            ->all();
    }
}
