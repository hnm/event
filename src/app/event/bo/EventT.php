<?php
namespace event\bo;

use n2n\reflection\ObjectAdapter;
use n2n\l10n\N2nLocale;
use rocket\impl\ei\component\prop\translation\Translatable;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\reflection\annotation\AnnoInit;
use rocket\impl\ei\component\prop\ci\model\ContentItem;
use n2n\persistence\orm\CascadeType;
use n2n\persistence\orm\annotation\AnnoOneToMany;
use n2n\persistence\orm\annotation\AnnoManyToOne;

class EventT extends ObjectAdapter implements Translatable {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->p('contentItems', new AnnoOneToMany(ContentItem::getClass(), null, CascadeType::ALL, null, true));
		$ai->p('event', new AnnoManyToOne(Event::getClass()));
	}

	private $id;
	private $n2nLocale;
	private $title;
	private $pathPart;
	private $intro;
	private $time;
	private $location;
	private $contentItems;
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
	 * @return N2nLocale
	 */
	public function getN2nLocale() {
		return $this->n2nLocale;
	}

	/**
	 * @param N2nLocale $n2nLocale
	 */
	public function setN2nLocale(N2nLocale $n2nLocale) {
		$this->n2nLocale = $n2nLocale;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title = null) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getPathPart() {
		return $this->pathPart;
	}

	/**
	 * @param string $pathPart
	 */
	public function setPathPart(string $pathPart = null) {
		$this->pathPart = $pathPart;
	}

	/**
	 * @return string
	 */
	public function getIntro() {
		return $this->intro;
	}

	/**
	 * @param string $intro
	 */
	public function setIntro(string $intro = null) {
		$this->intro = $intro;
	}

	/**
	 * @return string
	 */
	public function getTime() {
		return $this->time;
	}

	/**
	 * @param string $time
	 */
	public function setTime(string $time = null) {
		$this->time = $time;
	}

	/**
	 * @return string
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * @param string $location
	 */
	public function setLocation(string $location = null) {
		$this->location = $location;
	}

	/**
	 * @return ContentItem []
	 */
	public function getContentItems() {
		return $this->contentItems;
	}

	public function setContentItems($contentItems) {
		$this->contentItems = $contentItems;
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
	public function setEvent(Event $event = null) {
		$this->event = $event;
	}
}