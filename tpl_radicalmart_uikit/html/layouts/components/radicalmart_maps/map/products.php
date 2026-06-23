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

use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
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
?>

<div radicalmart_maps-map="products" class="uk-position-relative uk-height-1-1 uk-padding-small uk-padding-remove-vertical">
	<div radicalmart_maps-map="products_loading"
	     class="uk-position-cover uk-position-z-index uk-flex uk-flex-center uk-flex-middle	uk-overlay-default"
	     style="z-index: 1098; display: none">
		<div uk-spinner="ratio: 3"></div>
	</div>
	<div radicalmart_maps-map="products_no_items" style="display: none">
		<div class="uk-alert uk-alert-warning">
			<?php echo Text::_('COM_RADICALMART_ERROR_PRODUCTS_NOT_FOUND'); ?>
		</div>
	</div>
	<div radicalmart_maps-map="products_list" style="display: none"></div>
</div>
