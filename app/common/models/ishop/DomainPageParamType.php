<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "domain_page_param_type".
 *
 * @property int $type_id
 * @property string $type_code
 * @property string $type_name
 * @property string|null $type_desc
 * @property int $type_sort
 * @property string|null $type_inserted_date
 * @property int|null $type_inserted_mid
 * @property string|null $type_modified_date
 * @property int|null $type_modified_mid
 */
class DomainPageParamType extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain_page_param_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_desc'], 'string'],
            [['type_sort', 'type_inserted_mid', 'type_modified_mid'], 'integer'],
            [['type_inserted_date', 'type_modified_date'], 'safe'],
            [['type_code', 'type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'type_code' => 'Type Code',
            'type_name' => 'Type Name',
            'type_desc' => 'Type Desc',
            'type_sort' => 'Type Sort',
            'type_inserted_date' => 'Type Inserted Date',
            'type_inserted_mid' => 'Type Inserted Mid',
            'type_modified_date' => 'Type Modified Date',
            'type_modified_mid' => 'Type Modified Mid',
        ];
    }
}
