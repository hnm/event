<?php
	use n2n\impl\web\ui\view\html\HtmlView;
	use event\bo\CiEvent;
	use event\model\EventDao;
use dbtext\DbtextHtmlBuilder;
use event\bo\EventT;
	
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);
	
	$ciEvent = $view->getParam('ciEvent');
	$view->assert($ciEvent instanceof CiEvent);
	
	$eventDao = $view->lookup(EventDao::class);
	$view->assert($eventDao instanceof EventDao);
	
	$events = $eventDao->getEvents($ciEvent->getSizeType());
	if (count($events) === 0) return;
	
	$dbTextHtml = new DbtextHtmlBuilder($view);
?>
<div class="event-ci-event">
	<h2><?php $dbTextHtml->t('events_heading_txt') ?></h2>
	<ol class="list-unstyled">
		<?php foreach ($events as $event): ?>
			<li>
				<?php $eventT = $event->t($view->getN2nLocale()) ?>
				<div>
					<h3><?php $html->out($eventT->getTitle()) ?>
						<small>
							<?php $html->out($event->getDateDisplay($view->getN2nLocale())) ?>
							<?php if (null !== $eventT && null !== ($time = $eventT->getTime())): ?>
								| <?php $html->out($time) ?>
							<?php endif ?>
							<?php if (null !== $eventT && null !== ($location = $eventT->getLocation())): ?>
								| <?php $html->out($location) ?>
							<?php endif ?>
						</small>
					</h3>
				</div>
			</li>
		<?php endforeach ?>
	</ol>
</div>