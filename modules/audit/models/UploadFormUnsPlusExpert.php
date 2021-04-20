<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadFormUnsPlusExpert extends Model
{
    /**
     * @var UploadedFile
     */

    public $check_num;
    public $requisitesRequest;
    public $requisitesResponse;
    public $completedWork;
    public $conclusionByWork;
    public $proposalsByWork;
    public $contract;


    public function rules()
    {
        return [
            [[
                'requisitesRequest', 'requisitesResponse', 'completedWork', 'conclusionByWork', 'proposalsByWork' ], 'file',
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

            if (isset($this->requisitesRequest)) {
                $prefix = 'RequisitesRequest_';
                $postfix = $this->requisitesRequest->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->requisitesRequest->saveAs($filenamefull);
                $realpath_requisitesRequest = realpath($filenamefull);
                $upload_files .= $realpath_requisitesRequest;
            }


            if (isset($this->requisitesResponse)) {
                $prefix = 'RequisitesResponse_';
                $postfix = $this->requisitesResponse->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->requisitesResponse->saveAs($filenamefull);
                $realpath_requisitesResponse = realpath($filenamefull);
                $upload_files .= $realpath_requisitesResponse;
            }

            if (isset($this->completedWork)) {
                $prefix = 'CompletedWork_';
                $postfix = $this->completedWork->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->completedWork->saveAs($filenamefull);
                $realpath_completedWork = realpath($filenamefull);
                $upload_files .= $realpath_completedWork;
            }

            if (isset($this->conclusionByWork)) {
                $prefix = 'ConclusionByWork_';
                $postfix = $this->conclusionByWork->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->conclusionByWork->saveAs($filenamefull);
                $realpath_conclusionByWork = realpath($filenamefull);
                $upload_files .= $realpath_conclusionByWork;
            }

            if (isset($this->proposalsByWork)) {
                $prefix = 'ProposalsByWork_';
                $postfix = $this->proposalsByWork->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->proposalsByWork->saveAs($filenamefull);
                $realpath_proposalsByWork = realpath($filenamefull);
                $upload_files .= $realpath_proposalsByWork;
            }
            if (isset($this->contract)) {
                $prefix = 'Contract_';
                $postfix = $this->contract->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->contract->saveAs($filenamefull);
                $realpath_contract = realpath($filenamefull);
                $upload_files .= $realpath_contract;
            }


            // $filename = $this->dzzRequestFile->baseName . '_'. time() . '.' . $this->dzzRequestFile->extension;
            // $filename = $this->geoFile->baseName . '_'. microtime() . '.' . $this->geoFile->extension;

            return $upload_files;

        } else {
            return false;
        }
    }
}


