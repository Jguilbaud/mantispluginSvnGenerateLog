<?php
# MantisBT - a php based bugtracking system
# Copyright (C) 2002 - 2010  MantisBT Team - mantisbt-dev@lists.sourceforge.net
# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

html_page_top( 'SvnGenerateLog : Configuration' );

print_manage_menu( );
?>
<br />
<form action="<?php echo plugin_page( 'config_edit' )?>" method="post">

<?php echo form_security_field( 'plugin_generatesvnlog_config_edit' ) ?>
<table align="center" class="width75" cellspacing="1">

<tr>
	<td class="form-title" colspan="3">
		SvnGenerateLog : Configuration
	</td>
</tr>

<tr <?php echo helper_alternate_class( )?>>
	<td>
		<b><?php echo plugin_lang_get( 'config_tpl_version' )?></b><br />
		<dl>		
		<dt><small><b><?php echo plugin_lang_get( 'config_tpl_vars' );?> :</b></small><br /></dt>
		<dd><small>- {bug_list} : <?php echo plugin_lang_get( 'config_tpl_buglist' );?></small><br /></dd>
		<dd><small>- {version_name} : <?php echo plugin_lang_get( 'config_tpl_versionname' );?></small><br /></dd>
		<dd><small>- {version_description} : <?php echo plugin_lang_get( 'config_tpl_versiondescription' );?></small><br /></dd>
		</dl>
		
	</td>	
	<td class="center" colspan="2">
		<textarea name="tpl_version" rows="5" cols="70"><?php echo plugin_config_get('log_template_ver');?></textarea>
	</td>
</tr>

<tr <?php echo helper_alternate_class()?>>
	<td>
		<b><?php echo plugin_lang_get( 'config_tpl_bug' );?></b><br />
		<dl>		
		<dt><small><b><?php echo plugin_lang_get( 'config_tpl_vars' );?> :</b></small><br /></dt>
		<dd><small>- {bug_id} : <?php echo plugin_lang_get( 'config_tpl_bugid' );?></small><br /></dd>
		<dd><small>- {bug_summary} : <?php echo plugin_lang_get( 'config_tpl_bugsummary' );?></small><br /></dd>
		<dd><small>- {bug_url} : <?php echo plugin_lang_get( 'config_tpl_bugurl' );?></small><br /></dd>
		</dl>
	</td>	
	<td class="center" colspan="2">
		<textarea name="tpl_bug" rows="5" cols="70"><?php echo plugin_config_get('log_template_bug');?></textarea>
	</td>	
</tr>

<tr>
	<td class="center" colspan="3">
		<input type="submit" class="button" value="<?php echo lang_get( 'change_configuration' )?>" />
	</td>
</tr>

</table>

<form>

<?php
html_page_bottom();
