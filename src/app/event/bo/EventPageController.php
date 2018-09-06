<?php
namespace event\bo;

use page\bo\PageController;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\reflection\annotation\AnnoInit;
use event\controller\EventController;
use page\annotation\AnnoPage;
use page\annotation\AnnoPageCiPanels;

class EventPageController extends PageController {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoEntityListeners(ResponseCacheClearer::getClass()));
		$ai->m('events', new AnnoPage(), new AnnoPageCiPanels('top', 'main', 'aside'));
	}

	public function events(EventController $eventController, array $r = null) {
		$this->delegate($eventController);
	}
}