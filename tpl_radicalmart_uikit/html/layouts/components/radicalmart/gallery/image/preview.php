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
<div class="uk-flex uk-flex-center uk-flex-middle uk-position-relative uk-overflow-hidden"
	 style="height: 64px; width: 64px">
	<div class="uk-position-cover uk-background-cover uk-background-center-center"
		 style="background-image: url('<?php echo $item->src; ?>');
				 filter: blur(14px) brightness(0.85);
				 transform: scale(1.1);"></div>
	<?php echo MediaHelper::renderImage('com_radicalmart.product.gallery.preview', $item->src,
			[
					'alt'     => (!empty($item->alt)) ? $item->alt : $product->title,
					'loading' => 'lazy',
					'style'   => 'max-width: 100%; max-height:100%;',
					'class'   => 'uk-position-relative uk-position-z-index',
			],
			[
					'product_id' => $product->id,
					'no_image'   => true,
					'thumb'      => true,
			]);
	?>
</div>
