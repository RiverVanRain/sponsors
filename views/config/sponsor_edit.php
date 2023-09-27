<?php

use humhub\libs\Html;
use humhub\modules\sponsors\forms\SponsorsConfigureForm;
use humhub\modules\sponsors\libs\LogoImage;
use humhub\widgets\Button;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var SponsorsConfigureForm $model */

\humhub\modules\sponsors\assets\SponsorsAsset::register($this);

$this->registerJsConfig('sponsors', [
    'text' => [
        'confirm.deleteLogo.header' => Yii::t('SponsorsModule.base', '<strong>Confirm</strong> image deletion'),
        'confirm.deleteLogo.body' => Yii::t('UserModule.account', 'Do you really want to delete your image?'),
        'confirm.deleteLogo.confirm' => Yii::t('SponsorsModule.base', 'Delete'),
    ]
]);

?>

<div class="clearfix">
    <?= Button::back(Url::to(['config/config']), Yii::t('SponsorsModule.base', 'Back to overview')) ?>
    <h4 class="pull-left">
        <?php
        if (empty($name)) {
            echo Yii::t('SponsorsModule.base', 'Add Sponsor');
        } else {
            echo Yii::t('SponsorsModule.base', 'Edit Sponsor');
        }
        ?>
    </h4>
</div>

<br>

<?php $form = ActiveForm::begin(['id' => 'sponsor-edit-form']); ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, 'name')->textInput(['class' => 'form-control']); ?>

<?= $form->field($model, 'url')->textInput(['class' => 'form-control']); ?>

<?= $form->field($model, 'description')->textarea(['id' => 'sponsor-edit-form-description', 'rows' => 3, 'maxlength' => 200]); ?>
<p class="help-block"><?= Yii::t('SponsorsModule.base', 'Maximum 200 symbols.'); ?></p>

<?php
    if (isset($name)) {
?>
<div class="well">
    <?= $form->field($model, 'logo')->fileInput(['id' => 'logo-file-upload', 'data-action-change' => 'sponsors.changeLogo', 'style' => 'display: none', 'name' => 'logo[]']); ?>
    <div class="image-upload-container" id="logo-upload">
		<img class="img-rounded" id="logo-image" src="<?= LogoImage::getUrl($name) ?>"
            alt="<?= Yii::t('SponsorsModule.base', "You're using no image at the moment. Upload your image now."); ?>"
            style="max-height: 40px;<?= LogoImage::hasImage($name) ? '' : 'display:none' ?>">

        <div class="image-upload-buttons" id="logo-upload-buttons" style="display: block;">
            <?= Button::info()->icon('cloud-upload')->id('logo-upload-button')->sm()->loader(false) ?>
        </div>
    </div>
	<input type="hidden" name="image" value="<?= LogoImage::getUrl($name) ?>" />
</div>
<?php
    } else { ?>
		<div style="margin-bottom: 1rem;"><?= Yii::t('SponsorsModule.base', "After adding a sponsor, return to this editing form and add the sponsor's logo."); ?></div>
<?php	}
?>

<?= Button::primary(Yii::t('SponsorsModule.base', 'Save'))->submit(); ?>

<?php if (!empty($name)): ?>
    <?= Button::danger(Yii::t('SponsorsModule.base', 'Delete'))
        ->link(['sponsor-delete', 'name' => $name])
        ->confirm()
        ->right()
        ->options(['data-method' => 'POST']) ?>
<?php endif; ?>

<?php ActiveForm::end(); ?>