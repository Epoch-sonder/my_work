<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use Yii;

class UploadFormTraining extends Model
{
    /**
     * @var UploadedFile
     */

    public $stripCard;
    public $pppCard;
    public $pppMap;
    public $invite;
    public $act;
    public $taxCard;
    public $statement;
    public $orderBranch;
    public $orderOiv;
    public $namePeople;
    public $people;



    public function rules()
    {
        return [
            [[
                'pppCard','pppMap','invite','act','taxCard','statement','orderBranch','orderOiv','stripCard'], 'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,

                'extensions' => ['pdf'],
                'maxSize' => 35840000, // 35 МБ = 35000 * 1024 байта = 35840000 байт
                'tooBig' => 'Ограничение 35 МB'
            ],
            [ ['namePeople','people'] , 'string' ],
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


            if (isset($this->stripCard)) {
                $prefix = 'stripCard_';
                $postfix = $this->stripCard->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->stripCard->saveAs($filenamefull);
                $realpath_stripCard = realpath($filenamefull);
                $upload_files .= $realpath_stripCard;
            }
            if (isset($this->pppCard)) {
                $prefix = 'pppCard_';
                $postfix = $this->pppCard->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->pppCard->saveAs($filenamefull);
                $realpath_pppCard = realpath($filenamefull);
                $upload_files .= $realpath_pppCard;
            }
             if (isset($this->pppMap)) {
                 $prefix = 'pppMap_';
                 $postfix = $this->pppMap->extension;
                 $filename = $prefix . time() . '.' . $postfix;
                 $filenamefull = $uploaddir . $filename;
                 $this->pppMap->saveAs($filenamefull);
                 $realpath_pppMap = realpath($filenamefull);
                 $upload_files .= $realpath_pppMap;
             }
            if (isset($this->invite)) {
                $prefix = 'Invite_';
                $postfix = $this->invite->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->invite->saveAs($filenamefull);
                $realpath_invite = realpath($filenamefull);
                $upload_files .= $realpath_invite;
            }
            if (isset($this->act)) {
                $prefix = 'Act_';
                $postfix = $this->act->extension;
                $filename = $prefix . time() . '.' . $postfix;
                $filenamefull = $uploaddir . $filename;
                $this->act->saveAs($filenamefull);
                $realpath_act = realpath($filenamefull);
                $upload_files .= $realpath_act;
            }
           if (isset($this->orderBranch)) {
               $prefix = 'OrderBranch_';
               $postfix = $this->orderBranch->extension;
               $filename = $prefix . time() . '.' . $postfix;
               $filenamefull = $uploaddir . $filename;
               $this->orderBranch->saveAs($filenamefull);
               $realpath_orderBranch = realpath($filenamefull);
               $upload_files .= $realpath_orderBranch;
           }
           if (isset($this->orderOiv)) {
               $prefix = 'OrderOiv_';
               $postfix = $this->orderOiv->extension;
               $filename = $prefix . time() . '.' . $postfix;
               $filenamefull = $uploaddir . $filename;
               $this->orderOiv->saveAs($filenamefull);
               $realpath_orderOiv = realpath($filenamefull);
               $upload_files .= $realpath_orderOiv;
           }

           if ($this->people != '_'){
               if (isset($this->taxCard)) {
                   $prefix = 'TaxCard_';
                   $postfix = $this->taxCard->extension;
                   $filename = $prefix . $this->people . time() . '.' . $postfix;
                   $filenamefull = $uploaddir . $filename;
                   $this->taxCard->saveAs($filenamefull);
                   $realpath_taxCard = realpath($filenamefull);
                   $upload_files .= $realpath_taxCard;
               }
               if (isset($this->statement)) {
                   $prefix = 'Statement_';
                   $postfix = $this->statement->extension;
                   $filename = $prefix .  $this->people  . time() . '.' . $postfix;
                   $filenamefull = $uploaddir . $filename;
                   $this->statement->saveAs($filenamefull);
                   $realpath_statement = realpath($filenamefull);
                   $upload_files .= $realpath_statement;
               }
           }


            return $upload_files;

        } else {
            return false;
        }
    }
}


