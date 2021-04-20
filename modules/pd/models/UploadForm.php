<?php

namespace app\modules\pd\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    // public $dzzRequestFile;
    public $pdFile;
    public $pd_work;
    // public $uploaddir;


    public function rules()
    {
        return [
            [
                ['pdFile'], 'file', 
                'skipOnEmpty' => true, 
                'checkExtensionByMimeType' => false, 
                'extensions' => ['pdf'],
                'maxSize' => 5120000, // 5 МБ = 5000 * 1024 байта = 5120000 байт
                'tooBig' => 'Ограничение 5 МB'
            ],
            [['pd_work'], 'safe'],
         ];
    }
    

    public function upload($uploaddir)
    {
        if ($this->validate()) {
            
            // $uploaddir = './docs/lu/zakupki/';
            
            // Если директории не существует, создаем ее
            if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

            $upload_files = "";

                // if(isset($this->dzzRequestFile)) {
                //     $prefix = 'RequestPdDzz_';
                //     $postfix = $this->dzzRequestFile->extension;
                //     $filename = $prefix . time() . '.' . $postfix;
                //     $filenamefull = $uploaddir.$filename;
                //     $this->dzzRequestFile->saveAs($filenamefull);
                //     $realpath_dzzRequestFile = realpath( $filenamefull );
                //     $upload_files .= $realpath_dzzRequestFile;
                // }

                if(isset($this->pdFile)) {
                    $prefix = 'Pd_';
                    $postfix = $this->pdFile->extension;
                    $filename = $prefix . time() . '.' . $postfix;
                    $filenamefull = $uploaddir.$filename;
                    $this->pdFile->saveAs($filenamefull);
                    $realpath_pdFile = realpath( $filenamefull );
                    $upload_files .= $realpath_pdFile;
                }    

            // $filename = $this->dzzRequestFile->baseName . '_'. time() . '.' . $this->dzzRequestFile->extension;
            // $filename = $this->geoFile->baseName . '_'. microtime() . '.' . $this->geoFile->extension;

            return $upload_files;

        } else {
            return false;
        }
    }

   
}