<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.0.1
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

?>
<div class="uk-padding-remove-vertical">
	<table class="uk-table uk-table-divider uk-table-responsive">
		<?php foreach ($this->items as $item)
		{
			$layout = ($item->isMeta) ? 'components.radicalmart.metas.' . $item->type . '.item.table'
				: 'components.radicalmart.products.item.table';

			echo LayoutHelper::render($layout, ['product' => $item, 'mode' => $this->mode]);
		} ?>
	</table>
</div>