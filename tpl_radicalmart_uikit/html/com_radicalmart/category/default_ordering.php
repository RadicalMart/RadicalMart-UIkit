<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2025 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$options = [
	'p.ordering ASC' => 'COM_RADICALMART_PRODUCTS_LIST_ORDERING_ORDERING',
	'price ASC'      => 'COM_RADICALMART_PRODUCTS_LIST_ORDERING_PRICE_ASC',
	'price DESC'     => 'COM_RADICALMART_PRODUCTS_LIST_ORDERING_PRICE_DESC',
	'p.created DESC' => 'COM_RADICALMART_PRODUCTS_LIST_ORDERING_CREATED',
	'p.title ASC'    => 'COM_RADICALMART_PRODUCTS_LIST_ORDERING_TITLE',
]
?>
<select class="uk-select uk-form-width-medium" onchange="setProductsOrdering(this.value);">
	<?php foreach ($options as $value => $text): ?>
		<option value="<?php echo $value; ?>"
			<?php if (strtolower($value) === strtolower($this->productsListOrdering)) echo 'selected'; ?>>
			<?php echo Text::_($text); ?>
		</option>
	<?php endforeach; ?>
</select>