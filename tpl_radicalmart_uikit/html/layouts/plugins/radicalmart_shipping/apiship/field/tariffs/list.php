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

use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Administrator\Helper\PriceHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string $field_id   Field id.
 * @var   string $field_name Field name.
 * @var   string $provider   Provider key.
 * @var   int    $value      Field value.
 * @var   array  $tariffs    Autocomplete attribute for the field.
 * @var   string $currency   Currency code.
 */

$providerTitle        = Text::_('PLG_RADICALMART_SHIPPING_APISHIP_PROVIDER_' . $provider)
?>
<?php foreach ($tariffs as $tariff):
	$tariff_fieldId = $field_id . '_' . $tariff->tariffId;
	$tariff_fieldName = $field_name . '[tariffs_select]';
	$tariff_price     = PriceHelper::toString($tariff->deliveryCost, $currency);
	$tariff_title     = Text::sprintf('PLG_RADICALMART_SHIPPING_APISHIP_POINTS_TARIFFS_FIELD_TITLE',
		$providerTitle, $tariff->tariffName, $tariff_price);

	if (!empty($tariff->calendarDaysMax))
	{
		$tariff_days  = Text::plural('PLG_RADICALMART_SHIPPING_APISHIP_DAYS_N_ITEMS', (int) $tariff->calendarDaysMax);
		$tariff_title = Text::sprintf('PLG_RADICALMART_SHIPPING_APISHIP_POINTS_TARIFFS_FIELD_TITLE_DAYS',
			$providerTitle, $tariff->tariffName, $tariff_price, $tariff_days);
	}
	?>
	<div>
		<label for="<?php echo $tariff_fieldId; ?>">
			<input id="<?php echo $tariff_fieldId; ?>"
				   name="<?php echo $tariff_fieldName; ?>"
				   type="radio"
				   value="<?php echo $tariff->tariffId; ?>"
				   class="uk-radio"
				<?php if ($tariff->tariffId === $value) echo 'checked'; ?>
				   radicalmart-shipping-apiship-field-tariffs="input_tariff"
				   data-tariff_name="<?php echo $tariff->tariffName; ?>">
			<?php echo $tariff_title; ?>
		</label>
	</div>
<?php endforeach; ?>