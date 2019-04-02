<?php
/*
 * Copyright (c) 2012-2016, Hofmänner New Media.
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS FILE HEADER.
 *
 * This file is part of the n2n module ROCKET.
 *
 * ROCKET is free software: you can redistribute it and/or modify it under the terms of the
 * GNU Lesser General Public License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * ROCKET is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details: http://www.gnu.org/licenses/
 *
 * The following people participated in this project:
 *
 * Andreas von Burg...........:	Architect, Lead Developer, Concept
 * Bert Hofmänner.............: Idea, Frontend UI, Design, Marketing, Concept
 * Thomas Günther.............: Developer, Frontend UI, Rocket Capability for Hangar
 */
namespace event\rocket;

use n2n\impl\web\ui\view\html\HtmlView;
use rocket\ei\util\Eiu;
use rocket\impl\ei\component\prop\adapter\DisplayableEiPropAdapter;
use rocket\ei\component\prop\indepenent\EiPropConfigurator;
use page\model\nav\murl\MurlPage;
use event\bo\EventPageController;
use n2n\util\ex\IllegalStateException;
use event\bo\EventT;

class EventDetailLinkEiProp extends DisplayableEiPropAdapter {
	
	/**
	 * {@inheritDoc}
	 * @see \rocket\impl\ei\component\prop\adapter\DisplayableEiPropAdapter::createEiPropConfigurator()
	 * @return EiPropConfigurator
	 */
	public function createEiPropConfigurator(): EiPropConfigurator {
		$this->getDisplayConfig()->setAddModeDefaultDisplayed(false);
		$this->getDisplayConfig()->setEditModeDefaultDisplayed(false);
		return parent::createEiPropConfigurator();
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rocket\impl\ei\component\prop\adapter\gui\StatelessGuiFieldDisplayable::createUiComponent()
	 */
	public function createUiComponent(HtmlView $view, Eiu $eiu) {
		$eventT = $eiu->entry()->getEntityObj();
		IllegalStateException::assertTrue($eventT instanceof EventT);
		
		return $view->getHtmlBuilder()->getLink(MurlPage::tag(EventPageController::class)->pathExt($eventT->getPathPart()), 
				$view->getL10nText('detail_txt'), ['target' => '_blank']);
	}
}
