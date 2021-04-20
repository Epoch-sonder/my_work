<?php

namespace app\modules\pd\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadFormProcess extends Model
{
    /**
     * @var UploadedFile
     */

    public $pdProcess;



    public function rules()
    {
        return [
            [[  'pdProcess'], 'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,

                'extensions' => ['pdf', 'doc', 'docx', 'xlsx', 'xls', 'rar' , '7z','zip'],
                'maxSize' => 35840000, // 35 МБ = 35000 * 1024 байта = 35840000 байт
                'tooBig' => 'Ограничение 35 МB'
            ],

        ];
    }


    public function upload($uploaddir, $idprocess)
    {
       if ($this->validate()) {

            // $uploaddir = './docs/lu/zakupki/';

            // Если директории не существует, создаем ее
            if (!is_dir($uploaddir)) mkdir($uploaddir, 0777);

            $upload_files = "";


            if (isset($this->pdProcess)) {
                $prefix = 'pdProcess_'.$idprocess.'_';
                $postfix = $this->pdProcess->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->pdProcess->saveAs($filenamefull);
                $realpath_pdProcess = realpath($filenamefull);
                $upload_files .= $realpath_pdProcess;
            }

            return $upload_files;

        } else {
            return false;
        }
    }
}


