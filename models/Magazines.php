<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\AttributeBehavior;
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
            [['date_add'], 'date', 'format' => 'php:d.m.Y'],
            [['name', 'description'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            [
                'class'      => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_add'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_add'],
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime($this->date_add));
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'description' => 'Краткое описание',
            'date_add' => 'Дата',
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