<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2022 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
$assets->addInlineScript("
	document.addEventListener('DOMContentLoaded', function () {
		let productLightbox = document.querySelector('#RadicalMart.product .product-gallery .uk-slideshow-items');
		if (productLightbox) {
			UIkit.lightbox(productLightbox, {
				container: '#RadicalMart.product'
			});
		}
	});
");
?>
<div class="product-gallery uk-position-relative" uk-slideshow="animation: fade; autoplay: true; ratio: 3:2">
	<ul class="uk-slideshow-items">
		<?php if (count($this->gallery) > 0):
			foreach ($this->gallery as $media):
				$displayData = [
					'item'     => $media['item'],
					'type'     => $media['type'],
					'product'  => $this->product,
					'category' => $this->category
				] ?>
				<li>
					<?php echo LayoutHelper::render($media['type']['layout_slide'], $displayData); ?>
				</li>
			<?php endforeach; ?>
		<?php else: ?>
			<li>
				<?php echo MediaHelper::renderImage(
					'com_radicalmart.product.gallery.slide',
					$this->product->image,
					[
						'alt'      => $this->product->title,
						'loading'  => 'lazy',
						'uk-cover' => ''
					],
					[
						'product_id' => $this->product->id,
						'no_image'   => true,
						'thumb'      => true,
					]); ?>
			</li>
		<?php endif; ?>
	</ul>
	<?php if (count($this->gallery) > 0): ?>
		<a href="#" class="uk-position-center-left uk-position-small uk-icon-button"
		   uk-icon="icon: chevron-left;" uk-slideshow-item="previous"></a>
		<a href="#" class="uk-position-center-right uk-position-small uk-icon-button"
		   uk-icon="icon: chevron-right;" uk-slideshow-item="next"></a>
		<ul class="el-nav uk-thumbnav uk-flex-left uk-margin-top">
			<?php foreach ($this->gallery as $i => $media):
				$displayData = [
					'item'     => $media['item'],
					'type'     => $media['type'],
					'product'  => $this->product,
					'category' => $this->category
				] ?>
				<li class="<?php echo ($i === 0) ? 'uk-active' : ''; ?>" uk-slideshow-item="<?php echo $i; ?>">
					<?php echo LayoutHelper::render($media['type']['layout_preview'], $displayData); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
