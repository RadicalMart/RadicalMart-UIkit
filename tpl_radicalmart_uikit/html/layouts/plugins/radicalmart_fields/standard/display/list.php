<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     1.1.0
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2023 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

defined('_JEXEC') or die;


extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $field Field data object.
 * @var  array $values Field values.
 *
 */
?>
<ul class="uk-list uk-list-square uk-list-collapse uk-list-muted uk-margin-remove">
	<?php foreach ($values as $value): ?>
		<li><?php echo $value['text']; ?></li>
	<?php endforeach; ?>
</ul>