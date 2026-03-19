<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.10
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Utilities\ArrayHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Category\HtmlView $this */

// Load assets
$assets = $this->getDocument()->getWebAssetManager();
if ($this->mode === 'shop')
{
	$assets->useScript('com_radicalmart.site.cart');
	if ($this->params->get('radicalmart_js', 1))
	{
		$assets->useScript('com_radicalmart.site');
	}
}
if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

$groups = [];
if (!empty($this->items))
{
	foreach ($this->items as $product)
	{
		if (empty($product->category) || empty($product->category->id))
		{
			continue;
		}

		if (!isset($groups[$product->category->id]))
		{
			$group           = new \stdClass();
			$group->id       = $product->category->id;
			$group->current  = ((int) $product->category->id === (int) $this->category->id);
			$group->title    = $product->category->title;
			$group->link     = $product->category->link;
			$group->products = [];
			$group->ordering = ($group->current) ? 0 : $product->category->lft;

			$groups[$product->category->id] = $group;
		}

		$groups[$product->category->id]->products[] = $product;
	}

	$groups = ArrayHelper::sortObjects($groups, 'ordering');
}
?>
<div id="RadicalMart" class="category-table">
	<h1 class="uk-h2 uk-margin uk-margin-remove-top" radicalmart-ajax="title">
		<?php echo $this->params->get('seo_category_h1', $this->category->title); ?>
	</h1>
	<?php if (!empty($this->modules['radicalmart-category-before-introtext'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-category-before-introtext'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($this->category->introtext)): ?>
		<div class="info">
			<?php echo $this->category->introtext; ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($this->modules['radicalmart-category-after-introtext'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-category-after-introtext'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div>
		<?php if (!empty($this->modules['radicalmart-category-before-products'])): ?>
			<div class="uk-margin">
				<?php foreach ($this->modules['radicalmart-category-before-products'] as $module): ?>
					<div class="uk-margin">
						<?php if ($module->showtitle): ?>
							<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
						<?php endif; ?>
						<div><?php echo $module->render; ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if (empty($groups)) : ?>
			<div class="uk-alert uk-alert-warning">
				<?php echo Text::_('COM_RADICALMART_ERROR_PRODUCTS_NOT_FOUND'); ?>
			</div>
		<?php else: ?>
			<?php foreach ($groups as $group): ?>
				<div class="products-list uk-card uk-card-default uk-margin">
					<?php if (!$group->current): ?>
						<div class="uk-card-header">
							<h2 class="uk-h4">
								<a href="<?php echo $group->link; ?>">
									<?php echo $group->title; ?>
								</a>
							</h2>
						</div>
					<?php endif; ?>
					<table class="uk-table uk-table-divider uk-table-small uk-table-striped uk-table-responsive uk-card-default uk-padding-remove-vertical uk-margin-remove">
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
						<?php foreach ($group->products as $product)
						{
							$layout = ($product->isMeta) ? 'components.radicalmart.metas.' . $product->type . '.item.table'
									: 'components.radicalmart.products.item.table';

							echo LayoutHelper::render($layout, ['product' => $product, 'mode' => $this->mode]);
						}
						?>
						</tbody>
					</table>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if (!empty($this->modules['radicalmart-category-after-products'])): ?>
			<div class="uk-margin">
				<?php foreach ($this->modules['radicalmart-category-after-products'] as $module): ?>
					<div class="uk-margin">
						<?php if ($module->showtitle): ?>
							<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
						<?php endif; ?>
						<div><?php echo $module->render; ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php if (!empty($this->modules['radicalmart-category-before-fulltext'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-category-before-fulltext'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($this->category->fulltext)): ?>
		<div class="fulltext uk-margin-medium uk-card uk-card-default uk-card-body">
			<?php echo $this->category->fulltext; ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($this->modules['radicalmart-category-after-fulltext'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-category-after-fulltext'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>