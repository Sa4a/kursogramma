<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "products_properties".
 *
 * @property int $property_id
 * @property string $property_name
 * @property int $property_is_disabled
 */
class ProductsProperties extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_name'], 'required'],
            [['property_is_disabled'], 'integer'],
            [['property_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'property_id' => 'Property ID',
            'property_name' => 'Property Name',
            'property_is_disabled' => 'Property Is Disabled',
        ];
    }
}
