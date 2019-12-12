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

class Order extends Common
{
    //列表
    public function index(Request $request){

		$no = trim($request->no);
		$category_id = $request->category_id;
		$brand_id = $request->brand_id;
		$project_id = $request->project_id;
		
		$where = [];
		if($no){
			$where[] = ['no', 'like', '%'.$no.'%'];
		}
		if(isset($category_id)){
			$where[] = ['category_id', '=', $category_id];
		}
		if(isset($brand_id)){
			$where[] = ['brand_id', '=', $brand_id];
		}
		if(isset($project_id)){
			$where[] = ['project_id', '=', $project_id];
		}

		$appends = [];
		if($no){
			$appends['no'] = $no;
		}
		if(isset($category_id)){
			$appends['category_id'] = $category_id;
		}
		if(isset($brand_id)){
			$appends['brand_id'] = $brand_id;
		}
		if(isset($project_id)){
			$appends['project_id'] = $project_id;
		}
		
		$data = Db::table('order')->where($where)->orderBy('id','desc')->pages($appends);

		//分类
		$data['users'] = Db::table('user')->select(['id','name'])->cates('id');
		//品牌
		$data['brands'] = Db::table('brand')->select(['id','name'])->where('state', 1)->cates('id');
		//项目
		$data['projects'] = Db::table('project')->select(['id','name'])->where('state', 1)->cates('id');
		//规格
		$data['specifications'] = Db::table('product_specification')->lists();

		
        /*echo '<pre>';
		print_r($data);
		exit();*/

		

		return view('backend.order.index',$data);
	}

	//添加修改
	public function add(Request $request){
		$id = (int)$request->id;
		$data['product'] = Db::table('product')->where(array('id'=>$id))->item();

		
		//图片
		$data['pictures'] = DB::table('product_picture')->select(['id','picture','position'])->where('product_id',$id)->lists();
		//规格
		$data['specifications'] = DB::table('product_specification')->where('product_id',$id)->orderBy('position','asc')->orderBy('id','desc')->lists();

		//分类
		$data['categories'] = DB::table('product_category')->select(['id','name'])->cates('id');
		//品牌
		$data['brands'] = Db::table('brand')->select(['id','name'])->where('state', 1)->cates('id');
		//用户
		$data['users'] = DB::table('user')->select(['id','name'])->cates('id');
		//项目
		$data['projects'] = Db::table('project')->select(['id','name'])->where('state', 1)->cates('id');

		return view('backend.product.add',$data);
	}

	//保存
	public function save(Request $request){
		$id = (int)$request->id;
		$data['name'] = trim($request->name);
		$data['description'] = trim($request->description);
		$data['sku'] = (int)$request->sku;
		$data['market'] = trim($request->market);
		$data['selling'] = trim($request->selling);
		$data['cost'] = trim($request->cost);
		$data['picture'] = trim($request->picture);
		$data['quantity'] = (int)$request->quantity;
		$data['volume'] = (int)$request->volume;
		$data['virtual'] = (int)$request->virtual;
		$data['visit'] = (int)$request->visit;
		$data['label'] = trim($request->label);
		$data['file'] = trim($request->file);
		$data['category_id'] = (int)$request->category_id;
		$data['brand_id'] = (int)$request->brand_id;
		$data['user_id'] = (int)$request->user_id;
		$data['project_id'] = (int)$request->project_id;
		$data['seo_title'] = trim($request->seo_title);
		$data['seo_description'] = trim($request->seo_description);
		$data['seo_keywords'] = trim($request->seo_keywords);
		$data['state'] = (int)$request->state;

		$pictures = $request->pictures;
		$specifications = $request->specifications;

		/*echo '<pre>';
		print_r($pictures);
		exit();*/

		if($id){
			$data['modified'] = time();
			$result = Db::table('product')->where(array('id'=>$id))->update($data);

			if($result && $pictures){
				foreach ($pictures as $value) {
					$value['product_id'] = $id;

					//判断是否存在
					$has = DB::table('product_picture')->where('id',$value['id'])->where('product_id',$id)->item();
					if($has){
						Db::table('product_picture')->where('id',$value['id'])->where('product_id',$id)->update($value);
					}else{
						Db::table('product_picture')->insertGetId($value);
					}
				}
			}

			if($result && $specifications){
				foreach ($specifications as $value) {
					$value['product_id'] = $id;

					//判断是否存在
					$has = DB::table('product_specification')->where('id',$value['id'])->where('product_id',$id)->item();
					if($has){
						Db::table('product_specification')->where('id',$value['id'])->where('product_id',$id)->update($value);
					}else{
						Db::table('product_specification')->insertGetId($value);
					}
				}
			}

			$log = '编辑商品：'.$data['name'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$result = Db::table('product')->insertGetId($data);

			if($result && $pictures){
				foreach ($pictures as $value) {
					$value['product_id'] = $result;
					$res = Db::table('product_picture')->insertGetId($value);
				}
			}

			if($result && $specifications){
				foreach ($specifications as $value) {
					$value['product_id'] = $result;
					$res = Db::table('product_specification')->insertGetId($value);
				}
			}
			
			$log = '编辑商品：'.$data['name'].'，ID：'.$result.'。';
		}

		//添加操作日志
		//$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//删除
	public function delete(Request $request){
		$id = (int)$request->id;
		$is = DB::table('product')->where(array('id'=>$id))->item();
		if(!$is){
			$this->returnMessage(400,'商品不存在');
		}
		$res = DB::table('product')->where(array('id'=>$id))->delete();
		if(!$res){
			$this->returnMessage(400,'删除失败');
		}

		//添加操作日志
		//$this->log('删除商品：'.$is['name'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}


	// 保存分类
	public function product(Request $request){
		$id = (int)$request->id;

		if($id){
			$result = Db::table('order_product')->where('order_id', $id)->lists();
		}else{
			$this->returnMessage(400,'查询失败');
		}

		//添加操作日志
		//$this->log($log);
		$this->returnMessage(200,'查询成功',$result);
	}

}
