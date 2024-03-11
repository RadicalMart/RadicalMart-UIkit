<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string  $id             DOM id of the field.
 * @var   string  $label          Label of the field.
 * @var   string  $name           Name of the input field.
 * @var   string  $value          Value attribute of the field.
 * @var   array   $checkedOptions Options that will be set as checked.
 * @var   boolean $hasValue       Has this field a value assigned?
 * @var   array   $options        Options available for this field.
 * @var   string  $onchange       Onchange attribute for the field.
 */
?>
<div id="<?php echo $id; ?>" class="radicalmart-fields-standard-filter_images">
	<ul class="uk-thumbnav uk-margin-remove">
		<?php foreach ($options as $i => $option): ?>
			<?php
			$checked = in_array((string) $option->value, $checkedOptions, true) ? 'checked' : '';
			$checked = (!$hasValue && $option->checked) ? 'checked' : $checked;
			$active  = ($checked) ? 'uk-active' : '';
			$oid     = $id . $i;
			$value   = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8');
			?>
			<li class="uk-margin-small-bottom <?php echo $active; ?>">
				<label for="<?php echo $oid; ?>" uk-tooltip="<?php echo htmlspecialchars($option->text); ?>"
					   class="uk-position-relative">
					<?php if ($src = $option->image)
					{
						$src = MediaHelper::findThumb($src);
						echo HTMLHelper::image($src, htmlspecialchars($option->text));
					}
					else echo '<span class="uk-label">' . $option->text . '</span>' ?>
					<input id="<?php echo $oid; ?>" name="<?php echo $name ?>" type="checkbox"
						   class="uk-hidden" <?php echo $checked; ?>
						   value="<?php echo $value; ?>"
						   onchange="if(this.checked) this.closest('li').classList.add('uk-active'); else this.closest('li').classList.remove('uk-active'); this.closest('label').blur();
						   <?php if (!empty($onchange)) echo $onchange; ?>">
				</label>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="uk-text-right">
		<span class="uk-link uk-text-small uk-text-danger uk-text-lowercase"
			  onclick="this.closest('.radicalmart-fields-standard-filter_images').querySelectorAll('input')
			  .forEach(function (input) {input.checked = false; input.dispatchEvent(new Event('change'));});">
			<?php echo Text::_('PLG_RADICALMART_FIELDS_STANDARD_CLEAN'); ?>
		</span>
	</div>
</div>