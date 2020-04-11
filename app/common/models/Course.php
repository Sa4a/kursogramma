<?php

namespace common\models;

use common\behaviors\UploadImageBehavior;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Module $id0
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['insert', 'update'],
                'path' => '@static/'.self::tableName().'/{id}',
                'url' => "@web/uploads/".self::tableName().'/{id}',
                'thumbs' => [
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['image'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'on' => ['insert', 'update']],
            [['name'], 'string', 'max' => 255],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Описание',
            'image' => 'Превью',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


}
