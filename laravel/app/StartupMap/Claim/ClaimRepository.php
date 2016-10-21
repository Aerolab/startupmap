<?php namespace StartupMap\Claim;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
class ClaimRepository implements ClaimInterface {

	/**
	 * @param $flag mixed
	 * @param $orderBy string
	 * @param $order string
	 * @since 0.2
	 * @return mixed
	 */
	public function all($flag = false, $orderBy = 'created_at', $order = 'desc'){
		$claims = \Claim::orderBy($orderBy, $order);

		if($flag)
			$claims->where('flag', $flag);

		return $claims->get();
	}

	/**
	 * @param $id integer
	 * @since 0.2
	 * @return mixed
	 */
	public function find($id){
		return \Claim::find($id);
	}

	/**
	 * @param $claim Claim
	 * @since 0.2
	 * @return boolean
	 */
	public function accept(\Claim $claim){
		if($claim->flag == 'pending'){
			$claim->flag = 'accepted';
			$claim->save();

			$startup = \Startup::find($claim->startup_id);
			$startup->user_id = $claim->user->id;
			$startup->save();

			$user = $claim->user;

			\Mail::send('emails.claim_accepted', array('name' => $user->profile->name, 'startup' => $claim->startup->name), function($message) use($user){
				$message->to($user->email, $user->profile->full_name())
						->subject('Tu petición ha sido aceptada! StartupMap.la');
			});

			return true;
		}

		return false;
	}

	/**
	 * @param $claim Claim
	 * @since 0.2
	 * @return mixed
	 */
	public function deny(\Claim $claim){
		if($claim->flag == 'pending'){
			$claim->flag = 'denied';
			$claim->save();

			$user = $claim->user;

			\Mail::send('emails.claim_denied', array('name' => $user->profile->name, 'startup' => $claim->startup->name), function($message) use($user){
				$message->to($user->email, $user->profile->full_name())
						->subject('Tu petición ha sido denegada :( StartupMap.la');
			});

			return true;
		}

		return false;
	}

}