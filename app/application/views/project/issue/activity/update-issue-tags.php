<?php 
	if (!Project\User::MbrProj(\Auth::user()->id, Project::current()->id)) {
		echo '<script>document.location.href="'.URL::to().'";</script>';
	}
?>
<li id="comment<?php echo $activity->id; ?>" class="comment">
	<div class="insides">
		<div class="topbar">
			<div class="data">
				<?php
					if (trim($activity->attributes['data']) == '') {
						$Msg = ($activity->attributes['parent_id'] == $activity->attributes['item_id'] ) ? __('tinyissue.tag_removed') : __('tinyissue.tag_added');
						$Col = ($activity->attributes['parent_id'] == $activity->attributes['item_id'] ) ? "none" : "underline";
						$TagNum = Tag::where('id', '=', $activity->attributes['action_id'] )->first(array('id','tag','bgcolor','ftcolor'));
						$Who = \User::where('id', '=', $activity->attributes['user_id'] )->get(array('firstname','lastname','email'));
						echo '<label style="background-color: '.@$TagNum->attributes['bgcolor'].';color: '.@$TagNum->attributes['ftcolor'].'; padding: 5px 10px; border-radius: 8px;">';
						echo @$TagNum->attributes['tag'];
						echo '</label> : ';
						echo '<span style="font-weight: bold; text-decoration: '.$Col.';">'.$Msg.'</span>';
						echo  __('tinyissue.by') . ' <b>' .$Who[0]->attributes["firstname"].' '.$Who[0]->attributes["lastname"].'</b> ';
						echo date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->attributes['updated_at']));
					} else {
						$j = json_decode($activity->attributes['data'], true);
						echo count($j['added_tags']).' '.((count($j['added_tags']) > 1) ? __('tinyissue.tags_added') : __('tinyissue.tag_added')).'.';
						foreach ($j['tag_data'] as $ind => $val ) { 
							$tag_info = \DB::table('tags')->where('id', '=', $val["id"])->get();
						//2 sept 2021 recherche d'un bogue lié à ftcolor
							if ( in_array($val['id'], $j['added_tags'])) { echo '<label style="background-color: '.$tag_info[0]->bgcolor.'; '.($tag_info[0]->ftcolor ? 'color: '.$tag_info[0]->ftcolor.'; ' : '').' padding: 5px 10px; border-radius: 8px;">'.$val['tag'].'</label>'; } 
							//if ( in_array($val['id'], $j['added_tags'])) { echo '<label style="background-color: '.$tag_info[0]->bgcolor.'; color: '.$tag_info[0]->ftcolor.'; padding: 5px 10px; border-radius: 8px;">'.$val['tag'].'</label>'; } 
							//if ( in_array($val['id'], $j['added_tags'])) { echo '<label style="background-color: '.$tag_info[0]->bgcolor.'; color: black; padding: 5px 10px; border-radius: 8px;">'.$val['tag'].'</label>'; } 
						}
						echo '<br clear="all" />';
						echo '<br clear="all" />';
						echo count($j['removed_tags']).' '.((count($j['removed_tags']) > 1) ? __('tinyissue.tags_removed') : __('tinyissue.tag_removed')).'.';
						foreach ($j['tag_data'] as $ind => $val ) { 
						//2 sept 2021 recherche d'un bogue lié à ftcolor
							//if ( in_array($val['id'], $j['removed_tags'])) { echo '<label style="-color: '.$val['ftcolor'].'; background-color: '.$val['bgcolor'].'; padding: 5px 10px; border-radius: 8px;">'.$val['tag'].'</label>'; } 
							if ( in_array($val['id'], $j['removed_tags'])) { echo '<label style="-color: '.@$val['ftcolor'].'; background-color: '.$val['bgcolor'].'; padding: 5px 10px; border-radius: 8px;">'.$val['tag'].'</label>'; } 
						}
						echo '<br clear="all" />';
						echo ' '.date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->attributes['updated_at']));
					}
				?>
			</div>
		</div>
	</div>
	<div class="clr"></div>
</li>
