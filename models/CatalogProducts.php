<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CATALOG_PRODUCTS".
 *
 * @property integer $ID
 * @property string $NAME
 * @property string $CODE
 * @property integer $CATALOG_SECTION_ID
 * @property string $IMAGE
 * @property double $BASE_PRICE
 * @property double $RETAIL_PRICE
 * @property integer $EXPIRATION_TIME
 * @property integer $MIN_COUNT
 *
 * @property CatalogSections $cATALOGSECTION
 */
class CatalogProducts extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CATALOG_PRODUCTS';
    }

    public $UPLOAD;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'CATALOG_SECTION_ID', 'BASE_PRICE', 'RETAIL_PRICE'], 'required'],
            [['CATALOG_SECTION_ID', 'EXPIRATION_TIME', 'MIN_COUNT'], 'integer'],
            [['BASE_PRICE', 'RETAIL_PRICE'], 'number'],
            [['NAME', 'CODE'], 'string', 'max' => 70],
            [['UPLOAD'], 'file'],
            [['UPLOAD'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Название',
            'CODE' => 'Артикул',
            'CATALOG_SECTION_ID' => 'Тип товара',
            'UPLOAD' => 'Изображение',
            'IMAGE' => 'Изображение',
            'BASE_PRICE' => 'Закупочная цена',
            'RETAIL_PRICE' => 'Розничная цена',
            'EXPIRATION_TIME' => 'Срок годности, дней',
            'MIN_COUNT' => 'Минимальный остаток',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogSection()
    {
        return $this->hasOne(CatalogSections::className(), ['ID' => 'CATALOG_SECTION_ID'])->inverseOf('catalogProducts');
    }
}