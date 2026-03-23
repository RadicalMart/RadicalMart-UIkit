<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.11
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Product\HtmlView $this */
if (empty($this->gallery))
{
	$noImageItem       = new \stdClass();
	$noImageItem->type = 'image';
	$noImageItem->src  = HTMLHelper::image('com_radicalmart/no-image.svg', '', [], true, true);
	$noImageItem->alt  = '';

	$this->gallery = [
			[
					'item' => $noImageItem,
					'type' => [
							'type'           => 'image',
							'layout_slide'   => 'components.radicalmart.gallery.image.slide',
							'layout_preview' => 'components.radicalmart.gallery.image.preview'
					]
			]
	];
}
?>
<div uk-slideshow="animation: push; min-height:300px; max-height:300px;">
	<div class="uk-position-relative uk-visible-toggle" tabindex="-1">
		<div class="uk-slideshow-items" uk-lightbox>
			<?php foreach ($this->gallery as $media):
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
		</div>
		<a class="uk-position-center-left uk-position-small uk-hidden-hover uk-lightbox-button" href
		   uk-slidenav-previous
		   uk-slideshow-item="previous"></a>
		<a class="uk-position-center-right uk-position-small uk-hidden-hover uk-lightbox-button" href uk-slidenav-next
		   uk-slideshow-item="next"></a>
	</div>

	<ul class="uk-thumbnav uk-margin">
		<?php foreach ($this->gallery as $m => $media):
			$displayData = [
					'item'     => $media['item'],
					'type'     => $media['type'],
					'product'  => $this->product,
					'category' => $this->category
			] ?>
			<li class="<?php echo ($m === 0) ? 'uk-active' : ''; ?>" uk-slideshow-item="<?php echo $m; ?>">
				<a href class="uk-display-block">
					<?php echo LayoutHelper::render($media['type']['layout_preview'], $displayData); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>