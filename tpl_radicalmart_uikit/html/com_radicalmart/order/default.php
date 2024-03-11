<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.0.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->document->getWebAssetManager();
if ($this->params->get('radicalmart_js', 1))
{
	$assets->useScript('com_radicalmart.site');
}

if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

$fieldsets = [];
foreach ($this->form->getFieldsets() as $key => $fieldset)
{
	foreach ($this->form->getFieldset($key) as $field)
	{
		$name  = $field->fieldname;
		$group = $field->group;
		$type  = strtolower($field->type);
		$class = $this->form->getFieldAttribute($name, 'class', '', $group);
		$input = $field->input;
		if ($type === 'text' || $type === 'email')
		{
			$class .= ' uk-input';
		}
		elseif ($type === 'list' || preg_match('#<select#', $input))
		{
			$class .= ' uk-select';
		}
		elseif ($type === 'textarea' || preg_match('#<textarea#', $input))
		{
			$class .= ' uk-textarea';
		}
		elseif ($type === 'range')
		{
			$class .= ' uk-range';
		}

		$this->form->setFieldAttribute($name, 'class', $class, $group);
	}
}
?>
<div id="RadicalMart" class="order">
	<h1 class="uk-h2 uk-margin uk-margin-remove-top uk-text-center">
		<?php echo $this->params->get('seo_order_h1', $this->order->title); ?>
	</h1>
	<div class="uk-child-width-expand@m uk-grid-medium" uk-grid>
		<div>
			<div id="order_products" class="uk-margin">
				<h2 class="uk-hidden"><?php echo Text::_('COM_RADICALMART_PRODUCTS'); ?></h2>
				<div class="uk-card uk-card-default">
					<table class="uk-table uk-table-divider uk-table-responsive">
						<thead class="uk-visible@m">
						<tr>
							<th class="uk-text-center">
								<?php echo Text::_('COM_RADICALMART_PRODUCT'); ?>
							</th>
							<th class="uk-text-center">
								<?php echo Text::_('COM_RADICALMART_PRICE'); ?>
							</th>
							<th class="uk-text-center">
								<?php echo Text::_('COM_RADICALMART_QUANTITY'); ?>
							</th>
							<th class="uk-text-center">
								<?php echo Text::_('COM_RADICALMART_SUM'); ?>
							</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($this->order->products as $product): ?>
							<tr>
								<td>
									<div class="uk-grid-small uk-child-width-expand" uk-grid>
										<div class="uk-width-1-4">
											<a href="<?php echo $product->link; ?>"
											   class="uk-height-max-small uk-width-1-1 uk-flex uk-flex-center uk-flex-middle">
												<?php echo MediaHelper::renderImage(
													'com_radicalmart.products.order',
													$product->image,
													[
														'alt'     => $product->title,
														'loading' => 'lazy',
														'class'   => 'uk-height-max-medium'
													],
													[
														'product_id' => $product->id,
														'no_image'   => true,
														'thumb'      => true,
													]); ?>
											</a>
										</div>
										<div>
											<?php if ($product->category): ?>
												<div>
													<a href="<?php echo $product->category->link; ?>"
													   class="uk-text-nowrap uk-link-muted">
														<?php echo $product->category->title; ?>
													</a>
												</div>
											<?php endif; ?>
											<div>
												<a href="<?php echo $product->link; ?>"
												   class="uk-link-reset"><?php echo $product->title; ?></a>
											</div>
											<?php if (!empty($product->extra_display)): ?>
												<div class="uk-flex uk-flex-wrap">
													<?php foreach ($product->extra_display as $extra):
														if (empty($extra) || empty($extra['html']))
														{
															continue;
														}
														?>
														<div class="uk-margin-small-right uk-margin-small-bottom">
															<?php echo $extra['html']; ?>
														</div>
													<?php endforeach; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</td>
								<td class="uk-text-center uk-text-nowrap">
									<?php if ($product->order['discount_enable']): ?>
										<div class="uk-text-small uk-text-muted">
											<s><?php echo $product->order['base_string']; ?></s>
											<?php echo ' ( - ' . $product->order['discount_string'] . ')'; ?>
										</div>
									<?php endif; ?>
									<div><?php echo $product->order['final_string']; ?></div>
								</td>
								<td class="uk-text-center">
									<div class="uk-flex uk-flex-center uk-flex-middle">
										<?php echo $product->order['quantity']; ?>
									</div>
								</td>
								<td class="uk-text-center">
									<?php if ($product->order['discount_enable']): ?>
										<div class="uk-text-small uk-text-muted uk-text-nowrap">
											<s><?php echo $product->order['sum_base_string']; ?></s>
											<?php echo ' ( - ' . $product->order['sum_discount_string'] . ')'; ?>
										</div>
									<?php endif; ?>
									<div class="uk-text-nowrap uk-text-bold">
										<?php echo $product->order['sum_final_string']; ?>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php foreach ($this->form->getFieldsets() as $key => $fieldset):
				$fields = $this->form->getFieldset($key);
				if (empty($fields))
				{
					continue;
				}
				?>
				<div id="order_<?php echo $key; ?>" class="uk-margin">
					<h2><?php echo Text::_($fieldset->label); ?></h2>
					<div class="uk-card uk-card-default uk-card-body uk-card-small">
						<table class="uk-table uk-table-small uk-table-justify uk-table-responsive uk-table-divider uk-margin-small-top uk-margin-remove-bottom">
							<tbody>
							<?php foreach ($fields as $field):
								$label = Text::_($this->form->getFieldAttribute($field->fieldname, 'label',
									'', $field->group));
								$input = $this->form->getInput($field->fieldname, $field->group);
								if (empty($label) && empty($input))
								{
									continue;
								}
								?>
								<tr>
									<th class="uk-width-medium">
										<?php echo $label; ?>
									</th>
									<td>
										<?php echo $input; ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="uk-width-1-4@m">
			<div class="uk-card uk-card-default uk-card-small">
				<?php echo $this->loadTemplate('sidebar'); ?>
			</div>
		</div>
	</div>
</div>