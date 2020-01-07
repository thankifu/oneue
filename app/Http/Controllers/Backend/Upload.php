<?php
/**
 * ----------------------------------------------------------------------
 * ONEUE - A SIMPLE E-COMMERCE SYSTEM
 * ----------------------------------------------------------------------
 * AUTHOR: THANKIFU [i@thankifu.com]
 * ----------------------------------------------------------------------
 * RELEASED ON: 2019.11.15
 * ----------------------------------------------------------------------
 * LICENSED: MIT [https://github.com/thankifu/oneue/blob/master/LICENSE]
 * ----------------------------------------------------------------------
**/

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class Upload extends Common
{
    //原生上传
    public function index(Request $request){
		$place = trim($request->upload_place);

		if($place === 'editor') {
			$data = $this->check($request->file('upload'));

			//验证文件
			if($data['code'] !== 200){
				exit(json_encode(array('uploaded'=>0, 'error'=>array('message'=>$data['msg']))));
			}

			$path = $request->file('upload')->store('public/uploads');
			$url = Storage::url($path);
			exit(json_encode(array('uploaded'=>1, 'url'=>$url)));

		}
		
		if($_FILES['upload_file']['error'] == 4){
			exit('<script>parent.window.starUploadFail("没有选择图片")</script>');
		}

		//验证文件
		$data = $this->check($request->file('upload_file'));
		if($data['code'] !== 200){
			exit('<script>parent.window.starUploadFail("'.$data['msg'].'")</script>');
		}

		$path = $request->file('upload_file')->store('public/uploads');
		$url = Storage::url($path);
		exit('<script>parent.starUploadSuccess("'.$place.'","'.$url.'")</script>');
		
	}

	private function check($file){
    	//获取附件配置
    	$data = Db::table('admin_setting')->where(array('key'=>'annex'))->item();
		$data['value'] && $data['value'] = json_decode($data['value'],true);
		
		//文件后缀
		$type = '.'.$file->getClientOriginalExtension();
		if(isset($data['value']['type']) && !in_array($type,$data['value']['type'])){
			return array('code'=>400,'msg'=>'上传失败，上传文件的类型不在您附件设置中设定的范围');
		}

		//文件大小
		$size = $file->getClientSize();
		if(isset($data['value']['size']) && $size/1024 > $data['value']['size']*1024){
			return array('code'=>400,'msg'=>'上传失败，上传文件已超出您在附件设置中限制的大小');
		}

		return array('code'=>200,'msg'=>'验证成功');
	}

}
