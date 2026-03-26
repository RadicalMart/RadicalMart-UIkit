<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.15
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $item     Media item.
 * @var  array  $type     Media item type
 * @var  object $product  Product object.
 * @var object  $category Product category object.
 *
 */

?>
<div class="uk-height-1-1 uk-width-1-1 uk-position-relative">
	<div class="uk-position-cover uk-background-cover uk-background-center-center"
		 style="background-image: url('<?php echo $item->src; ?>');
				 filter: blur(14px) brightness(0.85);
				 transform: scale(1.1);"></div>

	<a href="<?php echo $item->src; ?>"
	   class="uk-height-1-1 uk-width-1-1 uk-flex uk-flex-middle uk-flex-center
						   uk-position-relative uk-position-z-index">
		<?php echo MediaHelper::renderImage(
				'com_radicalmart.product.gallery.slide',
				$item->src,
				[
						'alt'     => (!empty($item->alt)) ? $item->alt : $product->title,
						'loading' => 'lazy',
						'style'   => 'max-width: 100%; max-height: 100%'
				],
				[
						'product_id' => $product->id,
						'no_image'   => true,
						'thumb'      => true,
				]);
		?>
	</a>
</div>