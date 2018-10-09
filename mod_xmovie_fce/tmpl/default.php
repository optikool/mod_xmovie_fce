<?php
/*
 * @package Joomla 3.0
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component XMovie Component
 * @copyright Copyright (C) Dana Harris optikool.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */ 
defined('_JEXEC') or die('Restricted access');

$items_count = count($list);
$currRow = 1;
$itemCount = 1;
$fceImgPerRow = $params->get('movies_per_row', 4);
$span = $params->get('bootstrap_size', 0);
$span_rounded = round(12 / intval($fceImgPerRow));

if($span == 0) {
	$span = '';
} else {
	$span = "span{$span}";
}

if($items_count > 0) {	
	foreach($list as $item) {
	$link = JRoute::_("index.php?option=com_xmovie&view=single&catid={$item->catid}:{$item->catalias}&id={$item->id}:{$item->alias}&Itemid={$item->itemId}");
				
	if($currRow == 1) {
	?>
	<div class="row-fluid <?php echo $span;?> <?php echo $params->get('moduleclass_sfx'); ?>">
	<?php
	}
?>
	<div class="image-item text-center span<?php echo $span_rounded; ?>">
		<?php if($params->get('show_thumb')) { ?>
		<a href="<?php echo $link ;?>">
			<?php 
			$imageThumb = parse_url($item->thumb);
				
			if(!isset($imageThumb['host']) || $imageThumb['host'] == '') {
				$movString = "components/com_xmovie/helpers/img.php?file=".urlencode($item->thumb)."&t=m";
			} else {
				$movString = $item->thumb;										
			}
			?>
			<img class="thumbnail img-responsive" src="<?php echo $movString; ?>" alt="<?php echo htmlspecialchars($item->title); ?>" />
		</a>
		<?php } ?>
		<?php if($params->get('show_name')) {?>
		<h4>
			<?php if(!$params->get('show_thumb')) { ?>
			<a href="<?php echo $link ;?>">
			<?php } ?>
			<?php echo htmlspecialchars($item->title); ?>	
			<?php if(!$params->get('show_thumb')) { ?>
			</a">
			<?php } ?>
		</h4>
		<?php } ?>
		<?php if($params->get('show_date')) {?>
		<div class="image-date">
			<strong><?php echo JTEXT::_('MOD_XMOVIE_FCE_DATE'); ?></strong> <?php echo JHTML::Date($item->creation_date, 'm-d-Y'); ?>
		</div>
		<?php } ?>
		<?php if($params->get('show_hits')) {?>
		<div class="image-hits">
			<strong><?php echo JTEXT::_('MOD_XMOVIE_FCE_HITS'); ?></strong> <?php echo $item->hits; ?>
		</div>
		<?php } ?>
		<?php if($params->get('show_submitter')) {?>
		<div class="image-submitter">
			<strong><?php echo JTEXT::_('MOD_XMOVIE_FCE_SUBMITTER'); ?></strong> <?php echo $item->submitter; ?>
		</div>
		<?php } ?>
		<?php if($params->get('show_quicktake')) {?>
		<div class="image-introtext">
			<?php echo $item->introtext; ?>
		</div>
		<?php } ?>
	</div>
	<?php 
		
		if($currRow < $fceImgPerRow && $itemCount != $items_count) {
			$currRow++;
		} else {
			echo '<div class="clearfix"></div>';
			echo '</div>';
			$currRow = 1;
		}
		$itemCount++;
	}
} ?>




<?php /*
<div class="xmovie-fce-<?php echo $xmovieFceDirection; ?><?php echo $moduleclass_sfx; ?>">
<?php 

foreach($list as $item) {
	$link = JRoute::_("index.php?option=com_xmovie&view=single&catid={$item->catid}:{$item->catalias}&id={$item->id}:{$item->alias}&Itemid={$item->itemId}");
	
	if($current_count == 1) {
		?>
		<div class="image-item image-item-first" <?php echo $divWidth; ?>>
		<?php 
	} elseif($current_count == $items_count) {
		?>
		<div class="image-item image-item-last" <?php echo $divWidth; ?>>
		<?php 
	} else {
		?>
		<div class="image-item" <?php echo $divWidth; ?>>
		<?php 
	}
	$current_count++;
	?>		
		<?php if($params->get('show_thumb')) {
			$imageThumb = parse_url($item->thumb);
				
			if(!isset($imageThumb['host']) || $imageThumb['host'] == '') {
				$movString = "components/com_xmovie/helpers/img.php?file=".urlencode($item->thumb)."&t=m";
			} else {
				$movString = $item->thumb;										
			}
		?>
		<div class="image-img">
			<div class="image-item-inner">	
				<?php if($showMovie) { echo $item->embed['open']; } else {  ?>
				<a href="<?php echo $link ;?>">
				<?php }?>
					<img src="<?php echo $movString; ?>" alt="<?php echo htmlspecialchars($item->title); ?>" />
				<?php if($showMovie) { echo $item->embed['close']; } else { ?>
				</a>
				<?php }?>
			</div>
		</div>
		<?php } ?>	
		
		<?php if($params->get('show_name')) {?>		
			<h6>
			<?php if($showMovie) { ?>
				<a href="<?php echo $link ;?>">
			<?php }?>	
			<?php echo htmlspecialchars($item->title); ?>	
			<?php if($showMovie) { ?>
			</a>
			<?php }?>
			</h6>			
		<?php } ?>	
		
		<?php if($params->get('show_quicktake')) {?>
		<div class="image-quicktake">
			<?php echo $item->quicktake; ?>
		</div>
		<?php } ?>
		
		<?php if($params->get('show_date') || $params->get('show_hits')) {?>
		<ul class="list list-horizontal">
			<?php if($params->get('show_date')) {?>
			<li class="image-date">
				<strong><?php echo JTEXT::_('Date'); ?>:</strong> <?php echo JHTML::Date($item->creation_date, 'm-d-Y'); ?>
			</li>
			<?php } ?>
			
			<?php if($params->get('show_hits')) {?>
			<li class="image-hits">
				<strong><?php echo JTEXT::_('Hits'); ?>:</strong> <?php echo $item->hits; ?>
			</li>
			<?php } ?>
		</ul>
		<?php } ?>
		<div class="clear"><!-- clear --></div>
		
	</div>
	<?php 
	if($collRows < ($params->get('movies_per_row') - 1)) {
		$collRows++;
	} else {
		echo '<div style="clear:both;"><!-- clear --></div>';
		$collRows = 0;
	}
	?>
	<?php } ?>
</div>
*/ ?>