<?php
/**
* ----------------------------------------------------------------------
* 福州星科创想网络科技有限公司
* ----------------------------------------------------------------------
* COPYRIGHT © 2015-PRESENT STARSLABS.COM ALL RIGHTS RESERVED.
* ----------------------------------------------------------------------
* LICENSED: MIT [https://github.com/thankifu/oneue/blob/master/LICENSE]
* ----------------------------------------------------------------------
* AUTHOR: THANKIFU [i@thankifu.com]
* ----------------------------------------------------------------------
* RELEASED ON: 2019.11.15
* ----------------------------------------------------------------------
*/
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Upload extends Common
{
    //原生上传
    public function native(Request $request){
		$place = trim($request->upload_place);

		if($place === 'editor') {
			$path = $request->file('upload')->store('public/avatars');
			$url = Storage::url($path);
			exit(json_encode(array('uploaded'=>1, 'url'=>$url)));

		}
		
		if($_FILES['upload_file']['error'] == 4){
			exit('<script>parent.window.starUploadNativeFail("没有选择图片")</script>');
		}
		$path = $request->file('upload_file')->store('public/avatars');
		$url = Storage::url($path);
		exit('<script>parent.starUploadNativeSuccess("'.$place.'","'.$url.'")</script>');
		
	}

}
