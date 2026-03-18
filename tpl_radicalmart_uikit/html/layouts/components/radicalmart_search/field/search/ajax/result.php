<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.9
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  array|false $items Find items data array.
 *
 */

?>
<div>
	<?php if (empty($items)): ?>
		<div class="uk-text-danger">
			<?php echo Text::_('COM_RADICALMART_ERROR_PRODUCTS_NOT_FOUND'); ?>
		</div>
	<?php else: ?>
		<ul class="uk-nav uk-dropdown-nav">
			<?php foreach ($items as $item): ?>
				<li><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>