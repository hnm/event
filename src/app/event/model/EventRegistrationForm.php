<?php
namespace event\model;

use n2n\web\dispatch\Dispatchable;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\dispatch\annotation\AnnoDispObjectArray;
use event\bo\Event;
use n2n\web\dispatch\map\bind\BindingDefinition;
use n2n\impl\web\dispatch\map\val\ValArraySize;
use n2n\util\ex\IllegalStateException;
use n2n\web\http\HttpContext;

class EventRegistrationForm implements Dispatchable {
	private static function _annos(AnnoInit $ai) {
		$ai->p('eventParticipantForms', new AnnoDispObjectArray(function() {
			return new EventParticipantForm();
		}));
	}
	
	const MAX_NEW_PARTICIPANTS = 10;
	private $event;
	
	public $eventParticipantForms;
	
	public function __construct(Event $event) {
		IllegalStateException::assertTrue($event->isRegistrationAvailable());
		
		$this->event = $event;
	}
	
	private function _validation(BindingDefinition $bd) {
		$bd->val('eventParticipantForms', new ValArraySize(1, null, 
				$this->event->determineMaxNewParticipants(self::MAX_NEW_PARTICIPANTS)));
	}
	
	public function register(EventDao $eventDao, HttpContext $httpContext, EventMailModel $eventMailModel) {
		$eventParticipants = [];
		foreach ($this->eventParticipantForms as $eventParticipantForm) {
			$eventParticipant = $eventParticipantForm->buildEventParticipant($this->event);
			$eventParticipants[] = $eventParticipant;
			$this->event->addEventParticipant($eventParticipant);
		}
		
		$eventDao->persistEvent($this->event);
		$eventMailModel->sendEventRegistrationmail($this->event->t($httpContext->getN2nLocale()), $eventParticipants);
	}
	
	public function getMaxNumParticipants() {
		return $this->event->determineMaxNewParticipants(self::MAX_NEW_PARTICIPANTS);
	}
	
	public function getEvent() {
		return $this->event;
	}
}