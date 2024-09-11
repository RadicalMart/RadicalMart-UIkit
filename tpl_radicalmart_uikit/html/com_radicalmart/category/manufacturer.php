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

use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

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

$showAddition = ((!$this->pagination || (int) $this->pagination->pagesCurrent === 1));
?>
<div id="RadicalMart" class="category-manufacturer">
	<div class="uk-child-width-expand@m uk-grid-small uk-margin" uk-grid="">
		<div>
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
		</div>
		<div class="uk-width-1-4@m uk-visible@m">
			<?php echo MediaHelper::renderImage(
				'com_radicalmart.category.manufacturer',
				$this->category->media->get('image', $this->category->media->get('icon')),
				[
					'alt'     => $this->category->title,
					'loading' => 'lazy',
				],
				[
					'category_id' => $this->category->id,
					'no_image'    => true,
					'thumb'       => true,
				]); ?>
		</div>
	</div>
	<div radicalmart-ajax="loading"
		 class="uk-position-fixed uk-position-cover uk-position-z-index uk-overlay-default uk-flex uk-flex-middle uk-flex-center"
		 style="display: none">
		<div uk-spinner="ratio: 3"></div>
	</div>
	<div radicalmart-ajax="products">
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
		<div class="uk-card uk-card-default">
			<?php if (empty($this->items)) : ?>
				<div class="uk-card-body">
					<div class="uk-alert uk-alert-warning">
						<?php echo Text::_('COM_RADICALMART_ERROR_PRODUCTS_NOT_FOUND'); ?>
					</div>
				</div>
			<?php else: ?>
				<div class="products-list">
					<?php echo $this->loadTemplate('grid'); ?>
				</div>
			<?php endif; ?>
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
	</div>
	<div radicalmart-ajax="pagination">
		<?php if ($this->items && $this->pagination): ?>
			<div class="list-pagination uk-margin-medium">
				<?php echo $this->pagination->getPaginationLinks(); ?>
			</div>
		<?php endif; ?>
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
</div>