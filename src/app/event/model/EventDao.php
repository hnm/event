<?php
namespace event\model;

use n2n\context\RequestScoped;
use n2n\persistence\orm\EntityManager;
use n2n\web\http\HttpContext;
use event\bo\Event;
use event\bo\EventT;

class EventDao implements RequestScoped {
	
	private $em;
	private $httpContext;
	
	private function _init(EntityManager $em, HttpContext $httpContext) {
		$this->em = $em;
		$this->httpContext = $httpContext;
	}
	
	/**
	 * @return Event []
	 */
	public function getEvents(int $num = null) {
		$today = (new \DateTime())->setTime(0, 0, 0);
		$events =  $this->em->createNqlCriteria('SELECT e FROM event\bo\Event e WHERE (e.dateFrom >= :today OR e.dateTo >= :today) 
						AND e.private = false ORDER BY e.dateFrom ASC, e.eventTs.time ASC', 
				['today' => $today])->limit($num)->toQuery()->fetchArray();
		return $events;
	}
	
	/**
	 * @param string $pathPart
	 * @return EventT
	 */
	public function getEventTByPathPart(string $pathPart) {
		return $this->em->createNqlCriteria('SELECT et FROM event\bo\EventT et 
						WHERE et.pathPart = :pathPart AND et.n2nLocale = :n2nLocale', 
				['pathPart' => $pathPart, 'n2nLocale' => $this->httpContext->getN2nLocale()])->toQuery()->fetchSingle();
	}
	
	public function persistEvent(Event $event) {
		$this->em->persist($event);
	}
	
	public function getPastEvents() {
		$today = (new \DateTime())->setTime(0, 0, 0);
		return $this->em->createNqlCriteria('SELECT e FROM event\bo\Event e WHERE e.dateFrom < :today AND (e.dateTo IS NULL OR e.dateTo < :today) ORDER BY e.dateFrom ASC',
				['today' => $today])->toQuery()->fetchArray();
	}
	
	public function removePastEvents() {
		foreach ($this->getPastEvents() as $event) {
			$this->em->remove($event);
		}
	}
}