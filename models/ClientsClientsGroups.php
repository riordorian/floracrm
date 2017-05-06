<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_clients_groups".
 *
 * @property integer $ID
 * @property integer $CLIENT_ID
 * @property integer $CLIENTS_GROUPS_ID
 */
class ClientsClientsGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients_clients_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CLIENT_ID', 'CLIENTS_GROUPS_ID'], 'required'],
            [['CLIENT_ID', 'CLIENTS_GROUPS_ID'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CLIENT_ID' => 'Client  ID',
            'CLIENTS_GROUPS_ID' => 'Clients  Groups  ID',
        ];
    }
}
