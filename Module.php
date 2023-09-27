<?php

namespace humhub\modules\sponsors;

use humhub\modules\sponsors\widgets\SponsorsSidebarWidget;
use yii\helpers\Url;

class Module extends \humhub\components\Module
{
    /**
     * @inerhitdoc
     */
    public $resourcesPath = 'resources';

    public static function onSidebarInit($event)
    {
        $event->sender->addWidget(SponsorsSidebarWidget::class, [], ['sortOrder' => 101]);
    }

    /**
     * @inerhitdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/sponsors/config/config']);
    }
}
