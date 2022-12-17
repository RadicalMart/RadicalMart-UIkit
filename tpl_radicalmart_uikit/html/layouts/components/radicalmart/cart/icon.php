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

use Joomla\CMS\Factory;

$app       = Factory::getApplication();
$hideTotal = (($app->input->get('option') === 'com_radicalmart')
	&& in_array($app->input->get('view'), ['checkout', 'cart']));
?>
<div class="radicalmart-container">
	<a radicalmart-cart="display_module" class="uk-link-reset radicalmart-icon" uk-tooltip>
		<span uk-icon="cart" class="uk-icon"></span>
		<?php if (!$hideTotal): ?>
			<span class="uk-badge quantity" radicalmart-cart-display="total.products" style="display:none">0</span>
		<?php endif; ?>
	</a>
</div>