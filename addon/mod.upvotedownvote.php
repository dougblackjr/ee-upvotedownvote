<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upvotedownvote
{

	public $return_data = '';

    public function __construct()
	{

		// Global
		$this->theme_url = URL_THIRD_THEMES."upvotedownvote/";

		$entry = filter_var(ee()->TMPL->fetch_param('entry'), FILTER_SANITIZE_STRING);

		$display = filter_var(ee()->TMPL->fetch_param('display'), FILTER_SANITIZE_STRING);

		if (!is_null($entry) && !empty($entry)) {
			// Get data from SQL for that entry
			ee()->db->select('exp_upvotedownvote.id, exp_upvotedownvote.entry_id, exp_upvotedownvote.upvotes, exp_upvotedownvote.downvotes')
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
			
		}

		return NULL;

	}

	/**
	 * UPVOTE: Action to upvote an entry
	 * @return ajax call with upvoted entry
	 */
	public function upvote()
	{

	}

	/**
	 * DOWNVOTE: Action to downvote an entry
	 * @return ajax call with downvoted entry
	 */
	public function downvote()
	{

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
		$thumbUpPath = $this->theme_url.'img/thumbsup.svg';
		$thumbDownPath = $this->theme_url.'img/thumbsdown.svg';

		// Votes
		$code = <<< END
<div class="upvotedownvote-block">
	<ul>
		<li class="count-li">$count</li>
		<li class="thumbup-li"><img src="$thumbUpPath" /></li>
		<li class="thumbdown-li"><img src="$thumbDownPath" /></li>
	</ul>
</div>
END;

		// exit(print_r($actions));
		// return json_encode($query);
		return $code;

	}

}