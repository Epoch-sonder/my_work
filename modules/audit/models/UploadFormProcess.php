<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadFormProcess extends Model
{
    /**
     * @var UploadedFile
     */

    public $sectionProcess;
    public $signatureReference;


    public function rules()
    {
        return [
            [[
                'sectionProcess', 'signatureReference'], 'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,
                'extensions' => ['pdf', 'doc', 'docx'],
                'maxSize' => 35840000, // 35 МБ = 35000 * 1024 байта = 35840000 байт
                'tooBig' => 'Ограничение 5 МB'
            ],
            [['check_num'], 'safe'],
        ];
    }


    public function upload($uploaddir)
    {
        if ($this->validate()) {

//             $uploaddir = './docs/audit/process/1/';

            // Если директории не существует, создаем ее
            if (!is_dir($uploaddir)) mkdir($uploaddir, 0777);

            $upload_files = "";

            if (isset($this->sectionProcess)) {
                $prefix = 'sectionProcess_';
                $postfix = $this->sectionProcess->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->sectionProcess->saveAs($filenamefull);
                $realpath_sectionProcess = realpath($filenamefull);
                $upload_files .= $realpath_sectionProcess;
            }
            if (isset($this->signatureReference)) {
                $prefix = 'signatureReference_';
                $postfix = $this->signatureReference->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->signatureReference->saveAs($filenamefull);
                $realpath_signatureReference = realpath($filenamefull);
                $upload_files .= $realpath_signatureReference;
            }

            return $upload_files;

        } else {
            return false;
        }
    }
}


