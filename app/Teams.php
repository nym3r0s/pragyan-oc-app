<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model {

	protected $table = 'teams';
	protected $primaryKey = 'team_id';
	public $timestamps = false;

}
