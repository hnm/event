<?php
namespace event\bo;

use n2n\impl\web\ui\view\html\HtmlView;
use rocket\impl\ei\component\prop\ci\model\ContentItem;
use n2n\web\http\orm\ResponseCacheClearer;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\persistence\orm\annotation\AnnoEntityListeners;
use n2n\reflection\annotation\AnnoInit;

class CiEvent extends ContentItem {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('event_ci_event'), new AnnoEntityListeners(ResponseCacheClearer::getClass()));
	}

	const SIZE_TYPE_SMALL = 3;
	const SIZE_TYPE_BIG = 6;
	
	private $sizeType;

	public function createUiComponent(HtmlView $view) {
		return $view->getImport('\event\view\inc\ciEvent.html', array('ciEvent' => $this));	
	}

	/**
	 * @return int
	 */
	public function getSizeType() {
		return $this->sizeType;
	}

	/**
	 * @param int $sizeType
	 */
	public function setSizeType(int $sizeType = null) {
		$this->sizeType = $sizeType;
	}
}