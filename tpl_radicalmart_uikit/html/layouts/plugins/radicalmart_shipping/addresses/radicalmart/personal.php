<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  Form   $form      Form object.
 * @var  object $item      Personal object.
 * @var  object $shipping  Checkout shipping method object.
 * @var  array  $fieldsets Method fieldsets.
 * @var  string $group     Method fields group.
 *
 */

if (empty($shipping))
{
	return false;
}

?>
<div id="personal_shipping_method_<?php echo $shipping->id; ?>" >
	<?php echo $form->renderField('addresses', $group, null, ['hiddenLabel' => true]); ?>
</div>
