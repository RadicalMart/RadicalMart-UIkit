<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.11
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\RadicalMart\Site\View\Category\HtmlView $this */

$options = [
		'ordering ASC'         => 'COM_RADICALMART_CATEGORY_ITEMS_ORDERING_ORDERING',
		'ordering_title ASC'   => 'COM_RADICALMART_CATEGORY_ITEMS_ORDERING_TITLE_ASC',
		'ordering_title DESC'  => 'COM_RADICALMART_CATEGORY_ITEMS_ORDERING_TITLE_DESC',
		'ordering_price ASC'   => 'COM_RADICALMART_CATEGORY_ITEMS_ORDERING_PRICE_ASC',
		'ordering_price DESC'  => 'COM_RADICALMART_CATEGORY_ITEMS_ORDERING_PRICE_DESC',
		'ordering_rating ASC'  => 'COM_RADICALMART_CATEGORY_ITEMS_ORDERING_RATING_ASC',
		'ordering_rating DESC' => 'COM_RADICALMART_CATEGORY_ITEMS_ORDERING_RATING_DESC',
		'ordering_date ASC'    => 'COM_RADICALMART_CATEGORY_ITEMS_ORDERING_DATE_ASC',
		'ordering_date DESC'   => 'COM_RADICALMART_CATEGORY_ITEMS_ORDERING_DATE_DESC',
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