<?php

namespace humhub\modules\sponsors\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use humhub\modules\sponsors\libs\LogoImage;

class SponsorEditForm extends Model
{
    public $name;
    public $url;
    public $description;
	public $logo;
	public $image;
	
    public function rules()
    {
        return [
            [['name', 'url', 'description'], 'string'],
            [['name', 'description'], 'required'],
			['logo', 'image', 'extensions' => 'png, jpg, jpeg', 'minWidth' => 50, 'minHeight' => 50],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'name' => Yii::t('SponsorsModule.base', 'Sponsor Name'),
            'url' => Yii::t('SponsorsModule.base', 'URL'),
            'description' => Yii::t('SponsorsModule.base', 'Description'),
			'logo' => Yii::t('SponsorsModule.base', 'Logo'),
        ];
    }
	
	public function load($data, $formName = null)
    {
        $files = UploadedFile::getInstancesByName('logo');
        if (count($files) != 0) {
		    $file = $files[0];
			LogoImage::set($file, $this->name);
        }

        return parent::load($data, $formName);
    }
}
