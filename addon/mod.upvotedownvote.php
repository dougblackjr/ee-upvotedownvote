<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upvotedownvote
{

	public $return_data = '';

    public function __construct()
	{

		$entry = ee()->TMPL->fetch_param('entry', NULL);

		$display = ee()->TMPL->fetch_param('display', NULL);

		if (!is_null($entry)) {
			// Get data from SQL for that entry
			ee()->db->select('exp_upvotedownvote.id, exp_upvotedownvote.entry_id, exp_upvotedownvote.upvotes, exp_upvotedownvote.downvotes')
				->from('exp_upvotedownvote');

			$data = ee()->db->get()->result_array();

			// If it's empty
				// ASsign 0s
			// Else
				// Get them
			// $upvote

			// Return view
			exit(print_r($data));

			return $entry;
		}

		return NULL;

	}

}