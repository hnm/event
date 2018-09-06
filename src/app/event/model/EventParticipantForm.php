<?php
namespace event\model;

use n2n\web\dispatch\Dispatchable;
use n2n\web\dispatch\map\bind\BindingDefinition;
use n2n\impl\web\dispatch\map\val\ValNotEmpty;
use n2n\web\dispatch\map\MappingResult;
use dbtext\model\TextService;
use event\bo\EventParticipant;
use event\bo\Event;

class EventParticipantForm implements Dispatchable {
	
	public $firstName;
	public $lastName;
	public $email;
	public $phone;
	
	private function _mapping(MappingResult $mr, TextService $ts) {
		$mr->setLabels(['firstName' => $ts->t('event', 'first_name_txt'), 
				'lastName' => $ts->t('event', 'last_name_txt'),
				'email' => $ts->t('event', 'email_txt'),
				'phone' => $ts->t('event', 'phone_txt')
		]);
	}
	
	private function _validation(BindingDefinition $bd) {
		$bd->val(array('firstName', 'lastName', 'email'), new ValNotEmpty());
	}
	
	/**
	 * @return \event\bo\EventParticipant
	 */
	public function buildEventParticipant(Event $event) {
		$eventParticipant = new EventParticipant();
		
		$eventParticipant->setEmail($this->email);
		$eventParticipant->setFirstName($this->firstName);
		$eventParticipant->setLastName($this->lastName);
		$eventParticipant->setPhone($this->phone);
		$eventParticipant->setEvent($event);
		
		return $eventParticipant;
	}
}