<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.15
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

/**
 * Template variables
 * -----------------
 *
 * @var  Form      $form   Filter form object.
 * @var  string    $action Form action href.
 * @var   object   $module Module object.
 * @var   Registry $params Module params.
 */

?>
<div id="mod_radicalmart_search_<?php echo $module->id; ?>" class="radicalmart-container search">
	<form action="<?php echo $action; ?>" class="uk-search uk-search-default" method="get">
		<?php $form->setFieldAttribute('keyword', 'class', 'uk-search-input');
		echo $form->getInput('keyword'); ?>
		<button class="uk-search-icon-flip" uk-search-icon
				title="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>">
		</button>
	</form>
</div>