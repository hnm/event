<?php
namespace event\model;

use n2n\web\dispatch\Dispatchable;
use n2n\web\dispatch\map\bind\BindingDefinition;
use n2n\impl\web\dispatch\map\val\ValNotEmpty;
use n2n\web\dispatch\map\MappingResult;
use dbtext\model\TextService;
use event\bo\EventParticipant;
use event\bo\Event;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\dispatch\annotation\AnnoDispObject;
use n2n\l10n\N2nLocale;
use formgen\bo\FormElementSet;

class EventParticipantForm implements Dispatchable {
	private static function _annos(AnnoInit $ai) {
		$ai->p('magForm', new AnnoDispObject());
	}
	
	private $formElementSet;
	private $n2nLocale;
	
	public $firstName;
	public $lastName;
	public $email;
	public $phone;
	public $magForm;
	
	public function __construct(N2nLocale $n2nLocale, FormElementSet $formElementSet = null) {
		$this->n2nLocale = $n2nLocale;
		if (null !== $formElementSet && $formElementSet->hasFormElements()) {
			$this->formElementSet = $formElementSet;
			$this->magForm = $formElementSet->createMagForm($n2nLocale);
		}
	}
		
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
	public function buildEventParticipant(Event $event, N2nLocale $n2nLocale) {
		$eventParticipant = new EventParticipant();
		
		$eventParticipant->setEmail($this->email);
		$eventParticipant->setFirstName($this->firstName);
		$eventParticipant->setLastName($this->lastName);
		$eventParticipant->setPhone($this->phone);
		$eventParticipant->setEvent($event);
		$additionalData = null;
		if (null !== $this->magForm
				&& (!empty($magWrappers = $this->magForm->getMagCollection()->getMagWrappers()))) {
			$additionalData = '';
			$newLine = "\n";
			foreach ($this->formElementSet->getFormElements() as $formElement) {
				if (!$this->magForm->containsPropertyName($formElement->getId())) continue;
				
				$additionalData .= $formElement->buildTextRepresentation($this->n2nLocale, $newLine, 0, 
						$this->magForm->getPropertyValue($formElement->getId())) . $newLine;
			}
			
		}
		$eventParticipant->setAdditionalData($additionalData);
		
		return $eventParticipant;
	}
}