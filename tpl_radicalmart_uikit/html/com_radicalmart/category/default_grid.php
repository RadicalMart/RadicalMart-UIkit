<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     1.2.0
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2023 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

?>
<div class="uk-padding-remove-vertical">
	<?php foreach (array_chunk($this->items, 3) as $r => $row):
		if ($r > 0) echo '<hr class="uk-visible@s uk-margin-remove">'; ?>
		<div class="uk-card-body uk-card-small uk-padding-remove-vertical">
			<div class="uk-grid-small uk-grid-divider" uk-grid
				 uk-height-match="target: > div > .product-block .middle">
				<?php foreach ($row as $i => $item):
					$layout = 'components.radicalmart.products.item.grid';
					if ($item->isMeta) $layout = 'components.radicalmart.metas.' . $item->type . '.item.grid';
					?>
					<div class="uk-width-1-3@s">
						<?php echo LayoutHelper::render($layout, ['product' => $item, 'mode' => $this->mode]); ?>
					</div>
				<?php endforeach; ?>
				<?php if (count($row) !== 3): ?>
					<div class="uk-width-expand uk-visible@s"></div>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>