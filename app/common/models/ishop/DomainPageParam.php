<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "domain_page_param".
 *
 * @property int $parameter_id
 * @property string $parameter_code
 * @property string $parameter_name
 * @property int|null $parameter_type_id
 * @property string|null $parameter_value_type_code
 * @property string|null $parameter_inserted_date
 * @property int|null $parameter_inserted_member_id
 * @property string|null $parameter_modified_date
 * @property int|null $parameter_modified_member_id
 */
class DomainPageParam extends \common\models\ishop\IshopActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain_page_param';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parameter_type_id', 'parameter_inserted_member_id', 'parameter_modified_member_id'], 'integer'],
            [['parameter_inserted_date', 'parameter_modified_date'], 'safe'],
            [['parameter_code', 'parameter_name', 'parameter_value_type_code'], 'string', 'max' => 255],
            [['parameter_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parameter_id' => 'Parameter ID',
            'parameter_code' => 'Parameter Code',
            'parameter_name' => 'Parameter Name',
            'parameter_type_id' => 'Parameter Type ID',
            'parameter_value_type_code' => 'Parameter Value Type Code',
            'parameter_inserted_date' => 'Parameter Inserted Date',
            'parameter_inserted_member_id' => 'Parameter Inserted Member ID',
            'parameter_modified_date' => 'Parameter Modified Date',
            'parameter_modified_member_id' => 'Parameter Modified Member ID',
        ];
    }
}
