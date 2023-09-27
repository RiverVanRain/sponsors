<?php

namespace humhub\modules\sponsors\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use humhub\modules\sponsors\forms\SponsorsConfigureForm;
use humhub\modules\sponsors\forms\SponsorEditForm;
use humhub\modules\sponsors\libs\LogoImage;
use yii\helpers\Json;

class ConfigController extends Controller
{

    public function getSponsors()
    {
        $sponsors = $this->module->settings->get('sponsors');
        if (!empty($sponsors)) {
            return Json::decode($sponsors);
        }

        return null;
    }

    public function setSponsors($sponsors)
    {
        $this->module->settings->set('sponsors', Json::encode($sponsors));
    }
	
	public function actionConfig()
    {
       $sponsors = $this->getSponsors();
	   $form = new SponsorsConfigureForm();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
        }

        return $this->render('config', [
			'sponsors' => $sponsors,
			'model' => $form,
		]);
    }
	
	public function actionSponsorEdit()
    {
        $form = new SponsorEditForm;

        $name = Yii::$app->request->get('name');
        $sponsors = $this->getSponsors();
		
		$base = '';
        if (Yii::$app->request->isConsoleRequest) {
            $base = Url::base(true);
        }
        $image_url = '/assets/sponsors/'.$name.'_50x50.png';

        if (isset($sponsors[$name])) {
			$form->name = $name;
            $form->url = $sponsors[$name]['url'];
            $form->description = $sponsors[$name]['description'];
			$form->image = $image_url;
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if ($name && isset($sponsors[$name])) {
                unset($sponsors[$name]);
            }
            $sponsors[$form->name] = [
                'url' => $form->url,
                'description' => $form->description,
				'image' => $image_url,
            ];
            $this->setSponsors($sponsors);
			
            return $this->redirect(['/sponsors/config/config']);
        }
		
        return $this->render('sponsor_edit', [
            'model' => $form,
            'name' => $name
        ]);
    }
	
	public function actionSponsorDelete()
    {
        $this->forcePostRequest();
        $name = Yii::$app->request->get('name');
        $sponsors = $this->getSponsors();

        if (isset($sponsors[$name])) {
            unset($sponsors[$name]);
            $this->setSponsors($sponsors);
        }
        return $this->redirect([
            '/sponsors/config/config'
        ]);
    }
	
	public function actionDeleteLogoImage()
    {
        $this->forcePostRequest();
        LogoImage::set(null);

        Yii::$app->response->format = 'json';
        return [];
    }

}
