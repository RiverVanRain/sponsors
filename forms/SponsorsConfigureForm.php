<?php

namespace humhub\modules\sponsors\forms;

use humhub\modules\sponsors\Module;
use Yii;
use yii\base\Model;
use yii\helpers\Json;

class SponsorsConfigureForm extends Model
{
    /**
     * @var Module $module
     */
    public $module;

    /**
     * @var string $panelTitle
     */
    public $panelTitle;

    /**
     * @var int $maxSponsors
     */
    public $maxSponsors;

    /**
     * @var bool $displayForMembers
     */
    public $displayForMembers;

    /**
     * @var bool $displayForGuests
     */
    public $displayForGuests;

    public function init()
    {
        parent::init();

        $this->module = Yii::$app->getModule('sponsors');

        $this->panelTitle = $this->module->settings->get('panelTitle') ?: Yii::t('SponsorsModule.base', 'Sponsors');
        $this->maxSponsors = (int) $this->module->settings->get('maxSponsors', 10);
        $this->displayForMembers = (bool) $this->module->settings->get('displayForMembers', true);
        $this->displayForGuests = (bool) $this->module->settings->get('displayForGuests', true);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['maxSponsors'], 'required'],
            [['panelTitle'], 'string'],
            ['maxSponsors', 'integer', 'min' => '0'],
            [['displayForMembers', 'displayForGuests'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'panelTitle' => Yii::t('SponsorsModule.base', 'The panel title for the dashboard widget.'),
            'maxSponsors' => Yii::t('SponsorsModule.base', 'The number of sponsors that will be shown.'),
            'fromDate' => Yii::t('SponsorsModule.base', 'From which registration date should new users displayed as new?'),
            'displayForMembers' => Yii::t('SponsorsModule.base', 'For logged in members'),
            'displayForGuests' => Yii::t('SponsorsModule.base', 'For guests'),
        ];
    }


    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->module->settings->set('panelTitle', $this->panelTitle);
        $this->module->settings->set('maxSponsors', $this->maxSponsors);
        $this->module->settings->set('displayForMembers', $this->displayForMembers);
        $this->module->settings->set('displayForGuests', $this->displayForGuests);

        return true;
    }

    /**
     * Check if the widget is visible on dashboard for current User
     *
     * @return bool
     */
    public function isVisible(): bool
    {
        if ($this->maxSponsors < 1) {
            // Nothing to display
            return false;
        }

        return Yii::$app->user->isGuest ? $this->displayForGuests : $this->displayForMembers;
    }

}
