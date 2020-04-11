<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "domains".
 *
 * @property int $domain_id
 * @property string $domain_type тип домена (обычный, арендованый и т.д.)
 * @property string $domain
 * @property string $domain_redirects Редиректы на домен
 * @property int $template_id Шаблон домена
 * @property int $rent_id
 * @property string|null $rent_date_created дата создания аренды
 * @property string|null $rent_date_billing_first дата первой оплаты аренды
 * @property string|null $rent_date_billing дата последней оплаты аренды
 * @property string|null $rent_date_expired дата окончания аренды
 * @property float|null $rent_price стоимость аренды домена в месяц
 * @property int $partner_id
 * @property int $system_site_id
 * @property int|null $sale_type_id
 * @property string $use_product_balance Использование системы складов(таблица product_balance)
 * @property string|null $domain_phone_notification Телефон для уведомлений о новых заказах
 * @property string|null $domain_email_notification E-Mail для уведомлений о новых заказах
 * @property string|null $domain_type_notification Тип уведомлений, по расписанию или моментальные
 * @property int $domain_sms_notification Разрешить отправку смс с сайта
 * @property string $domain_manager
 * @property string $domain_comment
 * @property string $domain_date_reg
 * @property string $domain_date_till
 * @property string|null $domain_date_notify
 * @property int $domain_active
 * @property int $domain_deleted
 * @property int $domain_profit_percent
 * @property int|null $domain_orders_manager Менеджер заказов
 * @property int|null $domain_director Руководитель проекта
 * @property int $require_manager_agreement Требуется согласование заказа с менеджером перед оплатой
 * @property int|null $domain_balance_manager
 * @property int $order_amounts_rounding Применять округление к суммам в заказах
 * @property int $order_amounts_rounding_minprice Минимальная цена товара для применения округления
 * @property int $order_allow_red_price Использование минимальной красной цены на домене
 * @property int $sitemap_update
 */
class Domains extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domains';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain_type', 'domain_redirects', 'use_product_balance', 'domain_type_notification', 'domain_comment'], 'string'],
            [['domain', 'domain_redirects', 'domain_manager', 'domain_comment', 'domain_date_reg', 'domain_date_till'], 'required'],
            [['template_id', 'rent_id', 'partner_id', 'system_site_id', 'sale_type_id', 'domain_sms_notification', 'domain_active', 'domain_deleted', 'domain_profit_percent', 'domain_orders_manager', 'domain_director', 'require_manager_agreement', 'domain_balance_manager', 'order_amounts_rounding', 'order_amounts_rounding_minprice', 'order_allow_red_price', 'sitemap_update'], 'integer'],
            [['rent_date_created', 'rent_date_billing_first', 'rent_date_billing', 'rent_date_expired', 'domain_date_reg', 'domain_date_till', 'domain_date_notify'], 'safe'],
            [['rent_price'], 'number'],
            [['domain', 'domain_email_notification', 'domain_manager'], 'string', 'max' => 255],
            [['domain_phone_notification'], 'string', 'max' => 16],
            [['domain'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'domain_id' => 'Domain ID',
            'domain_type' => 'Domain Type',  //standart - значение
            'domain' => 'Domain',
            'domain_redirects' => 'Domain Redirects',
            'domain_active' => 'Domain Active', // 1 или 0
            'domain_deleted' => 'Domain Deleted',

            'template_id' => 'Template ID', // шаблон сайта структура  я пока не использую
            'rent_id' => 'Rent ID', //мне пока не нужно
            'rent_date_created' => 'Rent Date Created',
            'rent_date_billing_first' => 'Rent Date Billing First',
            'rent_date_billing' => 'Rent Date Billing',
            'rent_date_expired' => 'Rent Date Expired',
            'rent_price' => 'Rent Price',
            'partner_id' => 'Partner ID',
            'system_site_id' => 'System Site ID',
            'sale_type_id' => 'Sale Type ID',
            'use_product_balance' => 'Use Product Balance',
            'domain_phone_notification' => 'Domain Phone Notification',
            'domain_email_notification' => 'Domain Email Notification',
            'domain_type_notification' => 'Domain Type Notification',
            'domain_sms_notification' => 'Domain Sms Notification',
            'domain_manager' => 'Domain Manager',
            'domain_comment' => 'Domain Comment',
            'domain_date_reg' => 'Domain Date Reg',
            'domain_date_till' => 'Domain Date Till',
            'domain_date_notify' => 'Domain Date Notify',
            'domain_profit_percent' => 'Domain Profit Percent',
            'domain_orders_manager' => 'Domain Orders Manager',
            'domain_director' => 'Domain Director',
            'require_manager_agreement' => 'Require Manager Agreement',
            'domain_balance_manager' => 'Domain Balance Manager',
            'order_amounts_rounding' => 'Order Amounts Rounding',
            'order_amounts_rounding_minprice' => 'Order Amounts Rounding Minprice',
            'order_allow_red_price' => 'Order Allow Red Price',
            'sitemap_update' => 'Sitemap Update',
        ];
    }
}
