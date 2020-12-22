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
    public $title = "Журналы";
    public $image;
    public $authors;

    public static function tableName(): string
    {
        return 'magazines';
    }

    public function rules(): array
    {
        return [
            [['date_add'], 'date', 'when' => function($model) {
                if ($model->date_add != '1970-01-01') {
                    return !is_numeric(strtotime($model->date_add));
                } else {
                    return true;
                }
            }, 'message' => 'Дата не корректно заполнена'],
            [['name', 'description'], 'string'],
            [['name'], 'required'],
            [['image'], 'file', 'extensions' => 'png, jpg', 'maxSize' => 2 * 1024 * 1024],
            ['authors', 'required', 'message' => 'Выерите хотябы 1 автора'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            [
                'class' => AttributeBehavior::className(),
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
            'image' => 'Изображение',
            'authors' => 'Авторы',
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
     * @return bool|null
     */
    public function upload(): bool
    {
        if ($this->validate() && $this->image) {
            $this->image->saveAs("uploads/".md5($this->id).".".$this->image->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        if (file_exists('uploads/'.md5($this->id).'.jpg')) {
            $this->image = '/uploads/'.md5($this->id).'.jpg';
        } elseif (file_exists('uploads/'.md5($this->id).'.png')) {
            $this->image = '/uploads/'.md5($this->id).'.png';
        }

        return $this->image;
    }

    /**
     * @return array|ActiveRecord[]
     * @throws InvalidConfigException
     */
    public function getAuthors(): array
    {
        return $this->hasMany(Authors::class, ['id' => 'author_id'])
            ->viaTable(MagazinesAuthors::tableName(), ['magazine_id' => 'id'])
            ->select('*')
            ->all();
    }
}