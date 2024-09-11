<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.2.1
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
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