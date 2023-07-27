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

use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Administrator\Helper\ParamsHelper;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;
use Joomla\Utilities\ArrayHelper;

// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
if ($this->mode === 'shop')
{
	$assets->useScript('com_radicalmart.site.cart');
	if ($this->params->get('radicalmart_js', 1))
	{
		$assets->useScript('com_radicalmart.site')
			->useScript('bootstrap.toast')
			->useScript('bootstrap.offcanvas');
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
							<h2 class="h3">
								<a href="<?php echo $group->link; ?>">
									<?php echo $group->title; ?>
								</a>
							</h2>
						</div>
					<?php endif; ?>
					<table class="uk-table uk-table-divider uk-table-responsive">
						<?php foreach ($group->products as $product):
							$hidePrice = (ParamsHelper::getComponentParams()->get('hide_prices', 0)
								|| !empty($product->price['hide'])
								|| empty($product->in_stock));
							?>
							<tr>
								<td>
									<div>
										<a href="<?php echo $product->link; ?>">
											<?php echo $product->title; ?>
										</a>
									</div>
									<?php if (!empty($product->introtext)): ?>
										<div class="uk-text-small uk-text-muted">
											<?php echo $product->introtext; ?>
										</div>
									<?php endif; ?>
								</td>
								<td style="width: 10%">
									<?php if (!$hidePrice): ?>
										<?php if ($product->price['discount_enable']): ?>
											<div class="uk-text-small uk-text-muted">
												<s><?php echo $product->price['base_string']; ?></s>
											</div>
										<?php endif; ?>
										<div>
											<strong><?php echo $product->price['final_string']; ?></strong>
										</div>
									<?php elseif (empty($product->in_stock)): ?>
										<span class="uk-text-danger">
											<?php echo Text::_('COM_RADICALMART_NOT_IN_STOCK'); ?>
										</span>
									<?php endif; ?>
								</td>
								<td style="width: 1%" class="uk-text-nowrap">
									<?php if (!$hidePrice && $this->mode === 'shop' && (int) $product->state === 1): ?>
										<div radicalmart-cart="product" data-id="<?php echo $product->id; ?>">
											<input radicalmart-cart="quantity" type="hidden" name="quantity"
												   class="uk-input uk-form-width-small uk-text-center"
												   step="<?php echo $product->quantity['step']; ?>"
												   min="<?php echo $product->quantity['min']; ?>"
												<?php if (!empty($product->quantity['max']))
												{
													echo 'max="' . $product->quantity['max'] . '"';
												}
												?>
												   value="<?php echo $product->quantity['min']; ?>"/>
											<button radicalmart-cart="add" type="button"
													class="uk-button uk-button-primary">
												<?php echo Text::_('COM_RADICALMART_CART_ADD'); ?>
											</button>
										</div>
									<?php elseif ($hidePrice || $this->mode === 'catalog'): ?>
										<a href="<?php echo $product->link; ?>"
										   class="uk-button uk-button-primary">
											<?php echo Text::_('COM_RADICALMART_READMORE'); ?>
										</a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
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
		<div class="fulltext uk-margin-medium">
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