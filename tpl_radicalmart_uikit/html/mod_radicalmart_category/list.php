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

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

if (empty($items))
{
	return;
}
?>
<div class="radicalmart-category <?php echo $moduleclass_sfx; ?>">
	<div class="radicalmart-category__list">
		<?php foreach ($items as $i => $item):
			$layout = 'components.radicalmart.products.item.list';
			if ($item->isMeta)
			{
				$layout = 'components.radicalmart.metas.' . $item->type . '.item.list';
			}
			?>
			<div class="item-<?php echo $item->id; ?>">
				<?php echo LayoutHelper::render($layout, ['product' => $item, 'mode' => $mode]); ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>