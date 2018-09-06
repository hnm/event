<?php
	use n2n\impl\web\ui\view\html\HtmlView;
	use event\bo\EventT;
	use n2n\web\http\nav\Murl;
	use dbtext\DbtextHtmlBuilder;
	use rocket\impl\ei\component\prop\ci\ui\ContentItemHtmlBuilder;
	
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);
	
	$eventT = $view->getParam('eventT');
	$view->assert($eventT instanceof EventT);
	
	$html->meta()->setTitle($eventT->getTitle());
	
	if (null !== ($description = $eventT->getIntro())) {
		$html->meta()->addMeta(array('name' => 'description', 'content' => $description), 'name');
	}
	
	$event = $eventT->getEvent();
	
	$ciHtml = new ContentItemHtmlBuilder($view);
	$dbtextHtml = new DbtextHtmlBuilder($view);
	
	$view->useTemplate('\bstmpl\view\bsTemplate.html', array('title' => $eventT->getTitle()));
?>
<div class="event-kicker">
	<?php $html->out($event->getDateDisplay($view->getN2nLocale())) ?>
	<?php if (null !== $eventT && null !== ($time = $eventT->getTime())): ?>
		| <?php $html->out($time) ?>
	<?php endif ?>
	<?php if (null !== $eventT && null !== ($location = $eventT->getLocation())): ?>
		| <?php $html->out($location) ?>
	<?php endif ?>
</div>
<?php if (null !== ($intro = $eventT->getIntro())): ?>
	<p class="lead"><?php $html->out($intro) ?></p>
<?php endif ?>
			
<?php $ciHtml->contentItems($eventT->getContentItems(), 'main') ?>

<?php if ($event->isRegistrationAvailable() && ($event->determineMaxNewParticipants() > 0)): ?>
	<?php $html->link(Murl::controller()->pathExt(['register', $eventT->getPathPart()]), $dbtextHtml->getT('event_registration_link_txt'), array('class' => 'btn btn-primary')) ?>
<?php endif ?>