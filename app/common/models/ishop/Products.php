<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $product_id
 * @property int $parent_id
 * @property int $provider_id
 * @property string|null $product_art_code артикул товара
 * @property string|null $product_import_hash хеш товара при импорте (результат функции md5() или 1С uid)
 * @property string $product_name
 * @property int $product_is_deleted
 * @property float|null $product_price_purchase
 * @property float|null $product_price_enter
 * @property float|null $product_price_retail
 * @property float|null $product_price_partner
 * @property int|null $product_partner_discount_percent_max
 * @property float|null $product_price_wholesale
 * @property float|null $product_price_customer
 * @property float|null $product_price_extra
 * @property float|null $product_price_retail_with_delivery
 * @property int|null $product_store_id
 * @property int|null $product_type_id
 * @property int|null $product_unit_id
 * @property int|null $product_class_id
 * @property int|null $product_availability товар доступен для заказа
 * @property string|null $product_availability_date дата установки значения поля 'product_availability'
 * @property int|null $product_min_items_per_order минимальное количество товара в одном заказе
 * @property int|null $product_portion кратность - порционность товаров при заказе
 * @property int|null $product_balance_provider Остаток на складе поставщика
 * @property string $product_add_date
 * @property int $product_purchasing_parcel Партия закупки товаров
 */
class Products extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'provider_id', 'product_is_deleted', 'product_partner_discount_percent_max', 'product_store_id', 'product_type_id', 'product_unit_id', 'product_class_id', 'product_availability', 'product_min_items_per_order', 'product_portion', 'product_balance_provider', 'product_purchasing_parcel'], 'integer'],
            [['product_price_purchase', 'product_price_enter', 'product_price_retail', 'product_price_partner', 'product_price_wholesale', 'product_price_customer', 'product_price_extra', 'product_price_retail_with_delivery'], 'number'],
            [['product_availability_date', 'product_add_date'], 'safe'],
            [['product_art_code', 'product_import_hash', 'product_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'parent_id' => 'Parent ID',
            'provider_id' => 'Provider ID',
            'product_art_code' => 'Product Art Code',
            'product_import_hash' => 'Product Import Hash',
            'product_name' => 'Product Name',
            'product_is_deleted' => 'Product Is Deleted',
            'product_price_purchase' => 'Product Price Purchase',
            'product_price_enter' => 'Product Price Enter',
            'product_price_retail' => 'Product Price Retail',
            'product_price_partner' => 'Product Price Partner',
            'product_partner_discount_percent_max' => 'Product Partner Discount Percent Max',
            'product_price_wholesale' => 'Product Price Wholesale',
            'product_price_customer' => 'Product Price Customer',
            'product_price_extra' => 'Product Price Extra',
            'product_price_retail_with_delivery' => 'Product Price Retail With Delivery',
            'product_store_id' => 'Product Store ID',
            'product_type_id' => 'Product Type ID',
            'product_unit_id' => 'Product Unit ID',
            'product_class_id' => 'Product Class ID',
            'product_availability' => 'Product Availability',
            'product_availability_date' => 'Product Availability Date',
            'product_min_items_per_order' => 'Product Min Items Per Order',
            'product_portion' => 'Product Portion',
            'product_balance_provider' => 'Product Balance Provider',
            'product_add_date' => 'Product Add Date',
            'product_purchasing_parcel' => 'Product Purchasing Parcel',
        ];
    }
}
