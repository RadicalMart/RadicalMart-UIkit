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

<a href="#" style="width: 60px; height: 40px;">
	<div class="uk-flex uk-background-muted uk-flex-middle uk-flex-center uk-padding-small uk-height-1-1 uk-width-1-1">
		<?php echo MediaHelper::renderImage(
			'com_radicalmart.product.gallery.preview',
			$item->src,
			[
				'alt'     => (!empty($item->alt)) ? $item->alt : $product->title,
				'loading' => 'lazy',
				'style'   => 'max-width: 100%; max-height:100%;'
			],
			[
				'product_id' => $product->id,
				'no_image'   => true,
				'thumb'      => true,
			]);
		?>
	</div>
</a>

