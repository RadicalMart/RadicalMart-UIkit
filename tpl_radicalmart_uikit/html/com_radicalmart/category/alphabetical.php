<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     3.0.12
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2026 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;

/** @var \Joomla\Component\RadicalMart\Site\View\Category\HtmlView $this */

// Load assets
/** @var \Joomla\CMS\WebAsset\WebAssetManager $assets */
$assets = $this->getDocument()->getWebAssetManager();
if ($this->params->get('trigger_js', 1))
{
	$assets->useScript('com_radicalmart.site.trigger');
}

$groups = [];
if (!empty($this->children))
{
	$mb_strtoupper_enable = function_exists('mb_strtoupper');
	$mb_substr_enable     = function_exists('mb_substr');

	$this->children = ArrayHelper::sortObjects($this->children, 'title');
	foreach ($this->children as $item)
	{
		$upper = ($mb_strtoupper_enable) ? mb_strtoupper($item->title, 'UTF-8') : strtoupper($item->title);
		$first = ($mb_substr_enable) ? mb_substr($upper, 0, 1, 'UTF-8') : substr($upper, 0);

		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $first) || is_numeric($first))
		{
			$group = '[0-9]';
		}
		else
		{
			$group = $first;
		}

		if (!isset($groups[$group]))
		{
			$groups[$group] = [];
		}

		$groups[$group][] = $item;
	}
}
?>
<div id="RadicalMart" class="categories-alphabetical">
	<h1 class="uk-h2 uk-margin">
		<?php echo $this->params->get('seo_categories_h1', $this->category->title); ?>
	</h1>
	<?php if (!empty($this->category->introtext)): ?>
		<div class="category info uk-text-center">
			<?php echo $this->category->introtext; ?>
		</div>
	<?php endif; ?>
	<?php if (empty($this->children)) : ?>
		<div class="uk-alert uk-alert-warning">
			<?php echo Text::_('COM_RADICALMART_ERROR_CATEGORIES_NOT_FOUND'); ?>
		</div>
	<?php else : ?>
		<?php foreach ($groups as $group => $items): ?>
			<div class="categories-group uk-card uk-card-default uk-card-small uk-margin">
				<div class="uk-card-header">
					<h2 class="uk-h4">
						<?php echo $group; ?></h2>
				</div>
				<div class="uk-card-body">
					<div class="categories-list uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
						<?php foreach ($items as $item): ?>
							<div>
								<h3 class="uk-h5">
									<a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
								</h3>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if (!empty($this->category->fulltext)): ?>
		<div class="fulltext uk-margin-medium uk-card uk-card-default uk-card-body">
			<?php echo $this->category->fulltext; ?>
		</div>
	<?php endif; ?>
</div>