<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionalSuggestion extends Model{
	protected $table = 'functional_suggestions';
	protected $fillable = ['name', 'description', 'creator_id', 'votes', 'user_ids'];

	public function upvote($userID){
		$votesUserIDs = json_decode($this->user_ids);
		$votesUserIDs[] = $userID;
		$votesUserIDs = array_unique($votesUserIDs);

		$votes = count($votesUserIDs);

		$this->update([
			'votes'    => $votes,
			'user_ids' => json_encode($votesUserIDs),
		]);
	}

	public function ifHeVoted(User $user){
		$votesUserIDs = json_decode($this->user_ids);

		if (in_array($user->id, $votesUserIDs)){
			return true;
		}

		return false;
	}
}