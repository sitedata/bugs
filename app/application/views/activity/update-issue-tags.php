<li onclick="window.location='<?php echo $issue->to(); ?>';">
	<div class="tag">
		<label class="label info"><?php echo __('tinyissue.tag_update'); ?></label>
	</div>

	<div class="data">
		<div class="tag-activity">
			<?php 
				if($tag_counts['added'] > 0) {
					foreach($tag_diff['added_tags'] as $tag) { 
						//2 sept 2021 recherche d'un bogue lié à ftcolor
						echo '<label class="label">' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
						//echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="color: '.($tag_diff['tag_data'][$tag]['ftcolor'] ? $tag_diff['tag_data'][$tag]['ftcolor'] : 'black').'; background-color: '.$tag_diff['tag_data'][$tag]['bgcolor'].';' : '') . '">' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
						////echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="color: '.$tag_diff['tag_data'][$tag]['ftcolor'].'; background-color: '.$tag_diff['tag_data'][$tag]['bgcolor'].';"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
						////echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="background-color: '.$tag_diff['tag_data'][$tag]['bgcolor'].';"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
					} 
					echo __($tag_counts['added'] > 1 ? 'tinyissue.tags_added' : 'tinyissue.tag_added'); 
					echo __('tinyissue.in'); 
					echo '<a href="'.$issue->to().'">'.$issue->title.'</a>';
					echo __('tinyissue.by'); 
					echo '<strong>'.$user->firstname . ' ' . $user->lastname.'</strong>';
				} 
			
			if($tag_counts['added'] > 0 && $tag_counts['removed'] > 0) { echo '<div class="tag-activity-spacer"></div>'; } 
			
			if($tag_counts['removed'] > 0) {
				foreach($tag_diff['removed_tags'] as $tag) { 
					//2 sept 2021 recherche d'un bogue lié à ftcolor
					echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="float: none; color: ' . ($tag_diff['tag_data'][$tag]['ftcolor'] ? $tag_diff['tag_data'][$tag]['ftcolor'] : 'black') . '; background-color: ' . $tag_diff['tag_data'][$tag]['bgcolor'] . ';' : '') . '">' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
					//echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="float: none; color: ' . $tag_diff['tag_data'][$tag]['ftcolor'] . '; background-color: ' . $tag_diff['tag_data'][$tag]['bgcolor'] . ';"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
					//echo '<label class="label"' . (isset($tag_diff['tag_data'][$tag]['bgcolor']) ? ' style="float: none; background-color: ' . $tag_diff['tag_data'][$tag]['bgcolor'] . ';"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; 
				}
				echo __($tag_counts['removed'] > 1 ? 'tinyissue.tags_removed' : 'tinyissue.tag_removed'); 
				echo __('tinyissue.in'); 
				echo '<a href="'.$issue->to().'">'.$issue->title.'</a>';
				echo __('tinyissue.by');
				echo '<strong>'.$user->firstname . ' ' . $user->lastname.'</strong>';
			} 
			?>
		</div>
		<span class="time">
			<?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->created_at)); ?>
		</span>
	</div>

	<div class="clr"></div>
</li>