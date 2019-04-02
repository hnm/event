<?php
namespace event\controller;

use n2n\context\Lookupable;
use event\model\EventDao;
use n2n\core\container\TransactionManager;

class EventBatchJob implements Lookupable {
	
	private $eventDao;
	
	private function _init(EventDao $eventDao) {
		$this->eventDao = $eventDao;
	}
	
	public function _onNewDay(TransactionManager $tm) {
		$tx = $tm->createTransaction();
		$this->eventDao->removePastEvents();
		$tx->commit();
	}
}