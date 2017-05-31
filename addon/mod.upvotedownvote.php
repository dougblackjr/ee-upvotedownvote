<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upvotedownvote
{

	public $return_data = '';

    public function __construct()
	{

		// Global
		$this->theme_url = URL_THIRD_THEMES."upvotedownvote/";

	}

	public function output()
	{

		$entry = filter_var(ee()->TMPL->fetch_param('entry'), FILTER_SANITIZE_STRING);

		$display = filter_var(ee()->TMPL->fetch_param('display'), FILTER_SANITIZE_STRING);

		if (!is_null($entry) && !empty($entry)) {
			// Get data from SQL for that entry
			ee()->db->select('exp_upvotedownvote.id, exp_upvotedownvote.entry_id, exp_upvotedownvote.upvotes, exp_upvotedownvote.downvotes')
				->where('entry_id', $entry)
				->from('exp_upvotedownvote');

			$data = ee()->db->get()->result_array();

			// If it's empty
			if(empty($data)) {
				$data[0] = array(
					'entry_id' => $entry,
					'upvotes' => 0,
					'downvotes' => 0
				);

				ee()->db->insert('exp_upvotedownvote', $data[0]);
			}

			$this->return_data = $this->build($data[0]);
			return $this->build($data[0]);
			
		}

		return NULL;
	}

	/**
	 * UPVOTE: Action to upvote an entry
	 * @return ajax call with upvoted entry
	 */
	public function upvote()
	{
		// Get entry id
		$entry = ee()->input->post('id');
		// Get it from database
		ee()->db->select('exp_upvotedownvote.id, exp_upvotedownvote.entry_id, exp_upvotedownvote.upvotes, exp_upvotedownvote.downvotes')
			->where('entry_id', $entry)
			->from('exp_upvotedownvote');

		$data = ee()->db->get()->result_array();
		// Incremement by 1
		$data['upvotes']++;
		// Write it
		
		ee()->db->update('exp_upvotedownvote', $data, ['id' => $data['id']]);
		
		// Return success
		return 'success';

	}

	/**
	 * DOWNVOTE: Action to downvote an entry
	 * @return ajax call with downvoted entry
	 */
	public function downvote()
	{
		// Get entry id
		$entry = ee()->input->post('id');
		// Get it from database
		ee()->db->select('exp_upvotedownvote.id, exp_upvotedownvote.entry_id, exp_upvotedownvote.upvotes, exp_upvotedownvote.downvotes')
			->where('entry_id', $entry)
			->from('exp_upvotedownvote');

		$data = ee()->db->get()->result_array();
		// Incremement by 1
		$data['downvotes']++;
		// Write it
		
		ee()->db->update('exp_upvotedownvote', $data, ['id' => $data['id']]);
		
		// Return success
		return 'success';

	}

	/**
	 * BUILD: Builds form with actions
	 * @return [type] [description]
	 */
	private function build($data)
	{

		ee()->db
			->select('exp_actions.action_id,exp_actions.class,exp_actions.method')
			->where('class','Upvotedownvote')
			->from('exp_actions');
		$query = ee()->db->get()->result_array();

		if(!empty($query)) {
			$actions = NULL;

			foreach ($query as $action) {

				switch ($action['method']) {
					case 'upvote':
						$actions['upvote'] = $action['action_id'];
						break;

					case 'downvote':
						$actions['downvote'] = $action['action_id'];
						break;				

					default:
						$actions['wtf'][] = $action;
						break;
				}

			}
		}

		// Do the math
		$count = $data['upvotes'] - $data['downvotes'];
		$total = $data['upvotes'] + $data['downvotes'];
		$up = $actions['upvote'];
		$down = $actions['downvote'];
		$cssPath = $this->theme_url.'css/uvdv.css';
		$css = file_get_contents($cssPath);

		// Votes
		$code = <<< END
<style>$css</style>
<div class="upvotedownvote-block">
	<div class="count">$count</div>
	<div class="mini">($total votes)</div>
	<div class="thumbs">
		<a href="?ACT=$up"><i id="thumb-up" class="thumb fa fa-thumbs-up"></i></a>
		<a href="?ACT=$down"><i id="thumb-down" class="thumb fa fa-thumbs-down"></i></a>
	</div>
</div>
END;

		// Return the code
		return $code;

	}

}