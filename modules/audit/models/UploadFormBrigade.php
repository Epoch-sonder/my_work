<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadFormBrigade extends Model
{
    /**
     * @var UploadedFile
     */

    public $fieldOrder;
    public $businessTrip;
    public $namePeople;



    public function rules()
    {
        return [
            [[
                'businessTrip','businessTrip'], 'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,

                'extensions' => ['pdf'],
                'maxSize' => 35840000, // 35 МБ = 35000 * 1024 байта = 35840000 байт
                'tooBig' => 'Ограничение 35 МB'
            ],
            [ ['namePeople'] , 'string' ],
            [['namePeople'], 'safe'],
        ];
    }


    public function upload($uploaddir)
    {
       if ($this->validate()) {

            // $uploaddir = './docs/lu/zakupki/';

            // Если директории не существует, создаем ее
            if (!is_dir($uploaddir)) mkdir($uploaddir, 0777);

            $upload_files = "";


            if (isset($this->fieldOrder)) {
                $prefix = 'fieldOrder_';
                $postfix = $this->fieldOrder->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->fieldOrder->saveAs($filenamefull);
                $realpath_fieldOrder = realpath($filenamefull);
                $upload_files .= $realpath_fieldOrder;
            }
            if (isset($this->businessTrip)) {
                $prefix = 'businessTrip_';
                $postfix = $this->businessTrip->extension;
                $filename = $prefix .  $this->namePeople . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->businessTrip->saveAs($filenamefull);
                $realpath_businessTrip = realpath($filenamefull);
                $upload_files .= $realpath_businessTrip ;
            }
            return $upload_files;

        } else {
            return false;
        }
    }
}


