<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Category\HtmlView $this */

?>
<div uk-grid uk-height-match="target: > div > .product-block .middle">
	<?php foreach ($this->items as $item):
		$layout = 'components.radicalmart.products.item.grid';
		if ($item->isMeta)
		{
			$layout = 'components.radicalmart.metas.' . $item->type . '.item.grid';
		}
		?>
		<div class="uk-width-1-3@m uk-width-1-2@s">
			<?php echo LayoutHelper::render($layout, ['product' => $item, 'mode' => $this->mode]); ?>
		</div>
	<?php endforeach; ?>
</div>