<?php
	use n2n\impl\web\ui\view\html\HtmlView;
	use event\model\EventRegistrationForm;
	use n2nutil\bootstrap\ui\BsFormHtmlBuilder;
	use n2nutil\bootstrap\ui\Bs;
	use dbtext\DbtextHtmlBuilder;
	use event\model\EventParticipantForm;
	
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);
	$formHtml = HtmlView::formHtml($view);
	
	$eventRegistrationForm = $view->getParam('eventRegistrationForm');
	$view->assert($eventRegistrationForm instanceof EventRegistrationForm);
	
	$event = $eventRegistrationForm->getEvent();
	$eventT = $event->t($view->getN2nLocale());
	
	$dbtextHtml = new DbtextHtmlBuilder($view);
	$bsComposer = Bs::req()->row('col-sm-3', 'col-sm-9', 'offset-sm-3');
	$bsFormHtml = new BsFormHtmlBuilder($view, $bsComposer);
	
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
			<?php $formHtml->meta()->arrayProps('eventParticipantForms', function() use ($html, $bsFormHtml, $formHtml, $dbtextHtml, 
					$view, $eventRegistrationForm, $bsComposer) { ?>
				<?php $eventParticipantForm = $formHtml->meta()->getMapValue()->getObject() ?>
				<?php $view->assert($eventParticipantForm instanceof EventParticipantForm) ?>
				<fieldset class="event-participant-form">
					<legend>
						<span class="d-flex">
							<span>
								<span class="event-participant-num">
									<?php $html->out($formHtml->meta()->getResolvedArrayKey() + 1) ?>
								</span>. <?php $dbtextHtml->t('event_participant_txt')?>
							</span>
							<a href="#" class="ml-auto event-participant-remove">
								x
							</a>
						</span>
					</legend>
					<?php $formHtml->optionalObjectCheckbox(null, ['class' => 'event-registration-optional']) ?>
					<?php $bsFormHtml->inputGroup('firstName') ?>
					<?php $bsFormHtml->inputGroup('lastName') ?>
					<?php $bsFormHtml->inputGroup('email') ?>
					<?php $bsFormHtml->inputGroup('phone', Bs::req(false)) ?>
					<?php if (null !== $eventParticipantForm->magForm): ?>
						<?php $view->import('\formgen\view\inc\formElements.html', ['formElements' => $eventRegistrationForm->getEvent()->getFormElementSet()->getFormElements(), 
								'propPath' => $formHtml->meta()->propPath('magForm'), 'bsComposer' => $bsComposer]) ?>
					<?php endif ?>
				</fieldset>
			<?php }, $eventRegistrationForm->getMaxNumParticipants(), $eventRegistrationForm->getMaxNumParticipants()) ?>
		</div>
		<div class="row">
			<div class="offset-sm-3 col-sm-9">
				<a href="#" class="event-participant-add btn btn-secondary">
					<?php $dbtextHtml->t('add_participant_txt')?>
				</a>
			</div>
		</div>
		<?php $bsFormHtml->buttonSubmitGroup('register', $dbtextHtml->getT('register_txt'))?>
	<?php $bsFormHtml->close() ?>
<?php endif ?>