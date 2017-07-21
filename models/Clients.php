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
class Clients extends Prototype
{
    public $BIRTHDAY_DAY;
    public $BIRTHDAY_MONTH;
    public $BIRTHDAY_YEAR;

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
            [['NAME', 'PHONE'], 'required', 'message' => 'Поле обязательно для заполнения.'],
            [['BIRTHDAY'], 'safe'],
            [['BIRTHDAY_MONTH', 'BIRTHDAY_DAY', 'BIRTHDAY_YEAR'], 'string'],
            [['DESCRIPTION'], 'string'],
            [['NAME'], 'string', 'max' => 100],
            [['GENDER'], 'string', 'max' => 1],
            ['PHONE', 'string', 'max' => 20],
            [['PHONE'], 'unique', 'message' => 'Номер уже зарегистрирован в системе'],
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
            'NAME' => 'ФИО',
            'CLIENT_TYPE' => 'Тип клиента',
            'GENDER' => 'Пол',
            'BIRTHDAY_DAY' => 'Дата рождения',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsClientsTypes()
    {
        return $this->hasOne(ClientsClientsTypes::className(), ['CLIENT_ID' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsEvents()
    {
        return $this->hasMany(ClientsEvents::className(), ['CLIENT_ID' => 'ID']);
    }


    /**
     * After save element event handler
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
            $obCCTypes = new ClientsClientsTypes();
            $obCCTypes->load(Yii::$app->request->post());

            $obCCGroups = new ClientsClientsGroups();
            $obCCGroups->load(Yii::$app->request->post());

            $obCCGroups->CLIENT_ID = $obCCTypes->CLIENT_ID = $this->ID;

            try{
                $obCCTypes->save(false);
                $obCCGroups->save(false);
            }
            catch(\Exception $e){
                ?><pre><?print_r($e)?></pre><?
            }
    }
}
