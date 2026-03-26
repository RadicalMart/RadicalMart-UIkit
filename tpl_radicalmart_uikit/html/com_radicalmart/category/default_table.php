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

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

?>
<div class="uk-padding-remove-vertical">
	<table class="uk-table uk-table-divider uk-table-small uk-table-striped uk-card-default">
		<thead>
		<tr>
			<th class="uk-text-center">
				<?php echo Text::_('COM_RADICALMART_PRODUCT'); ?>
			</th>
			<th>
				<?php echo Text::_('COM_RADICALMART_CATEGORY'); ?>
			</th>
			<th colspan="2">
				<?php echo Text::_('COM_RADICALMART_PRICE'); ?>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($this->items as $item)
		{
			$layout = ($item->isMeta) ? 'components.radicalmart.metas.' . $item->type . '.item.table'
					: 'components.radicalmart.products.item.table';

			echo LayoutHelper::render($layout, ['product' => $item, 'mode' => $this->mode]);
		} ?>
		</tbody>
	</table>
</div>