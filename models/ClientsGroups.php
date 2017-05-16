<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_groups".
 *
 * @property integer $ID
 * @property string $NAME
 * @property integer $PERCENT
 *
 * @property ClientsClientsGroups[] $clientsClientsGroups
 */
class ClientsGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'PERCENT'], 'required'],
            [['PERCENT'], 'integer'],
            [['NAME'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Name',
            'PERCENT' => 'Percent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getClientsClientsGroups()
    {
        return $this->hasMany(ClientsClientsGroups::className(), ['CLIENTS_GROUPS_ID' => 'ID']);
    }*/

    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['ID' => 'CLIENT_ID'])
            ->viaTable('clients_clients_groups', ['CLIENTS_GROUPS_ID' => 'ID']);
    }
}
