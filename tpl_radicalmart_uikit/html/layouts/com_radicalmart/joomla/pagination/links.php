<?php
/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.1.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

if (empty($displayData) || !is_array($displayData) || empty($displayData['list']) || empty($displayData['list']['pages'])) return;

$range   = 5;
$current = round($displayData['list']['limitstart'] / $displayData['list']['limit']) + 1;
$last    = (int) $displayData['list']['pagesTotal'];
$factor  = ($range - 1) / 2;
$numbers = range($current - $factor, $current + $factor);
if ($current <= $factor + 3)
{
	$numbers = range(1, $range + 2);
}
elseif ($current >= $last - 3)
{
	$numbers = range($last - $range - 1, $last);
}
$firstShow = (!in_array(1, $numbers));
$firstDots = (!in_array(2, $numbers));
$lastDots  = (!in_array($last - 1, $numbers));
$lastShow  = (!in_array($last, $numbers));

$list  = $displayData['list'];
$pages = $list['pages'];
?>
<div class="uk-flex uk-flex-middle uk-flex-between">
	<div>
		<?php if ($pages['previous']['active']): ?>
			<a href="<?php echo $pages['previous']['data']->link; ?>"
			   title="<?php echo Text::_('COM_RADICALMART_PAGINATION_PREV'); ?>" uk-tooltip>
				<span uk-icon="icon:chevron-left; ratio:2"></span>
			</a>
		<?php else: ?>
			<span uk-icon="icon:chevron-left; ratio:2" class="uk-text-muted"
				  title="<?php echo Text::_('COM_RADICALMART_PAGINATION_PREV'); ?>" uk-tooltip></span>
		<?php endif; ?>
	</div>
	<div class="uk-text-center">
		<ul class="uk-pagination uk-flex-center uk-margin-remove-bottom">
			<?php if ($firstShow): ?>
				<li>
					<a href="<?php echo rtrim(str_replace('start=0', '', $pages['start']['data']->link), '?') ?>"
					   title="<?php echo Text::sprintf('COM_RADICALMART_PAGINATION', 1); ?>" uk-tooltip>
						1
					</a>
				</li>
			<?php endif; ?>
			<?php if ($firstDots): ?>
				<li class="uk-disabled"><span>...</span></li>
			<?php endif; ?>
			<?php foreach ($pages['pages'] as $number => $page): ?>
				<?php
				if (!in_array($number, $numbers))
				{
					continue;
				} ?>
				<?php if (!$page['data']->active): ?>
					<li>
						<a href="<?php echo rtrim(str_replace('start=0', '', $page['data']->link), '?'); ?>"
						   title="<?php echo Text::sprintf('COM_RADICALMART_PAGINATION', $number); ?>" uk-tooltip>
							<?php echo $page['data']->text; ?>
						</a>
					</li>
				<?php else: ?>
					<li class="uk-active">
						<span title="<?php echo Text::sprintf('COM_RADICALMART_PAGINATION', $number); ?>" uk-tooltip>
							<?php echo $page['data']->text; ?>
						</span>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php if ($lastDots): ?>
				<li class="uk-disabled"><span>...</span></li>
			<?php endif; ?>
			<?php if ($lastShow): ?>
				<li>
					<a href="<?php echo $pages['end']['data']->link ?>"
					   title="<?php echo Text::sprintf('COM_RADICALMART_PAGINATION', $last); ?>" uk-tooltip>
						<?php echo $last; ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>
		<div class="uk-text-small uk-text-meta uk-text-center">
			<?php echo $list['pagescounter']; ?>
		</div>
	</div>
	<div>
		<?php if ($pages['next']['active']): ?>
			<a href="<?php echo $pages['next']['data']->link; ?>"
			   title="<?php echo Text::_('COM_RADICALMART_PAGINATION_NEXT'); ?>" uk-tooltip>
				<span uk-icon="icon:chevron-right; ratio:2"></span>
			</a>
		<?php else: ?>
			<span uk-icon="icon:chevron-right; ratio:2" class="uk-text-muted"
				  title="<?php echo Text::_('COM_RADICALMART_PAGINATION_NEXT'); ?>" uk-tooltip></span>
		<?php endif; ?>
	</div>
</div>