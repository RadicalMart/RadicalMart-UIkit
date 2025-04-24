<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2025 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
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

$showAddition = ((!$this->pagination || (int) $this->pagination->pagesCurrent === 1) && empty($this->activeFilters));
$filter       = (!empty($this->children));

?>
<div id="RadicalMart" class="category">
	<h1 class="uk-h2 uk-margin uk-margin-remove-top uk-text-center" radicalmart-ajax="title">
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
		<div class="info uk-text-center">
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
	<?php if (!empty($this->children)): ?>
		<div class="children uk-text-center">
			<?php foreach ($this->children as $child): ?>
				<a href="<?php echo $child->link; ?>"
				   class="uk-button uk-button-small uk-button-default uk-margin-small-right uk-margin-small-bottom">
					<?php echo $child->title; ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="uk-child-width-expand@m uk-grid-small uk-margin" uk-grid="">
		<?php if (!empty($this->modules['radicalmart-filter'])): ?>
			<div class="uk-width-1-4@m uk-visible@m">
				<?php foreach ($this->modules['radicalmart-filter'] as $module): ?>
					<div class="uk-card uk-card-default  uk-margin">
						<?php if ($module->showtitle): ?>
							<div class="uk-card-header"><?php echo Text::_($module->title); ?></div>
						<?php endif; ?>
						<div class="uk-card-body uk-card-small">
							<?php echo $module->render; ?>
						</div>
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
			<div radicalmart-ajax="loading"
				 class="uk-position-fixed uk-position-cover uk-position-z-index uk-overlay-default uk-flex uk-flex-middle uk-flex-center"
				 style="display: none">
				<div uk-spinner="ratio: 3"></div>
			</div>
			<div class="uk-card uk-card-default">
				<div class="uk-card-header">
					<div class="uk-grid-small uk-flex-middle" uk-grid>
						<div class="uk-width-expand@s uk-flex uk-flex-center uk-flex-left@s uk-text-small">
							<?php echo $this->loadTemplate('ordering'); ?>
						</div>
						<div class="uk-width-auto@s uk-flex uk-flex-center uk-flex-middle">
							<?php if (!empty($this->modules['radicalmart-filter-mobile'])): ?>
								<span class="uk-button uk-button-default uk-button-small uk-hidden@m"
									  uk-toggle="target: #productsFilters">
									<span class="uk-margin-xsmall-right" uk-icon="icon: settings; ratio: .75;"></span>
									<?php echo Text::_('COM_RADICALMART_FILTERS'); ?>
								</span>
							<?php endif; ?>
							<ul class="uk-subnav uk-iconnav uk-margin-small-left uk-visible@s">
								<li class="<?php echo ($this->productsListTemplate === 'grid') ? 'uk-active' : ''; ?>">
									<span class="uk-link"
										  uk-icon="grid" uk-tooltip onclick="setProductsListTemplate('grid')"
										  title="<?php echo Text::_('COM_RADICALMART_PRODUCTS_LIST_LAYOUT_GRID'); ?>"></span>
								</li>
								<li class="<?php echo ($this->productsListTemplate === 'list') ? 'uk-active' : ''; ?>">
									<span class="uk-link"
										  uk-icon="list" uk-tooltip onclick="setProductsListTemplate('list')"
										  title="<?php echo Text::_('COM_RADICALMART_PRODUCTS_LIST_LAYOUT_LIST'); ?>"></span>
								</li>
								<li class="<?php echo ($this->productsListTemplate === 'table') ? 'uk-active' : ''; ?>">
									<span class="uk-link"
										  uk-icon="table" uk-tooltip onclick="setProductsListTemplate('table')"
										  title="<?php echo Text::_('COM_RADICALMART_PRODUCTS_LIST_LAYOUT_TABLE'); ?>"></span>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div radicalmart-ajax="products">
					<?php if (empty($this->items)) : ?>
						<div class="uk-card-body">
							<div class="uk-alert uk-alert-warning">
								<?php echo Text::_('COM_RADICALMART_ERROR_PRODUCTS_NOT_FOUND'); ?>
							</div>
						</div>
					<?php else: ?>
						<div class="products-list">
							<?php echo $this->loadTemplate($this->productsListTemplate); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
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
			<div class="uk-margin">
				<div radicalmart-ajax="pagination">
					<?php if ($this->items && $this->pagination): ?>
						<div class="list-pagination uk-margin-medium">
							<?php echo $this->pagination->getPaginationLinks(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div radicalmart-ajax="more">
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
		<?php if ($showAddition && !empty($this->category->fulltext)): ?>
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
	<div radicalmart-ajax="offcanvas">
		<?php if (!empty($this->modules['radicalmart-filter-mobile'])): ?>
			<div id="productsFilters" uk-offcanvas="overlay: true">
				<div class="uk-offcanvas-bar">
					<span class="uk-offcanvas-close" type="button" uk-close></span>
					<?php foreach ($this->modules['radicalmart-filter-mobile'] as $module): ?>
						<div class="uk-margin">
							<?php if ($module->showtitle): ?>
								<div class="uk-h4"><?php echo Text::_($module->title); ?></div>
							<?php endif; ?>
							<div><?php echo $module->render; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>