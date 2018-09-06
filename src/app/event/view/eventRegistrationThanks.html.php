<?php
	use n2n\impl\web\ui\view\html\HtmlView;
	use dbtext\DbtextHtmlBuilder;
	
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);
	
	$dbtextHtml = new DbtextHtmlBuilder($view);
	
	$view->useTemplate('\bstmpl\view\bsTemplate.html', 
			['title' => $dbtextHtml->getT('registration_thanks_title_txt')]);
?>
<p>
	<?php $dbtextHtml->t('registration_thanks_txt') ?>
</p>