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
    //图片上传
    public function native(Request $request){
    	if($_FILES['upload_file']['error'] == 4){
			exit('<script>parent.window.starUploadNativeFail("没有选择图片")</script>');
		}
		//print_r('11');
		$place = trim($request->upload_place);
		$path = $request->file('upload_file')->store('public/avatars');
		$url = Storage::url($path);
		//exit($path);

		exit('<script>parent.starUploadNativeSuccess("'.$place.'","'.$url.'")</script>');
	}

}
