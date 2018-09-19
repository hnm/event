<?php
	use n2n\impl\web\ui\view\html\HtmlView;
	use event\bo\Event;
	use n2n\web\http\nav\Murl;
	use page\ui\PageHtmlBuilder;
	use dbtext\DbtextHtmlBuilder;
	
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);

	$events = $view->getParam('events');
	
	$pageHtml = new PageHtmlBuilder($view);
	$dbtextHtml = new DbtextHtmlBuilder($view); 
	
	$view->useTemplate('\bstmpl\view\bsTemplate.html');
?>

<?php $pageHtml->contentItems('top') ?>

<div class="event-list">
	<?php foreach ($events as $event): $view->assert($event instanceof Event) ?>
		<?php $eventT = $event->t($view->getN2nLocale()) ?>
		<div class="event-list-event mb-5">
			<div class="event-list-event-kicker">
				<?php $html->out($event->getDateDisplay($view->getN2nLocale())) ?>
				<?php if (null !== $eventT && null !== ($time = $eventT->getTime())): ?>
					| <?php $html->out($time) ?>
				<?php endif ?>
				<?php if (null !== $eventT && null !== ($location = $eventT->getLocation())): ?>
					| <?php $html->out($location) ?>
				<?php endif ?>
			</div>
			<h2 class="event-list-event-title">
				<?php if ($eventT->hasDetail() && $view->buildUrl(Murl::controller()->pathExt($eventT->getPathPart()), false)): ?>
					<?php $html->link(Murl::controller()->pathExt($eventT->getPathPart()), $eventT->getTitle(), array('class' => 'link-no-deco')) ?>
				<?php else: ?>
					<?php $html->out($eventT->getTitle()) ?>
				<?php endif ?>
			</h2>
			<?php if (null !== ($intro = $eventT->getIntro())): ?>
				<p><?php $html->out($intro) ?></p>
			<?php endif ?>
			<?php if ($eventT->hasDetail()): ?>
			<?php $html->link(Murl::controller()->pathExt($eventT->getPathPart()), 
					$dbtextHtml->getT('event_detail_link_txt'), array('class' => 'btn btn-primary')) ?>
			<?php endif ?>
		</div>
	<?php endforeach ?>
</div>

<?php $pageHtml->contentItems('main') ?>
