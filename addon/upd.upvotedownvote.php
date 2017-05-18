<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Upvotedownvote_upd {

	var $version = '1.0.0';

	function install()
	{

		// Database setup
		ee()->load->dbforge();

		// Create channel_fields pivot tables (2)
		ee()->dbforge->drop_table('json_ld_templates');

		$fields = array(
			'entry_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE			
			),
			'upvotes' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE
			),
			'downvotes' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE
			)
		);

		ee()->dbforge->add_field('id');
		ee()->dbforge->add_field($fields);
		ee()->dbforge->create_table('upvotedownvote');

		unset($fields);

		// APP INFO
		$data = array(
		 'module_name' => 'Upvotedownvote' ,
		 'module_version' => $this->version,
		 'has_cp_backend' => 'y'
		);

		ee()->db->insert('modules', $data);
		ee()->load->library('layout');

		return true;

	}

	function update($current = '')
	{
		if (version_compare($current, '2.0', '='))
		{
				return FALSE;
		}

		if (version_compare($current, '2.0', '<'))
		{
				// Do your update code here
		}

		return TRUE;
	}

	function uninstall() {
		ee()->load->dbforge();

		ee()->dbforge->drop_table('upvotedownvote');

		ee()->db->where('module_name', 'Upvotedownvote');
		ee()->db->delete('modules');

		ee()->db->where('class', 'Upvotedownvote');
		ee()->db->delete('actions');

		ee()->load->library('layout');

		return true;
	}
}

/* End of file upd.upvotedownvote.php */