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

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Product\HtmlView $this */

if (empty($this->gallery) && empty($this->product->badges))
{
	return;
}

?>
<div class="uk-width-1-2@m">
	<div class="uk-position-relative">
		<?php echo $this->loadTemplate('gallery');
		echo LayoutHelper::render('components.radicalmart.items.badges', ['product' => $this->product]);
		?>
	</div>
	<hr>
	<?php if (!empty($this->product->manufacturers)): ?>
		<ul class="uk-thumbnav">
			<?php foreach ($this->product->manufacturers as $manufacturer): ?>
				<li>
					<a href="<?php echo $manufacturer->link; ?>" uk-tooltip
					   title="<?php echo Text::sprintf('COM_RADICALMART_PRODUCT_MANUFACTURER_LINK', $manufacturer->title); ?>">
						<?php if ($src = $manufacturer->media->get('icon')): ?>
							<div class="uk-display-block" style="height: 48px;">
								<?php echo MediaHelper::renderImage(
										'com_radicalmart.categories.manufacturer', $src,
										[
												'alt'     => $manufacturer->title,
												'loading' => 'lazy',
												'style'   => 'max-width: 100%; max-height:100%;',
										],
										[
												'category_id' => $manufacturer->id,
												'no_image'    => false,
												'thumb'       => true,
										]);
								?>
							</div>
						<?php else: ?>
							<span class="uk-label uk-background-secondary"><?php echo $manufacturer->title; ?></span>
						<?php endif; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
