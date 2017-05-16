<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_clients_groups".
 *
 * @property integer $ID
 * @property integer $CLIENT_ID
 * @property integer $CLIENTS_GROUPS_ID
 *
 * @property Clients $cLIENT
 * @property ClientsGroups $cLIENTSGROUPS
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
            [['CLIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['CLIENT_ID' => 'ID']],
            [['CLIENTS_GROUPS_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ClientsGroups::className(), 'targetAttribute' => ['CLIENTS_GROUPS_ID' => 'ID']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['ID' => 'CLIENT_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsGroups()
    {
        return $this->hasOne(ClientsGroups::className(), ['ID' => 'CLIENTS_GROUPS_ID']);
    }


    /**
     * getting groups name
     *
     * @return mixed
     */
    public function getGroupName() {
        return $this->clientsGroups->NAME;
    }
}
