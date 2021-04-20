<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadFormRevision extends Model
{
    /**
     * @var UploadedFile
     */

    public $check_num;
    public $requisitesRequest;
    public $requisitesResponse;
    public $inspectionInformation;
    public $responseOrder;


    public function rules()
    {
        return [
            [[
                'requisitesRequest', 'requisitesResponse', 'inspectionInformation', 'responseOrder' ], 'file',
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

            if (isset($this->inspectionInformation)) {
                $prefix = 'InspectionInformation_';
                $postfix = $this->inspectionInformation->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->inspectionInformation->saveAs($filenamefull);
                $realpath_inspectionInformation = realpath($filenamefull);
                $upload_files .= $realpath_inspectionInformation;
            }

            if (isset($this->responseOrder)) {
                $prefix = 'ResponseOrder_';
                $postfix = $this->responseOrder->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->responseOrder->saveAs($filenamefull);
                $realpath_responseOrder = realpath($filenamefull);
                $upload_files .= $realpath_responseOrder;
            }


            // $filename = $this->dzzRequestFile->baseName . '_'. time() . '.' . $this->dzzRequestFile->extension;
            // $filename = $this->geoFile->baseName . '_'. microtime() . '.' . $this->geoFile->extension;

            return $upload_files;

        } else {
            return false;
        }
    }
}


