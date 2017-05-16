<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property integer $ID
 * @property string $NAME
 * @property string $TYPE
 * @property string $GENDER
 * @property string $BIRTHDAY
 * @property string $PHONE
 * @property string $EMAIL
 * @property string $DESCRIPTION
 *
 * @property ClientsClientsGroups[] $clientsClientsGroups
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'TYPE', 'PHONE'], 'required'],
            [['BIRTHDAY'], 'safe'],
            [['DESCRIPTION'], 'string'],
            [['NAME'], 'string', 'max' => 100],
            [['TYPE'], 'string', 'max' => 30],
            [['GENDER'], 'string', 'max' => 1],
            [['PHONE'], 'string', 'max' => 20],
            [['EMAIL'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'Id',
            'NAME' => 'Имя',
            'TYPE' => 'Тип клиента',
            'GENDER' => 'Пол',
            'BIRTHDAY' => 'Дата рождения',
            'PHONE' => 'Телефон',
            'EMAIL' => 'Email',
            'DESCRIPTION' => 'Описание',
            'CLIENT_GROUP' => 'Группа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsClientsGroups()
    {
        return $this->hasOne(ClientsClientsGroups::className(), ['CLIENT_ID' => 'ID']);
    }
}
