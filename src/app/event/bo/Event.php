<?php
namespace event\bo;

use n2n\reflection\ObjectAdapter;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\reflection\annotation\AnnoInit;
use n2n\persistence\orm\CascadeType;
use n2n\persistence\orm\annotation\AnnoOneToMany;
use n2n\l10n\N2nLocale;
use rocket\impl\ei\component\prop\translation\Translator;
use n2n\l10n\L10nUtils;
use n2n\l10n\DateTimeFormat;

class Event extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->p('eventParticipants', new AnnoOneToMany(EventParticipant::getClass(), 'event', CascadeType::ALL, null, true));
		$ai->p('eventTs', new AnnoOneToMany(EventT::getClass(), 'event', CascadeType::ALL, null, true));
	}

	private $id;
	private $dateFrom;
	private $registrationAvailable = false;
	private $dateTo;
	private $maxParticipants;
	private $eventParticipants;
	private $eventTs;

	public function __construct() {
		$this->eventParticipants = new \ArrayObject();
	}

	/**
	 * @param N2nLocale ...$n2nLocales
	 * @return EventT
	 */
	public function t(N2nLocale ...$n2nLocales) {
		return Translator::findAny($this->eventTs, ... $n2nLocales);
	}

	public function addEventParticipant(EventParticipant $eventParticipant) {
		$this->eventParticipants->append($eventParticipant);
	}

	public function determineMaxNewParticipants(int $maxNewParticipants = 1) {
		if (null === $this->maxParticipants) return $maxNewParticipants;
		
		$numParticipantsLeft = $this->maxParticipants - count($this->eventParticipants);
		if ($numParticipantsLeft < $maxNewParticipants) return $numParticipantsLeft;
		
		return $maxNewParticipants;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId(int $id = null) {
		$this->id = $id;
	}

	/**
	 * @return \DateTime
	 */
	public function getDateFrom() {
		return $this->dateFrom;
	}

	/**
	 * @param \DateTime $dateFrom
	 */
	public function setDateFrom(\DateTime $dateFrom) {
		$this->dateFrom = $dateFrom;
	}

	/**
	 * @return bool
	 */
	public function isRegistrationAvailable() {
		return (bool) $this->registrationAvailable;
	}

	/**
	 * @param bool $registrationAvailable
	 */
	public function setRegistrationAvailable(bool $registrationAvailable = null) {
		$this->registrationAvailable = (bool) $registrationAvailable;
	}

	/**
	 * @return \DateTime
	 */
	public function getDateTo() {
		return $this->dateTo;
	}

	/**
	 * @param \DateTime $dateTo
	 */
	public function setDateTo(\DateTime $dateTo = null) {
		$this->dateTo = $dateTo;
	}

	/**
	 * @return int
	 */
	public function getMaxParticipants() {
		return $this->maxParticipants;
	}

	/**
	 * @param int $maxParticipants
	 */
	public function setMaxParticipants(int $maxParticipants = null) {
		$this->maxParticipants = $maxParticipants;
	}

	/**
	 * @return EventParticipant []
	 */
	public function getEventParticipants() {
		return $this->eventParticipants;
	}

	public function setEventParticipants($eventParticipants) {
		$this->eventParticipants = $eventParticipants;
	}

	/**
	 * @return EventT []
	 */
	public function getEventTs() {
		return $this->eventTs;
	}

	public function setEventTs($eventTs) {
		$this->eventTs = $eventTs;
	}
	
	public function getDateDisplay(N2nLocale $n2nLocale) {
		$dateDisplay = L10nUtils::formatDateTime($this->dateFrom, $n2nLocale, null, DateTimeFormat::STYLE_NONE);
		if (null !== $this->dateTo) {
			$dateDisplay .= ' - ' . L10nUtils::formatDateTime($this->dateTo, $n2nLocale, null, DateTimeFormat::STYLE_NONE);
		}
			
		return $dateDisplay;
	}
}