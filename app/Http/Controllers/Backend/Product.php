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

class Product extends Common
{
    //列表
    public function index(Request $request){

		$title = trim($request->title);
		$category_id = trim($request->category_id);
		
		$where = [];
		if($title){
			$where[] = ['title', 'like', '%'.$title.'%'];
		}
		if($category_id){
			$where[] = ['category_id', '=', $category_id];
		}

		$appends = [];
		if($title){
			$appends['title'] = $title;
		}
		if($category_id){
			$appends['category_id'] = $category_id;
		}
		
		$data = Db::table('product')->where($where)->orderBy('id','desc')->pages($appends);
		//分类
		$data['categories'] = Db::table('product_category')->select(['id','name'])->cates('id');
		//规格
		$data['specifications'] = Db::table('product_specification')->lists();

		foreach ($data['lists'] as &$value) {
            list($value['specifications']) = [[]];
            foreach ($data['specifications'] as $specification) {
            	if ($specification['product_id'] === $value['id']) {
            		array_push($value['specifications'], $specification);
            	}
            }
        }
        /*echo '<pre>';
		print_r($data);
		exit();*/
		return view('backend.product.index',$data);
	}

	//添加修改
	public function add(Request $request){
		$id = (int)$request->id;
		$data['product'] = Db::table('product')->where('id',$id)->item();

		//分类
		$data['categories'] = DB::table('product_category')->select(['id','name'])->cates('id');
		//图片
		$data['pictures'] = DB::table('product_picture')->select(['id','picture','position'])->where('product_id',$id)->lists();
		//图片
		$data['specifications'] = DB::table('product_specification')->where('product_id',$id)->orderBy('position','asc')->orderBy('id','desc')->lists();

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
		$data['seo_title'] = trim($request->seo_title);
		$data['seo_description'] = trim($request->seo_description);
		$data['seo_keywords'] = trim($request->seo_keywords);
		$data['category_id'] = (int)$request->category_id;
		$data['state'] = (int)$request->state;

		$pictures = $request->pictures;
		$specifications = $request->specifications;

		/*echo '<pre>';
		print_r($pictures);
		exit();*/

		if($id){
			$data['modified'] = time();
			$result = Db::table('product')->where('id',$id)->update($data);

			if($result && $pictures){
				foreach ($pictures as $value) {
					$value['product_id'] = $id;

					//格式化图片数值，否则为空时无法插入
					$value['picture'] = trim($value['picture']);

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
					
					//格式化图片数值，否则为空时无法插入
					$value['picture'] = trim($value['picture']);

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
					
					//格式化图片数值，否则为空时无法插入
					$value['picture'] = trim($value['picture']);

					$res = Db::table('product_picture')->insertGetId($value);
				}
			}

			if($result && $specifications){
				foreach ($specifications as $value) {
					$value['product_id'] = $result;
					
					//格式化图片数值，否则为空时无法插入
					$value['picture'] = trim($value['picture']);

					$res = Db::table('product_specification')->insertGetId($value);
				}
			}
			
			$log = '编辑商品：'.$data['name'].'，ID：'.$result.'。';
		}

		//添加操作日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	//删除
	public function delete(Request $request){
		$id = (int)$request->id;
		$has = DB::table('product')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'管理员不存在');
		}
		$res = DB::table('product')->where('id',$id)->delete();
		if(!$res){
			$this->returnMessage(400,'删除失败');
		}

		//添加操作日志
		$this->log('删除商品：'.$has['name'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

	//分类列表
    public function category(Request $request){
		$name = trim($request->name);
		$state = (int)$request->state;
		
		$where = [];
		if($name){
			$where = [['name', 'like', '%'.$name.'%']];
		}
		if(isset($request->state)){
			$where = [['state', '=', $state]];
		}

		$data['parent'] = (int)$request->parent;
		$data['lists'] = DB::table('product_category')->where('parent',$data['parent'])->where($where)->orderBy('position','asc')->orderBy('id','asc')->lists();
		//返回上一级
		$data['back'] = 0;
		if($data['parent'] > 0){
			$parent = DB::table('product_category')->where('id',$data['parent'])->where($where)->item();
			$data['back'] = $parent['parent'];
		}

		return view('backend.product.category.index',$data);
	}

	//添加修改分类
	public function categoryAdd(Request $request){
		$parent = (int)$request->parent;
		$id = (int)$request->id;
		$data['parent'] = Db::table('product_category')->where('id',$parent)->item();
		$data['category'] = Db::table('product_category')->where('id',$id)->item();
		return view('backend.product.category.add',$data);
	}

	// 保存分类
	public function categorySave(Request $request){
		$id = (int)$request->id;
		$data['name'] = trim($request->name);
		$data['parent'] = (int)$request->parent;
		$data['position'] = (int)$request->position;
		$data['seo_title'] = trim($request->seo_title);
		$data['seo_keywords'] = trim($request->seo_keywords);
		$data['seo_description'] = trim($request->seo_description);
		$data['state'] = (int)$request->state;
		
		if($data['name'] == ''){
			$this->returnMessage(400,'请输入分类名称');
		}

		if($id){
			$data['modified'] = time();
			$res = Db::table('product_category')->where('id',$id)->update($data);
			$log = '编辑商品分类：'.$data['name'].'，ID：'.$id.'。';
		}else{
			$data['created'] = time();
			$res = Db::table('product_category')->insertGetId($data);
			$log = '新增商品分类：'.$data['name'].'，ID：'.$res.'。';
		}

		//添加操作日志
		$this->log($log);
		$this->returnMessage(200,'保存成功');
	}

	public function categoryDelete(Request $request){
		$id = (int)$request->id;
		$has = Db::table('product_category')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'商品分类不存在');
		}
		Db::table('product_category')->where('id',$id)->delete();

		//添加操作日志
		$this->log('删除商品分类：'.$has['name'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

	public function specificationDelete(Request $request){
		$id = (int)$request->id;
		$has = Db::table('product_specification')->where('id',$id)->item();
		if(!$has){
			$this->returnMessage(400,'规格不存在');
		}
		Db::table('product_specification')->where('id',$id)->delete();

		//添加操作日志
		$this->log('删除商品规格：'.$has['name'].'，ID：'.$id.'。');
		$this->returnMessage(200,'删除成功');
	}

}
