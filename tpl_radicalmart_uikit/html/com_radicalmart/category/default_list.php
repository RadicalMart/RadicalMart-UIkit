<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     1.0.0
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2022 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

?>
<?php foreach ($this->items as $i => $item):
	if ($i > 0) echo '<hr class="uk-margin-remove">';
	$layout = 'components.radicalmart.products.item.list';
	if ($item->isMeta) $layout = 'components.radicalmart.metas.' . $item->type . '.item.list';
	?>
	<div class="item-<?php echo $item->id; ?>">
		<?php echo LayoutHelper::render($layout, ['product' => $item, 'mode' => $this->mode]); ?>
	</div>
<?php endforeach; ?>