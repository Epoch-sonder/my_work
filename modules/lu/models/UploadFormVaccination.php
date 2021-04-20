<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadFormVaccination extends Model
{
    /**
     * @var UploadedFile
     */

    public $vaccin;


    public function rules()
    {
        return [
            [[
                'vaccin'], 'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,
                'extensions' => ['pdf', 'doc', 'docx'],
                'maxSize' => 35840000, // 35 МБ = 35000 * 1024 байта = 35840000 байт
                'tooBig' => 'Ограничение 5 МB'
            ],
            [['vaccin'], 'required'],
            [['check_num'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'vaccin' => 'Документы',
        ];
    }


    public function upload()
    {
        if ($this->validate()) {


            $uploaddir = './docs/lu/vaccination/';

            // Если директории не существует, создаем ее
            if (!is_dir($uploaddir)) mkdir($uploaddir, 0777);

//            $upload_files = "";

            if (isset($this->vaccin)) {
                $prefix = 'vaccination_';
                $postfix = $this->vaccin->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->vaccin->saveAs($filenamefull);
//                $realpath_vaccin = realpath($filenamefull);
//                $upload_files .= $realpath_vaccin;
            }

            return $filename;

        }
    }
}


