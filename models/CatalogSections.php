<?php

namespace app\models;

use Imagine\Image\ImageInterface;
use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "catalog_sections".
 *
 * @property integer $ID
 * @property string $NAME
 * @property string $IMAGE
 *
 * @property CATALOGPRODUCTS[] $cATALOGPRODUCTSs
 */
class CatalogSections extends Prototype
{
    public $UPLOAD;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_sections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME'], 'required'],
            [['NAME'], 'string', 'max' => 50],
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
            'IMAGE' => 'Изображение',
            'UPLOAD' => 'Изображение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogProducts()
    {
        return $this->hasMany(CatalogProducts::className(), ['CATALOG_SECTION_ID' => 'ID'])->inverseOf('cATALOGSECTION');
    }


    /**
     * @param bool $insert
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::beforeSave($insert, $changedAttributes);

        # cropping image
        $docRoot = \Yii::getAlias('@webroot');
        $dummyWebPath = '/uploads/catalog_sections/dummy.jpg';
        $dummy = Image::thumbnail($docRoot . '/assets/terminal/img/dummy.jpg', 500, 360)->save($docRoot . $dummyWebPath);

        if( !empty($this->IMAGE) && file_exists($docRoot . $this->IMAGE) ){
            $image = $docRoot . $this->IMAGE;
            $newImg = $docRoot . '/uploads/catalog_sections/SECTION_' . $this->ID . '.jpg';
            Image::thumbnail($image, 500, 360)->save($newImg, ['quality' => 100]);
            Image::crop($image, 500, 360)->save($newImg, ['quality' => 100]);
        }
        elseif( empty($this->IMAGE) && file_exists($docRoot . $dummyWebPath) ){
            $this->IMAGE = $dummyWebPath;
            $this->save(true);
        }
    }
}
