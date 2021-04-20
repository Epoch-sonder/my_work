<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */

    public $requestFalhCa;
    public $requestCaBranch;
    public $check_num;
    public $answerBranchCa;
    public $answerCaFalh;
    public $orderAudit;


    public function rules()
    {
        return [
            [[
                'requestFalhCa', 'requestCaBranch', 'answerCaFalh', 'orderAudit' , 'answerBranchCa'], 'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,
                'extensions' => ['pdf', 'doc','docx'],
                'maxSize' => 35840000, // 35 МБ = 35000 * 1024 байта = 35840000 байт
                'tooBig' => 'Ограничение 5 МB'
            ],
            [['check_num'], 'safe'],
        ];
    }


    public function upload($uploaddir)
    {
        if ($this->validate()) {

            // $uploaddir = './docs/lu/zakupki/';

            // Если директории не существует, создаем ее
            if (!is_dir($uploaddir)) mkdir($uploaddir, 0777);

            $upload_files = "";

            if (isset($this->requestFalhCa)) {
                $prefix = 'RequestFalhCa_';
                $postfix = $this->requestFalhCa->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->requestFalhCa->saveAs($filenamefull);
                $realpath_requestFalhCa = realpath($filenamefull);
                $upload_files .= $realpath_requestFalhCa;
            }


            if (isset($this->requestCaBranch)) {
                $prefix = 'RequestCaBranch_';
                $postfix = $this->requestCaBranch->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->requestCaBranch->saveAs($filenamefull);
                $realpath_requestCaBranch = realpath($filenamefull);
                $upload_files .= $realpath_requestCaBranch;
            }

            if (isset($this->answerBranchCa)) {
                $prefix = 'AnswerBranchCa_';
                $postfix = $this->answerBranchCa->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->answerBranchCa->saveAs($filenamefull);
                $realpath_answerBranchCa = realpath($filenamefull);
                $upload_files .= $realpath_answerBranchCa;
            }

            if (isset($this->answerCaFalh)) {
                $prefix = 'AnswerCaFalh_';
                $postfix = $this->answerCaFalh->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->answerCaFalh->saveAs($filenamefull);
                $realpath_answerCaFalh = realpath($filenamefull);
                $upload_files .= $realpath_answerCaFalh;
            }

            if (isset($this->orderAudit)) {
                $prefix = 'OrderAudit_';
                $postfix = $this->orderAudit->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->orderAudit->saveAs($filenamefull);
                $realpath_orderAudit = realpath($filenamefull);
                $upload_files .= $realpath_orderAudit;
            }

            // $filename = $this->dzzRequestFile->baseName . '_'. time() . '.' . $this->dzzRequestFile->extension;
            // $filename = $this->geoFile->baseName . '_'. microtime() . '.' . $this->geoFile->extension;

            return $upload_files;

        } else {
            return false;
        }
    }
}


