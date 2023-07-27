<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2023 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
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