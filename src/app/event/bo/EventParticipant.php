<?php
namespace event\bo;

use n2n\reflection\ObjectAdapter;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\reflection\annotation\AnnoInit;
use event\bo\Event;
use n2n\persistence\orm\annotation\AnnoManyToOne;

class EventParticipant extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->p('event', new AnnoManyToOne(Event::getClass()));
	}

	private $id;
	private $firstName;
	private $lastName;
	private $phone;
	private $email;
	private $event;

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
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 */
	public function setFirstName(string $firstName = null) {
		$this->firstName = $firstName;
	}

	/**
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 */
	public function setLastName(string $lastName = null) {
		$this->lastName = $lastName;
	}

	/**
	 * @return string
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @param string $phone
	 */
	public function setPhone(string $phone = null) {
		$this->phone = $phone;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email = null) {
		$this->email = $email;
	}

	/**
	 * @return Event
	 */
	public function getEvent() {
		return $this->event;
	}

	/**
	 * @param Event $event
	 */
	public function setEvent(Event $event) {
		$this->event = $event;
	}
}