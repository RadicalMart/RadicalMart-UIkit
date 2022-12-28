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

use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;


extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $field  Field data object.
 * @var  array  $values Field values.
 *
 */
?>
<ul class="uk-thumbnav uk-margin-remove">
	<?php foreach ($values as $value): ?>
		<li class="uk-active">
			<div uk-tooltip="<?php echo $value['text']; ?>">
				<?php if ($src = $value['image'])
				{
					$src = RadicalMartHelperMedia::findThumb($src);
					echo HTMLHelper::image($src, htmlspecialchars($value['text']));
				}
				else echo '<span class="uk-label">' . $value['text'] . '</span>'; ?>
			</div>
		</li>
	<?php endforeach; ?>
</ul>