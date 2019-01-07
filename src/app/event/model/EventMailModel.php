<?php
namespace event\model;

use n2n\context\RequestScoped;
use event\bo\EventParticipant;
use dbtext\model\TextService;
use n2n\util\type\ArgUtils;
use n2n\mail\MailUtils;
use event\bo\EventT;
use n2n\l10n\N2nLocale;

class EventMailModel implements RequestScoped {
	const SEPARATOR = "-----------------------------------------------------\n";
	const NEW_LINE = "\n";
	
	private $tc;
	private $n2nLocale;
	
	private function _init(TextService $ts, N2nLocale $n2nLocale) {
		$this->tc = $ts->tc('event', $n2nLocale);
		$this->n2nLocale = $n2nLocale;
	}
	
	public function sendEventRegistrationmail(EventT $eventT, array $eventParticipants) {
		ArgUtils::valArray($eventParticipants, EventParticipant::class);
		
		$mailText = '';
		foreach ($eventParticipants as $index => $eventParticipant) {
			$mailText .= $this->buildEventParticipantMailPart($eventParticipant, $index + 1);
		}
		
		MailUtils::sendNotificationMail($this->tc->t('registration_title_txt', ['title' => $eventT->getTitle()], $this->n2nLocale), 
				$mailText);
	}
	
	private function buildEventParticipantMailPart(EventParticipant $eventParticipant, int $num) {
		return self::SEPARATOR . $num . '. ' . $this->tc->t('event_participant_txt', null, $this->n2nLocale) . self::NEW_LINE . self::SEPARATOR
				. $this->tc->t('first_name_txt', null, $this->n2nLocale) . ': ' . $eventParticipant->getFirstName() . self::NEW_LINE
				. $this->tc->t('last_name_txt', null, $this->n2nLocale) . ': ' . $eventParticipant->getLastName() . self::NEW_LINE
				. $this->tc->t('email_txt', null, $this->n2nLocale) . ': ' . $eventParticipant->getEmail() . self::NEW_LINE
				. $this->tc->t('phone_txt', null, $this->n2nLocale) . ': ' . $eventParticipant->getPhone() . self::NEW_LINE . self::NEW_LINE;
	}
}