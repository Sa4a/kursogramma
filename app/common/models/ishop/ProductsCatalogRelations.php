<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "products_catalog_relations".
 *
 * @property int $product_id
 * @property int $catalog_id
 */
class ProductsCatalogRelations extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_catalog_relations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'catalog_id'], 'required'],
            [['product_id', 'catalog_id'], 'integer'],
            [['product_id', 'catalog_id'], 'unique', 'targetAttribute' => ['product_id', 'catalog_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'catalog_id' => 'Catalog ID',
        ];
    }
}
