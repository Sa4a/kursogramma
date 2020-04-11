<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "domain_page".
 *
 * @property int $page_id
 * @property int $domain_id
 * @property string $page_url
 * @property int $page_type_id
 * @property int $page_is_active
 * @property string|null $page_description
 * @property string|null $page_inserted_date
 * @property int|null $page_inserted_member_id
 * @property string|null $page_modified_date
 * @property int|null $page_modified_member_id
 */
class DomainPage extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain_page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain_id', 'page_type_id', 'page_is_active', 'page_inserted_member_id', 'page_modified_member_id'], 'integer'],
            [['page_description'], 'string'],
            [['page_inserted_date', 'page_modified_date'], 'safe'],
            [['page_url'], 'string', 'max' => 255],
            [['domain_id', 'page_url'], 'unique', 'targetAttribute' => ['domain_id', 'page_url']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'page_id' => 'Page ID',
            'domain_id' => 'Domain ID',
            'page_url' => 'Page Url',
            'page_type_id' => 'Page Type ID',  //статичная страница, страница курса , страница урока, страница модуля, старица списка курсов(каталог)
            'page_is_active' => 'Page Is Active',
            'page_description' => 'Page Description',
            'page_inserted_date' => 'Page Inserted Date',
            'page_inserted_member_id' => 'Page Inserted Member ID',
            'page_modified_date' => 'Page Modified Date',
            'page_modified_member_id' => 'Page Modified Member ID',
        ];
    }
}
