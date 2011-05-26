<?php

require_once( config_get( 'class_path' ) . 'MantisPlugin.class.php' );

class SvnGenerateLogPlugin extends MantisPlugin  {
	/**
	 *  A method that populates the plugin information and minimum requirements.
	 */
	function register() {
		$this->name = plugin_lang_get( 'pluginname' );
		$this->description = plugin_lang_get( 'plugindescription' );
		$this->version = '1.0';
		$this->requires = array(
			'MantisCore' => '1.2.0',
		);
		$this->page = 'config';
		$this->author = 'Johan Guilbaud';
		$this->contact = 'support@lapinkiller.fr';
		$this->url = 'http://www.lapinkiller.fr';
	}
	
	/**
	 * Default plugin configuration.
	 */
	function config() {
		return array(
			"log_template_ver" 	=> "=== {version_name} === \n{version_description}\n{bug_list}\n\n",
			"log_template_bug" 	=> "- {bug_summary} \n\t => mantis#{bug_id}\n"
		);
	}

	
	
	function schema(){
		$schema = array();		
		return $schema;

	}

	function hooks() {
		event_declare('EVENT_PLUGIN_SVNGENERATELOG', EVENT_EXECUTE);
		$hooks = array(
			'EVENT_PLUGIN_SVNGENERATELOG' => 'generateLog'	
		);

		
		
		return $hooks;
	}

	
	function init(){

		return true;
	}
	
	
	function uninstall(){		

		$custom_group_actions = config_get('custom_group_actions');
		$key = array_search($this->getAction(),$custom_group_actions);
		if($key !== false){
			unset($custom_group_actions[$key]);
			$custom_group_actions = array_shift($custom_group_actions);
			if($custom_group_actions == null){
				$custom_group_actions = array();
			}
			config_set('custom_group_actions', $custom_group_actions);
		}
		return true;
	}
	
	function install(){
		$custom_group_actions = config_get('custom_group_actions');
		$custom_group_actions[] = $this->getAction();
		config_set('custom_group_actions', $custom_group_actions);
		
		return true;
	}
	
	

	function getAction(){
		return array(	'action' => 'generatelogsvn',
						'label' => 'plugin_SvnGenerateLog_actiongroup_svngeneratelog_label',
						'form_page' => 'plugins/'.$this->basename.'/pages/action_group_svngeneratelog.php');
	}

	
	/****************************/
	
	/**
	 *
	 * @param string $p_name
	 * @param array<string> $p_params
	 */
	function generateLog($p_name, $p_params = array()){
		$bug_arr = $p_params;
		$bug_list = "(".implode(',', $bug_arr).")";

		$mantis_bug_table = db_get_table('mantis_bug_table');
		$mantis_version_table = db_get_table('mantis_project_version_table');
		
		$query = "	SELECT bt.id,bt.summary,bt.fixed_in_version as version,vt.description 
					FROM $mantis_bug_table as bt 
					LEFT JOIN $mantis_version_table as vt 
						ON vt.project_id=bt.project_id 
						AND vt.version=bt.fixed_in_version 
					WHERE bt.id IN $bug_list
					ORDER BY bt.project_id,version,bt.id";
		
		$result = db_query_bound($query);
		
		$versions = array();
		
		while($row = db_fetch_array($result) ){
			
			$versions[$row['version']]['version_description'] = $row['description'];
			$versions[$row['version']]['bugs'][] = array( 	"id" 		=>$row['id'],
															"summary" 	=>$row['summary'],);
		}

		$t_generated_log = ""; 
		
		$t_tpl_version = plugin_config_get('log_template_ver');
		$t_tpl_bug = plugin_config_get('log_template_bug');
		foreach($versions as $verName => $verData){
			
			$current_version = $t_tpl_version;
			
			$current_version = str_replace('{version_name}', $verName, $current_version);
			$current_version = str_replace('{version_description}', $verData['description'], $current_version);
			
			$bugs = "";			
			foreach($verData['bugs'] as $bug){
				$current_bug = $t_tpl_bug;
				$current_bug = str_replace('{bug_id}', $bug['id'], $current_bug);
				$current_bug = str_replace('{bug_summary}', $bug['summary'], $current_bug);
				$current_bug = str_replace('{bug_url}',  config_get_global( 'path' ).string_get_bug_view_url($bug['id']), $current_bug);
				$bugs .= $current_bug;
			}
			$current_version = str_replace('{bug_list}', $bugs, $current_version);
			
			$t_generated_log .= $current_version;
		}
		
		
		require_once 'pages/generateLog.php';
	}

}