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
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Product\HtmlView $this */

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

$hasTabs = false;
foreach ($this->product->fieldsets as $fieldset)
{
	if ($fieldset->alias === 'root')
	{
		continue;
	}

	$hasTabs = true;
	break;
}
?>
<div id="RadicalMart" class="product">
	<div class="uk-card uk-card-default uk-card-body uk-card-small">
		<div class="uk-grid-divider uk-grid-small uk-child-width-expand@m" uk-grid>
			<div class="uk-width-3-5@m">
				<?php echo $this->loadTemplate('gallery'); ?>
				<?php if (!empty($this->product->badges)): ?>
					<hr>
					<div class="uk-margin">
						<ul class="uk-thumbnav">
							<?php foreach ($this->product->badges as $badge): ?>
								<li>
									<a href="<?php echo $badge->link; ?>" uk-tooltip
									   title="<?php echo Text::sprintf('COM_RADICALMART_PRODUCT_BADGE_LINK', $badge->title); ?>">
										<?php if ($src = $badge->media->get('icon'))
										{
											echo MediaHelper::renderImage(
													'com_radicalmart.categories.badge',
													$src,
													[
															'alt'     => $badge->title,
															'loading' => 'lazy',
													],
													[
															'category_id' => $badge->id,
															'no_image'    => false,
															'thumb'       => true,
													]);
										}
										else
										{
											echo '<span class="uk-label">' . $badge->title . '</span>';
										} ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
			<div>
				<h1 class="uk-h2 uk-margin">
					<?php echo $this->params->get('seo_product_h1', $this->product->title); ?>
				</h1>
				<?php echo $this->product->event->afterDisplayTitle; ?>
				<?php echo $this->loadTemplate('info'); ?>
				<?php echo $this->loadTemplate('variability'); ?>
				<?php echo $this->loadTemplate('buy'); ?>
			</div>
		</div>
	</div>

	<?php if (!empty($this->modules['radicalmart-product-before-content'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-product-before-content'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php echo $this->product->event->beforeDisplayContent; ?>

	<div id="ProductDescription" class="uk-margin">
		<?php if ($hasTabs):
			$overview = $this->loadTemplate('overview'); ?>
			<ul class="uk-subnav uk-subnav-pill js-product-switcher uk-flex-inline"
				uk-switcher="connect: .js-tabs">
				<?php if (!empty($overview)): ?>
					<li>
						<a href="#ProductDescription" class="uk-active">
							<?php echo Text::_('COM_RADICALMART_OVERVIEW'); ?>
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($this->product->fieldsets)): ?>
					<?php foreach ($this->product->fieldsets as $fieldset):
						if ($fieldset->alias === 'root')
						{
							continue;
						} ?>
						<li>
							<a href="#fields_<?php echo $fieldset->alias; ?>">
								<?php echo $fieldset->title; ?>
							</a>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
			<div class="uk-card uk-card-default uk-card-body uk-card-small">
				<div class="uk-switcher js-product-switcher js-tabs">
					<?php if (!empty($overview)): ?>
						<div><?php echo $overview; ?></div>
					<?php endif; ?>
					<?php if (!empty($this->product->fieldsets)): ?>
						<?php foreach ($this->product->fieldsets as $fieldset):
							if ($fieldset->alias === 'root')
							{
								continue;
							} ?>
							<div>
								<?php foreach ($fieldset->fields as $field):
									if (empty($field->value))
									{
										continue;
									} ?>
									<div class="uk-form-horizontal uk-margin-remove uk-clearfix">
										<div class="uk-form-label"><?php echo $field->title; ?></div>
										<div class="uk-form-controls uk-form-controls-text">
											<?php echo $field->value; ?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		<?php else: ?>
			<div><?php echo $this->loadTemplate('overview'); ?></div>
		<?php endif; ?>
	</div>

	<?php if (!empty($this->modules['radicalmart-product-after-content'])): ?>
		<div class="uk-margin">
			<?php foreach ($this->modules['radicalmart-product-after-content'] as $module): ?>
				<div class="uk-margin">
					<?php if ($module->showtitle): ?>
						<div class="uk-h3"><?php echo Text::_($module->title); ?></div>
					<?php endif; ?>
					<div><?php echo $module->render; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php echo $this->product->event->afterDisplayContent; ?>
</div>