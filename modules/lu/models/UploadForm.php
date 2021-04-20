<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $dzzRequestFile;
    public $dzzPdFile;
    public $docsStep;
    public $zakup_num;
    public $step_num;

    // public $uploaddir;


    public function rules()
    {
        return [
            [[
                'dzzRequestFile', 'dzzPdFile', 'docsStep'], 'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,
                'extensions' => ['pdf'],
                'maxSize' => 5120000, // 5 МБ = 5000 * 1024 байта = 5120000 байт
                'tooBig' => 'Ограничение 5 МB'
            ],
            [['zakup_num', 'step_num'], 'safe'],
        ];
    }


    public function upload($uploaddir)
    {
        if ($this->validate()) {

            // $uploaddir = './docs/lu/zakupki/';

            // Если директории не существует, создаем ее
            if (!is_dir($uploaddir)) mkdir($uploaddir, 0777);

            $upload_files = "";

            if (isset($this->docsStep)) {
                $postform =Yii::$app->request->post('UploadForm');
                $numStep = $postform['step_num'];
                $prefix = 'docs_PDF_';
                $postfix = $this->docsStep->extension;
                $filename = $prefix .$numStep.'_' . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->docsStep->saveAs($filenamefull);
                $realpath_docsStepFile = realpath($filenamefull);
                $upload_files .= $realpath_docsStepFile;
            }

            if (isset($this->dzzRequestFile)) {
                $prefix = 'RequestPdDzz_';
                $postfix = $this->dzzRequestFile->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->dzzRequestFile->saveAs($filenamefull);
                $realpath_dzzRequestFile = realpath($filenamefull);
                $upload_files .= $realpath_dzzRequestFile;
            }


            if (isset($this->dzzPdFile)) {
                $prefix = 'PdDzz_';
                $postfix = $this->dzzPdFile->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->dzzPdFile->saveAs($filenamefull);
                $realpath_dzzPdFile = realpath($filenamefull);
                $upload_files .= $realpath_dzzPdFile;
            }

            // $filename = $this->dzzRequestFile->baseName . '_'. time() . '.' . $this->dzzRequestFile->extension;
            // $filename = $this->geoFile->baseName . '_'. microtime() . '.' . $this->geoFile->extension;

            return $upload_files;

        } else {
            return false;
        }
    }
}

   
