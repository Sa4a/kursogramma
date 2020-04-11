<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "lesson".
 *
 * @property int $id
 * @property string $name
 * @property int $module_id
 * @property string $created_at
 * @property string $updated_at
 */
class Lesson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lesson';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['image'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'on' => ['insert', 'update']],
            [['name', 'module_id'], 'required'],
            [['module_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
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
                'url' => '@web/uploads/'.self::tableName().'/{id}',
                'thumbs' => [
                    'thumb' => ['width' => 400, 'quality' => 90],
                    'preview' => ['width' => 200, 'height' => 200],
                ],
            ],
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
            'module_id' => 'Module ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
