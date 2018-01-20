<?php

namespace app\models;

use Yii;
use yii\base\Exception;

class Prototype extends \yii\db\ActiveRecord
{
    /**
     * Getting rows from clients types table
     *
     * @param array $arParams - array of params
     * @param int   $cacheTime - the caching time
     *
     * @return array|mixed
     */
    public static function getList($arParams = [], $cacheTime = 864000)
    {
        $obCache = Yii::$app->cache;
        $key =  substr(md5(serialize([static::tableName(), __METHOD__, $arParams])), 0, 10);

        $arResult = $obCache->get($key);
        if( empty($arResult) ){
            $obRes = static::find();
            if( !empty($arParams['filter']) ){
                $obRes->where($arParams['filter']);
            }
            if( !empty($arParams['select']) ){
                $obRes->select(array_merge(['ID'], $arParams['select']));
            }

            foreach($obRes->each() as $obItem){
                $arResult[$obItem->ID] = $obItem->toArray();
            }

            if( empty($arResult) ){
                $arResult = [];
            }
            $obCache->add($key, $arResult, $cacheTime);
        }

        return $arResult;
    }

    /**
     * Getting all db table values for gridview filter
     *
     * @return array
     */
    public static function getFilterValues($arFilter = [])
    {
        $arResult = [];
        $arItems = static::getList([
            'select' => ['NAME'],
            'filter' => $arFilter
        ]);

        if( !empty($arItems) ){
            foreach($arItems as $arItem){
                $arResult[$arItem['ID']] = $arItem['NAME'];
            }
        }

        return $arResult;
    }


    /**
     * Finding elem with relations
     * 
     * @param int $id
     * @param     $arParams
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findElem($id = 0, $arParams = [])
    {
        $obModel = static::find();

        if( !empty($arParams['with']) && is_array($arParams['with']) ){
            foreach($arParams['with'] as $withOb){
                $obModel->with($withOb);
            }
        }

        $model = $obModel->where(['ID' => $id])->one();

        return $model;
    }

    /**
     * Before validate handler
     *
     * @return bool
     */
    public function beforeValidate()
    {
        if( $this->load(Yii::$app->request->post()) ){
            $arDateProps = static::getDateProps();
            $arDate = [];

            if( !empty($arDateProps['PROP_NAME']) ){
                if( !in_array('YEAR', $arDateProps['DATE_PARTS']) ){
                    array_unshift($arDateProps['DATE_PARTS'], 'YEAR');
                }

                foreach($arDateProps['DATE_PARTS'] as $partName){
                    switch($partName){
                        case 'DAY':
                            $datePart = 'd';
                            break;
                        case 'MONTH':
                            $datePart = 'm';
                            break;
                        case 'YEAR':
                            $datePart = 'Y';
                            break;
                        default:
                            $datePart = 'd';
                            break;
                    }

                    $arDate[] = empty($this->{$arDateProps['PROP_NAME'] . '_' . $partName}) ? date($datePart) : $this->{$arDateProps['PROP_NAME'] . '_' . $partName};
                }

                $this->{$arDateProps['PROP_NAME']} =  implode('-', $arDate);
            }

        }

        return parent::beforeValidate();
    }

    /**
     * After find handler
     */
    public function afterFind()
    {
        $arDateProps = static::getDateProps();

        try{
            $this->setDateAttribute($arDateProps['PROP_NAME'], $arDateProps['DATE_PARTS']);
        }
        catch(\Exception $e){
            Yii::trace($e);
        }

        return parent::afterFind();
    }


    /**
     * Setting date value for current model fields
     *
     * @param       $propName - Date prop name
     * @param array $arParts - date fields
     *
     * @throws Exception
     */
    public function setDateAttribute($propName, $arParts = [])
    {
        if( empty($propName) ){
            throw new Exception('Empty date prop name');
        }

        $arDate = date_parse($this->{$propName});

        foreach($arParts as $partName){
            $this->{$propName . '_' . $partName} = $arDate[strtolower($partName)];
        }
    }

//    TODO: Оптимизировать фу-ию
    /**
     * Getting date parts for current model
     *
     * @return array
     */
    public static function getDateProps()
    {
        $arParts = [];
        $propName = '';

        $arClassName = explode('\\', self::className());
        $className = end($arClassName);

        switch($className){
            case 'Clients':
                $propName = 'BIRTHDAY';
                array_unshift($arParts, 'YEAR');
                break;
            case 'ClientsEvents':
                $propName = 'EVENT_DATE';
                break;
        }

        return [
            'PROP_NAME' => $propName,
            'DATE_PARTS' => array_merge($arParts, ['MONTH', 'DAY'])
        ];
    }
}
