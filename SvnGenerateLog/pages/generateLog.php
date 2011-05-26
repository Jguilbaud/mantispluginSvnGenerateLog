<?php
html_robots_noindex();

html_page_top( lang_get( 'report_bug_link' ) );

print_recently_visited();

?>
<br /><br />
<table align="center" class="width50" cellspacing="1">

<tr>
	<td class="form-title" >
		SVN : Log Message
	</td>
</tr>

<tr <?php echo helper_alternate_class( )?>>
	<td>
		<textarea style="width:100%;" rows="20"><?php	echo $t_generated_log;?></textarea>
	</td>
</tr>


</table>

<?php 
html_page_bottom();
