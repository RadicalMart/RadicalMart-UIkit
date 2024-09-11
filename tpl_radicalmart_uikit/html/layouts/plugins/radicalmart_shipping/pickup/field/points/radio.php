<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.2.1
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

\defined('_JEXEC') or die;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string $autocomplete   Autocomplete attribute for the field.
 * @var   bool   $autofocus      Is autofocus enabled?
 * @var   string $class          Classes for the input.
 * @var   string $description    Description of the field.
 * @var   bool   $disabled       Is this field disabled?
 * @var   string $group          Group the field belongs to. <fields> section in form XML.
 * @var   bool   $hidden         Is this field hidden in the form?
 * @var   string $hint           Placeholder for the field.
 * @var   string $id             DOM id of the field.
 * @var   string $label          Label of the field.
 * @var   string $labelclass     Classes to apply to the label.
 * @var   bool   $multiple       Does this field support multiple values?
 * @var   string $name           Name of the input field.
 * @var   string $onchange       Onchange attribute for the field.
 * @var   string $onclick        Onclick attribute for the field.
 * @var   string $pattern        Pattern (Reg Ex) of value of the form field.
 * @var   bool   $readonly       Is this field read only?
 * @var   bool   $repeat         Allows extensions to duplicate elements.
 * @var   bool   $required       Is this field required?
 * @var   int    $size           Size attribute of the input.
 * @var   bool   $spellcheck     Spellcheck state for the form field.
 * @var   string $validate       Validation rules to apply.
 * @var   array  $value          Value attribute of the field.
 * @var   array  $checkedOptions Options that will be set as checked.
 * @var   bool   $hasValue       Has this field a value assigned?
 * @var   array  $options        Options available for this field.
 *
 * Field specific variables
 * @var  array   $points         Points data array.
 */

?>
<div>
	<?php if (empty($points)): ?>
		<div class="uk-alert uk-alert-danger">
			<?php echo Text::_('PLG_RADICALMART_SHIPPING_PICKUP_ERROR_POINT_NOT_FOUND'); ?>
		</div>
	<?php else: ?>
		<?php foreach ($points as $key => $point):
			$checked = ($value === $key) ? 'checked' : ''; ?>
			<div class="uk-margin">
				<label for="<?php echo $id . '_' . $key; ?>"
					   class="uk-tile uk-padding-small uk-tile-muted">
					<div class="uk-child-width-expand uk-grid-small" uk-grid>
						<div class="uk-width-auto uk-flex uk-flex-middle">
							<input id="<?php echo $id . '_' . $key; ?>" class="uk-radio" type="radio"
								   name="<?php echo $name; ?>"
								   value="<?php echo $point['value']; ?>" <?php if (!empty($onchange)) echo ' onchange="' . $onchange . '"'; ?>
								<?php echo $checked; ?>>
						</div>
						<div>
							<div class="uk-h4 uk-margin-remove">
								<?php echo $point['title']; ?>
							</div>
							<?php if (!empty($point['address'])): ?>
								<div>
									<?php echo $point['address']; ?>
								</div>
							<?php endif; ?>
							<?php if (!empty($point['description'])): ?>
								<div class="uk-text-small uk-text-muted">
									<?php echo nl2br($point['description']); ?>
								</div>
							<?php endif; ?>
						</div>
						<?php if (!empty($point['image'])): ?>
							<div class="uk-width-auto">
								<div class="uk-text-center">
									<?php echo HTMLHelper::image($point['image'], htmlspecialchars($point['title'])); ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</label>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
