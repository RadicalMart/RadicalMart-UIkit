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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  array  $entry   Entry data.
 * @var  object $product Product data.
 * @var  object $cart    All cart data.
 *
 */
?>
<div radicalmart-cart-layout="notification_add">
	<div id="radicalmart_cart_notification_add" style="display: none !important;">
		<a href="<?php echo $cart->link; ?>" class="uk-flex uk-flex-middle uk-grid-small uk-child-width-expand
		uk-link-reset uk-text-decoration-none uk-text-normal">
			<div class="uk-width-auto">
				<?php echo LayoutHelper::render('components.radicalmart.items.image', [
						'product'   => $product,
						'link'      => false,
						'height_px' => 64,
						'width_px'  => 64,
				]); ?>
			</div>
			<div>
				<div class="uk-text-meta">
					<?php echo Text::_('COM_RADICALMART_CART_NOTIFICATION_ADD'); ?>
				</div>
				<div class="uk-h5 uk-margin-remove-top uk-margin-small-bottom">
					<?php echo $product->title ?>
				</div>
			</div>
		</a>
	</div>
</div>