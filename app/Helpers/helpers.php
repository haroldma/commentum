<?php

/**
 * Check if a string ends with a specific character.
 *
 * @param  	string $haystack 	The string to check
 * @param  	string $needle   	The character that $haystack should end with
 * @return 	boolean
 */
function stringEndsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}

/**
 * Determins the amount of momentum that should be added.
 *
 * @param  	integer
 * @return 	float
 */
function calculateMomentum($difference)
{
	switch ($difference) {
		case ($difference < 60):
			$momentumAdd = 1;
			break;

		case ($difference > 59 && $difference < 120):
			$momentumAdd = 0.9;
			break;

		case ($difference > 119 && $difference < 180):
			$momentumAdd = 0.75;
			break;

		case ($difference > 179 && $difference < 300):
			$momentumAdd = 0.6;
			break;

		case ($difference > 299 && $difference < 600):
			$momentumAdd = 0.5;
			break;

		case ($difference > 599 && $difference < 900):
			$momentumAdd = 0.35;
			break;

		case ($difference > 899 && $difference < 1800):
			$momentumAdd = 0.25;
			break;

		case ($difference > 1799 && $difference < 3600):
			$momentumAdd = 0.1;
			break;

		default:
			$momentumAdd = 0.05;
			break;
	}

	return $momentumAdd * 0.69;
}

/**
 * Send a message (notification)
 *
 * @param  	integer 	$to
 * @param  	integer 	$from
 * @param  	integer 	$threadId
 * @param  	integer 	$commentId
 * @param  	string 		$message
 * @return 	boolean
 */
function sendMessage($to, $from, $threadId, $commentId, $tagId, $message, $type)
{
	$m             = new App\Models\Message;
	$m->to_id      = $to;
	$m->from_id    = $from;
	$m->thread_id  = $threadId;
	$m->comment_id = $commentId;
	$m->tag_id     = $tagId;
	$m->message    = $message;
	$m->type       = $type;

	$m->save();
}

/**
 * Make a user mod of a tag.
 *
 * @param  integer 	$tagId
 * @param  integer 	$userId
 * @return boolean
 */
function makeModOfTag($tagId, $userId)
{
	$tagmod          = new App\Models\TagMod;
	$tagmod->tag_id  = $tagId;
	$tagmod->user_id = $userId;

	$tagmod->save();
}

/**
 * Check if the logged in user is a mod of a tag.
 *
 * @param  	integer 	$tagId
 * @return 	boolean
 */
function isModOfTag($tagId)
{
	return App\Models\TagMod::where('tag_id', $tagId)->where('user_id', Auth::id())->first();
}




