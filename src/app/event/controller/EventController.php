<?php
namespace event\controller;

use n2n\web\http\controller\ControllerAdapter;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\http\annotation\AnnoPath;
use event\model\EventDao;
use n2n\web\http\PageNotFoundException;
use event\model\EventRegistrationForm;

class EventController extends ControllerAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->m('detail', new AnnoPath('/eventTPathPart:*'));
	}
	
	private $eventDao;
	
	private function _init(EventDao $eventDao) {
		$this->eventDao = $eventDao;
	}
	
	public function index() {
		$this->forward('..\view\eventOverview.html', array('events' => $this->eventDao->getEvents()));
	}
	
	public function detail($eventTPathPart) {
		$eventT = $this->eventDao->getEventTByPathPart($eventTPathPart);
		if (null === $eventT) {
			throw new PageNotFoundException('Invalid event t path part: ' . $eventTPathPart);
		}
		
		$this->forward('..\view\eventDetail.html', ['eventT' => $eventT]);
	}
	
	public function doRegister($eventTPathPart) {
		$this->beginTransaction();
		$eventT = $this->eventDao->getEventTByPathPart($eventTPathPart);
		if (null === $eventT || !$eventT->getEvent()->isRegistrationAvailable()) {
			$this->commit();
			throw new PageNotFoundException('Invalid event t path part: ' . $eventTPathPart);
		}
		
		$eventRegistrationForm = new EventRegistrationForm($eventT->getEvent());
		if ($this->dispatch($eventRegistrationForm, 'register')) {
			$this->commit();
			$this->redirectToController('registrationthanks');
			return;
		}
		
		$this->commit();
		
		$this->forward('..\view\eventRegistrationForm.html', ['eventRegistrationForm' => $eventRegistrationForm]);
	}
	
	public function doRegistrationThanks() {
		$this->forward('..\view\eventRegistrationThanks.html');
	}
}