<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.0.1
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

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
					$src = MediaHelper::findThumb($src);
					echo HTMLHelper::image($src, htmlspecialchars($value['text']));
				}
				else echo '<span class="uk-label">' . $value['text'] . '</span>'; ?>
			</div>
		</li>
	<?php endforeach; ?>
</ul>