<?php

namespace common\models\ishop;

use Yii;

/**
 * This is the model class for table "domains_params_types".
 *
 * @property int $type_id
 * @property string $type_code
 * @property string $type_name
 * @property int $params_num_max
 * @property string|null $type_add_date
 * @property int|null $type_add_mid
 * @property string|null $type_edit_date
 * @property int|null $type_edit_mid
 */
class DomainsParamsTypes extends \common\models\ishop\IshopActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domains_params_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['params_num_max', 'type_add_mid', 'type_edit_mid'], 'integer'],
            [['type_add_date', 'type_edit_date'], 'safe'],
            [['type_code', 'type_name'], 'string', 'max' => 255],
            [['type_code'], 'unique'],
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
            'params_num_max' => 'Params Num Max',
            'type_add_date' => 'Type Add Date',
            'type_add_mid' => 'Type Add Mid',
            'type_edit_date' => 'Type Edit Date',
            'type_edit_mid' => 'Type Edit Mid',
        ];
    }
}
