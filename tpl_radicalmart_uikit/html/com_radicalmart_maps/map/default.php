<?php
/*
 * @package     RadicalMart Maps Package
 * @subpackage  com_radicalmart_maps
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\RadicalMartMaps\Site\View\Map\HtmlView $this */

$params_key = 'com_radicalmart_maps.map.view_' . $this->category->id;
$provider   = $this->params->get('maps_map_provider', 'ymaps3');

?>
<div id="RadicalMartMaps" class="map">
	<?php echo LayoutHelper::render('components.radicalmart_maps.map.container', [
			'provider'     => $provider,
			'jsOptionsKey' => $params_key,
			'category'     => $this->category,
			'params'       => $this->params,
			'filter'       => $this->filterForm
	]); ?>
</div>
<style>
	html:has(#RadicalMartMaps.map),
	body:has(#RadicalMartMaps.map) {
		height: 100%;
	}

	body:has(#RadicalMartMaps.map) {
		margin: 0;
		padding: 0;
		overflow: hidden;
	}

	body:has(#RadicalMartMaps.map) > .tm-page {
		display: grid;
		grid-template-rows: auto minmax(0, 1fr);
		height: 100%;
		min-height: 0;
	}

	main#tm-main.uk-section:has(#RadicalMartMaps.map) {
		height: 100%;
		min-height: 0 !important;
		width: 100%;
		padding: 0 !important;
		overflow: hidden;
	}

	main#tm-main.uk-section:has(#RadicalMartMaps.map) > .uk-container {
		display: grid;
		grid-template-rows: auto auto minmax(0, 1fr);

		height: 100%;
		min-height: 0;

		width: 100%;
		max-width: none;
		padding: 0;

		overflow: hidden;
		box-sizing: border-box;
	}

	main#tm-main.uk-section:has(#RadicalMartMaps.map) > .uk-container > .uk-margin-medium-bottom {
		margin-bottom: 0 !important;
	}
</style>
