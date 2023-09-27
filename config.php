<?php

use humhub\modules\dashboard\widgets\Sidebar;

return [
    'id' => 'sponsors',
    'class' => 'humhub\modules\sponsors\Module',
    'namespace' => 'humhub\modules\sponsors',
    'events' => [
        ['class' => Sidebar::class, 'event' => Sidebar::EVENT_INIT, 'callback' => ['humhub\modules\sponsors\Module', 'onSidebarInit']],
    ],
];
?>