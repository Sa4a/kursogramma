<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "products_catalog".
 *
 * @property int $catalog_id
 * @property int $catalog_pid
 * @property string|null $catalog_import_hash под результат функции md5() или 1С uid
 * @property string $catalog_name
 */
class ProductsCatalog extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_catalog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_pid', 'catalog_name'], 'required'],
            [['catalog_pid'], 'integer'],
            [['catalog_import_hash', 'catalog_name'], 'string', 'max' => 255],
            [['catalog_import_hash'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_id' => 'Catalog ID',
            'catalog_pid' => 'Catalog Pid',
            'catalog_import_hash' => 'Catalog Import Hash',
            'catalog_name' => 'Catalog Name',
        ];
    }
}
