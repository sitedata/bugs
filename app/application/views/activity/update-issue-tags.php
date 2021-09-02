<li onclick="window.location='<?php echo $issue->to(); ?>';">

	<div class="tag">
		<label class="label info"><?php echo __('tinyissue.tag_update'); ?></label>
	</div>

	<div class="data">
		<div class="tag-activity">
			<?php if($tag_counts['added'] > 0): ?>
			<?php foreach($tag_diff['added_tags'] as $tag): ?>
				<?php 
						//2 sept 2021 recherche d'un bogue lié à ftcolor
				//echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="color: '.$tag_diff['tag_data'][$tag]['ftcolor'].'; background-color: '.$tag_diff['tag_data'][$tag]['bgcolor'].';"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
				echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="background-color: '.$tag_diff['tag_data'][$tag]['bgcolor'].';"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
				?>
			<?php endforeach; ?>
			<?php echo __($tag_counts['added'] > 1 ? 'tinyissue.tags_added' : 'tinyissue.tag_added'); ?>
			<?php echo __('tinyissue.in'); ?>
			<a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a>
			<?php echo __('tinyissue.by'); ?>
			<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>
			<?php endif; ?>

			<?php if($tag_counts['added'] > 0 && $tag_counts['removed'] > 0): ?><div class="tag-activity-spacer"></div><?php endif; ?>

			<?php if($tag_counts['removed'] > 0): ?>
			<?php foreach($tag_diff['removed_tags'] as $tag): ?>
				<?php 
					//2 sept 2021 recherche d'un bogue lié à ftcolor
					//echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="float: none; color: ' . $tag_diff['tag_data'][$tag]['ftcolor'] . '; background-color: ' . $tag_diff['tag_data'][$tag]['bgcolor'] . ';"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
					echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="float: none; background-color: ' . $tag_diff['tag_data'][$tag]['bgcolor'] . ';"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
				?>
			<?php endforeach; ?>
			<?php echo __($tag_counts['removed'] > 1 ? 'tinyissue.tags_removed' : 'tinyissue.tag_removed'); ?>
			<?php echo __('tinyissue.in'); ?>
			<a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a>
			<?php echo __('tinyissue.by'); ?>
			<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>
			<?php endif; ?>
		</div>
		<span class="time">
			<?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->created_at)); ?>
		</span>
	</div>

	<div class="clr"></div>
</li>