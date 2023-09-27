<?php

namespace humhub\modules\sponsors\widgets;

use Yii;
use humhub\components\Widget;
use humhub\modules\sponsors\forms\SponsorsConfigureForm;
use yii\helpers\Json;

class SponsorsSidebarWidget extends Widget
{
	/**
     * Execute widget
     */
    public function run()
    {
        $config = new SponsorsConfigureForm();

        if (!$config->isVisible()) {
            return '';
        }
		
		$sponsors = [];
		$rand_sponsors = [];
		
		$default = Yii::$app->getModule('sponsors')->settings->get('sponsors');
        if (!empty($default)) {
            $sponsors = Json::decode($default);
			
			if (is_string($sponsors)) {
				$sponsors = [$sponsors];
			}
			
			$count = $config->maxSponsors;
			
			$new_array = $sponsors;
			
			if (count($sponsors) > 1 && count($sponsors) > $count) {
				$rand_sponsors = array_rand($sponsors, $count);
				
				$new_array = [];

				foreach ($rand_sponsors as $name) {
					if ($sponsors[$name]) {
						$new_array[$name] = $sponsors[$name];
					}
				}
			}
        }

        return $this->render('Sponsors', [
            'sponsors' => $new_array,
            'title' => $config->panelTitle,
        ]);
    }

}
