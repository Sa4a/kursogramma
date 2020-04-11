<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "domains_params".
 *
 * @property int $domain_id
 * @property string $param_code
 * @property string $param_name
 * @property string|null $param_value
 * @property int $param_type_id
 * @property string|null $param_date_add
 * @property string|null $param_date_edit
 * @property int $param_active
 */
class DomainsParams extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domains_params';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain_id', 'param_code'], 'required'],
            [['domain_id', 'param_type_id', 'param_active'], 'integer'],
            [['param_value'], 'string'],
            [['param_date_add', 'param_date_edit'], 'safe'],
            [['param_code', 'param_name'], 'string', 'max' => 255],
            [['domain_id', 'param_code'], 'unique', 'targetAttribute' => ['domain_id', 'param_code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'domain_id' => 'Domain ID',
            'param_code' => 'Param Code', // типа  алиас для поиска
            'param_name' => 'Param Name',
            'param_value' => 'Param Value',
            'param_type_id' => 'Param Type ID',
            'param_date_add' => 'Param Date Add',
            'param_date_edit' => 'Param Date Edit',
            'param_active' => 'Param Active',
        ];
    }
}
