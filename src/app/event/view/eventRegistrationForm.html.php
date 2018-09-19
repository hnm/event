<?php
	use n2n\impl\web\ui\view\html\HtmlView;
	use event\model\EventRegistrationForm;
	use n2nutil\bootstrap\ui\BsFormHtmlBuilder;
	use n2nutil\bootstrap\ui\Bs;
	use dbtext\DbtextHtmlBuilder;
	
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);
	$formHtml = HtmlView::formHtml($view);
	
	$eventRegistrationForm = $view->getParam('eventRegistrationForm');
	$view->assert($eventRegistrationForm instanceof EventRegistrationForm);
	
	$event = $eventRegistrationForm->getEvent();
	$eventT = $event->t($view->getN2nLocale());
	
	$dbtextHtml = new DbtextHtmlBuilder($view);
	$bsFormHtml = new BsFormHtmlBuilder($view, Bs::req()->row('col-sm-3', 'col-sm-9', 'offset-sm-3'));
	
	$html->meta()->addJs('js/event.js');
	
	$title = $dbtextHtml->getT('registration_title_txt', ['title' => $eventT->getTitle()]);
	$html->meta()->setTitle($title);
	
	$view->useTemplate('\bstmpl\view\bsTemplate.html', ['title' => $title]);
?>
<?php if ($eventRegistrationForm->getMaxNumParticipants() === 0): ?>
	<p>
		<?php $dbtextHtml->t('event_registration_max_participants_reached_info') ?>
	</p>
<?php else: ?>
	<?php $bsFormHtml->open($eventRegistrationForm, null, null, array('class' => 'event-form')) ?>
		<div class="event-participant-forms">
			<?php $formHtml->meta()->arrayProps('eventParticipantForms', function() use ($html, $bsFormHtml, $formHtml, $dbtextHtml) { ?>
				<fieldset class="event-participant-form">
					<legend>
						<span class="d-flex">
							<span>
								<span class="event-participant-num">
									<?php $html->out($formHtml->meta()->getResolvedArrayKey() + 1) ?>
								</span>. <?php $dbtextHtml->t('event_participant_txt')?>
							</span>
							<span class="ml-auto event-participant-remove btn btn-danger">
								<?php $dbtextHtml->t('event_participant_remove') ?>
							</span>
						</span>
					</legend>
					<?php $formHtml->optionalObjectCheckbox(null, ['class' => 'event-registration-optional']) ?>
					<?php $bsFormHtml->inputGroup('firstName') ?>
					<?php $bsFormHtml->inputGroup('lastName') ?>
					<?php $bsFormHtml->inputGroup('email') ?>
					<?php $bsFormHtml->inputGroup('phone', Bs::req(false)) ?>
				</fieldset>
			<?php }, $eventRegistrationForm->getMaxNumParticipants(), $eventRegistrationForm->getMaxNumParticipants()) ?>
		</div>
		<div class="row">
			<div class="col-sm-9 offset-sm-3">
        		<div class="event-participant-add btn btn-success float-right">
        			<?php $dbtextHtml->t('event_add_participant') ?>
        		</div>			
        		<?php $formHtml->buttonSubmit('register', $dbtextHtml->getT('register_txt'), array('class' => 'btn btn-primary'))?>
			</div>
		</div>
	<?php $bsFormHtml->close() ?>
<?php endif ?>
