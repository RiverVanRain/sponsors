<?php

use humhub\widgets\PanelMenu;
use yii\helpers\Html;
?>

<div class="panel panel-default panel-new-people" id="panel-new-people">
    <?= PanelMenu::widget(['id' => 'panel-new-people']); ?>
    <div class="panel-heading">
        <?= $title; ?>
    </div>
    <div class="panel-body">
		<?php if (!empty($sponsors)): ?>
		<ul class="media-list" id="sponsors-block">
		<?php foreach ($sponsors as $sponsorName => $sponsor) : ?>
			<li class="activity-entry">
				<a href="<?= $sponsor['url']; ?>" target="_blank">
					<div class="media">
						<span class="pull-left">
						<img class="media-object img-rounded" src="<?= $sponsor['image']; ?>" width="50" style="width: 50px;"></span>          
						
						<div class="media-body text-break">
							<strong><?= Html::encode($sponsorName) ?></strong><br>
							<?= $sponsor['description']; ?>
							</div>
					</div>
				</a>
			</li>
	   <?php endforeach; ?>
		</ul>
		<?php else: ?>
			<p><strong><?= Yii::t('SponsorsModule.base', 'Currently no sponsors'); ?></strong></p>
		<?php endif; ?>
		
    </div>
</div>
<script>
  (async function() {
    
    var selector = '#sponsors-block';
    
    while (true) {
      
      await new Promise(function(s) { setTimeout(s, 180*1000); });
      
      try {
        var html = await (await fetch(location.href)).text();
        var newdoc = new DOMParser().parseFromString(html, 'text/html');
        document.querySelector(selector).outerHTML = newdoc.querySelector(selector).outerHTML;
      } catch(err) {
      }
    }
  })();
</script>