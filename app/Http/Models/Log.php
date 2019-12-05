<?php
namespace app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Request;

class Log extends Model
{
    public function backend($data){
    	if(!$data['admin_id'] || !$data['abstract']){
    		return;
    	}
    	$data['created'] = time();
    	$data['ip'] = Request::getClientIp();
    	Db::table('admin_log')->insertGetId($data);
    }
}
