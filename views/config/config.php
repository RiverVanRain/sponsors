<?php

use humhub\libs\Html;
use humhub\modules\sponsors\forms\SponsorsConfigureForm;
use humhub\widgets\Button;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var SponsorsConfigureForm $model */
?>

<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('SponsorsModule.base', '<strong>Sponsors</strong> Module Configuration'); ?></div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'panelTitle') ?>
        <?= $form->field($model, 'maxSponsors') ?>

        <?= Html::label(Yii::t('SponsorsModule.base', 'Show on dashboard'), null, ['class' => 'control-label']) ?>
        <?= $form->field($model, 'displayForMembers')->checkbox() ?>
        <?= $form->field($model, 'displayForGuests')->checkbox() ?>

        <hr>
		
		<?= Button::save()->submit() ?>
        <?= Button::defaultType(Yii::t('SponsorsModule.base', 'Back to modules'))->link(['/admin/module']) ?>
		<hr>
		<p class="pull-right">
			<?= Html::a(Yii::t('SponsorsModule.base', 'Add new sponsor'), Url::to(['sponsor-edit']), ['class' => 'btn btn-success']); ?>
		</p>

		<h4><?= Yii::t('SponsorsModule.base', 'Added sponsors'); ?></h4>

		<?php if (!empty($sponsors)): ?>
			<div id="sponsors-lists">
				<?php foreach ($sponsors as $sponsorName => $sponsor) : ?>
					<div class="sponsors-item-container" style="margin-bottom: 1rem;">
						<div class="sponsors-item">

							<div class="sponsors-item-name">
								<span class="pull-left"><img class="img-rounded" src="<?= $sponsor['image']; ?>" style="width: 40px; height: 40px"></span>
								<span style="padding-left: 10px;">
									<?= Html::encode($sponsorName) ?>
								</span>
							</div>

							<?= Html::a(Yii::t('base', 'Edit'), Url::to(['sponsor-edit', 'name' => $sponsorName]), ['data-method' => 'POST', 'style' => 'padding-left: 10px;', 'class' => 'btn btn-xs btn-link']); ?>

						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<p><strong><?= Yii::t('SponsorsModule.base', 'Currently no sponsors'); ?></strong></p>
		<?php endif; ?>

		<hr>
        
        <?php ActiveForm::end() ?>
    </div>
</div>
