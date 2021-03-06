<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upvotedownvote
{

	public $return_data = '';
	private $_session_data= array();

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
			ee()->db->select('exp_upvotedownvote.id, exp_upvotedownvote.entry_id, exp_upvotedownvote.vote')
				->where('entry_id', $entry)
				->from('exp_upvotedownvote');

			$data = ee()->db->get()->result_array();

			// If it's empty
			if(empty($data)) {
				$output = array(
					'entry_id' => $entry,
					'upvotes' => 0,
					'downvotes' => 0,
					'totalvotes' => 0
				);

			} else {

				// Set initial variables
				$upvotes = 0;
				$downvotes = 0;
				$totalvotes = 0;

				foreach ($data as $entry_data) {
					
					// Add total votes
					$totalvotes++;

					// Count up and down votes
					$entry_data['vote'] > 0 ? $upvotes++ : $downvotes++;

				}

				// Set output
				$output = array(
					'entry_id' => $entry,
					'upvotes' => $upvotes,
					'downvotes' => $downvotes,
					'totalvotes' => $totalvotes
				);

			}

			// Get cookie data, if person has voted
			$output['cookie'] = isset($_COOKIE['uvdv_'.$entry]) ? TRUE : FALSE;
			$output['cookie_value'] = isset($_COOKIE['uvdv_'.$entry]) ? $_COOKIE['uvdv_'.$entry] : FALSE;

			// Return it
			$this->return_data = ee()->TMPL->parse_variables_row(ee()->TMPL->tagdata, $this->build($output));
			return ee()->TMPL->parse_variables_row(ee()->TMPL->tagdata, $this->build($output));
			
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
		$entry = ee()->input->get('id');

		// Write upvote to DB
		$data = [
			'entry_id' => $entry,
			'vote' => 1
		];

		ee()->db->insert('exp_upvotedownvote', $data);

		// Set cookie
		setcookie('uvdv_'.$entry, 'up');
		
		// Return success
		$output = array('up', 'success');
		ee()->output->send_ajax_response($output);

	}

	/**
	 * DOWNVOTE: Action to downvote an entry
	 * @return ajax call with downvoted entry
	 */
	public function downvote()
	{
		// Get entry id
		$entry = ee()->input->get('id');

		// Write downvote to DB
		$data = [
			'entry_id' => $entry,
			'vote' => -1
		];

		ee()->db->insert('exp_upvotedownvote', $data);

		// Set cookie
		setcookie('uvdv_'.$entry, 'down');
		
		// Return success
		$output = array('down', 'success');
		ee()->output->send_ajax_response($output);

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
		
		$variables = array(
			'score' => $data['upvotes'] - $data['downvotes'],
			'count' => $data['totalvotes'],
			'upvotes' => $data['upvotes'],
			'downvotes' => $data['downvotes'],
			'up_action' => $actions['upvote'],
			'down_action' => $actions['downvote'],
			'cookie' => $data['cookie'],
			'cookie_value' => $data['cookie_value']
		);

		return $variables;

	}

}