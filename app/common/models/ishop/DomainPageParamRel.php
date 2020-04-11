<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "domain_page_param_rel".
 *
 * @property int $relation_id
 * @property int $domain_id
 * @property int $page_id
 * @property int $parameter_id
 * @property string|null $relation_value
 * @property string|null $relation_inserted_date
 * @property int|null $relation_inserted_member_id
 * @property string|null $relation_modified_date
 * @property int|null $relation_modified_member_id
 */
class DomainPageParamRel extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain_page_param_rel';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain_id', 'page_id', 'parameter_id', 'relation_inserted_member_id', 'relation_modified_member_id'], 'integer'],
            [['relation_value'], 'string'],
            [['relation_inserted_date', 'relation_modified_date'], 'safe'],
            [['domain_id', 'page_id', 'parameter_id'], 'unique', 'targetAttribute' => ['domain_id', 'page_id', 'parameter_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'relation_id' => 'Relation ID',
            'domain_id' => 'Domain ID',
            'page_id' => 'Page ID',
            'parameter_id' => 'Parameter ID',
            'relation_value' => 'Relation Value',
            'relation_inserted_date' => 'Relation Inserted Date',
            'relation_inserted_member_id' => 'Relation Inserted Member ID',
            'relation_modified_date' => 'Relation Modified Date',
            'relation_modified_member_id' => 'Relation Modified Member ID',
        ];
    }
}
