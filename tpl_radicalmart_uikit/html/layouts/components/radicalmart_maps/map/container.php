<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Document\Document;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\RadicalMartMaps\Site\Helper\RouteHelper;
use Joomla\Registry\Registry;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  string   $provider     Map provider.
 * @var  string   $jsOptionsKey JavaScript options key.
 * @var  object   $category     Category object.
 * @var  Registry $params       RadicalMart Current params.
 * @var  Form     $filter       Filter form.
 *
 */

if (empty($provider))
{
	return;
}

/** @var Document $document */
$document = Factory::getApplication()->getDocument();
$assets   = $document->getWebAssetManager();
$registry = $assets->getRegistry();

// Load components
$registry->addExtensionRegistryFile('com_radicalmart')
		->addExtensionRegistryFile('com_radicalmart_maps');

$assets->useStyle('com_radicalmart_maps.site.map');

// Load assets
if ($params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}
if ($params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

$document->addScriptOptions($jsOptionsKey, [
		'controller'           => Route::link('site', RouteHelper::getMapRoute($category->slug), false),
		'category_id'          => $category->id,
		'map_center_latitude'  => round((float) $params->get('maps_map_center_latitude', 55.733842), 6),
		'map_center_longitude' => round((float) $params->get('maps_map_center_longitude', 37.588144), 6),
		'map_zoom'             => (int) $params->get('maps_map_zoom', 10),
		'map_zoom_ctrl'        => ((int) $params->get('maps_map_zoom_ctrl', 1) === 1),
		'map_drag_two_fingers' => ((int) $params->get('maps_map_drag_two_fingers', 1) === 1),
		'map_drag_save'        => ((int) $params->get('maps_map_drag_save', 1) === 1),
		'load_threads'         => (int) $params->get('maps_load_threads', 5),
		'load_thread_limit'    => (int) $params->get('maps_load_thread_limit', 1000),
		'load_point_limit'     => (int) $params->get('maps_load_point_limit', 20),
]);

$hasFilter = (!empty($filter) && !empty($filter->getGroup('')));
?>
<div radicalmart_maps-map="<?php echo $provider; ?>" data-params_key="<?php echo $jsOptionsKey; ?>"
     class="radicalmart-maps-container uk-position-relative">
	<div class="radicalmart-maps-main">
		<div class="radicalmart-maps-products">
			<?php echo LayoutHelper::render('components.radicalmart_maps.map.products', $displayData); ?>
		</div>
		<div class="radicalmart-maps-map uk-position-relative">
			<div radicalmart_maps-map="error" class="uk-alert uk-alert-danger uk-position-top"
			     style="z-index: 1100; display: none"></div>
			<div radicalmart_maps-map="loading"
			     class="uk-position-cover uk-position-z-index uk-flex uk-flex-center uk-flex-middle	uk-overlay-default"
			     style="z-index: 1099; display: none">
				<div uk-spinner="ratio: 3"></div>
			</div>
			<div radicalmart_maps-map="map">
				<?php echo LayoutHelper::render('components.radicalmart_maps.map.providers.' . $provider,
						$displayData); ?>
			</div>
		</div>
		<?php if ($hasFilter): ?>
			<div class="radicalmart-maps-filter">
				<?php echo LayoutHelper::render('components.radicalmart_maps.map.filter', $displayData); ?>
			</div>
		<?php endif; ?>
	</div>
</div>