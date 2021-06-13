<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Models\{Category, Product};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller{
    
    public function index(Request $request) {

		$product = Product::select(['id', 'name', 'description', 'status'])->get();

		return view('product.index', compact('product'));
    }

    public function create() {
		$product = new Product;

        $category = Category::select('id', 'name')->where('status', 'ACTIVE')->pluck('name', 'id')->all();

		return view('product.create', compact('product', 'category'));
	}

	public function store(Request $request) {				
		$postArr = $request->input();

		$this->validate($request, [
			'name' => ['required', Rule::unique('product')->where(function ($query) {
				return $query->where('status', 'ACTIVE');
			})],
			'description' => ['required']
		], [
			'name.required' => 'Product Name is required',
			'name.unique' => 'Product Name is already exists',
			'description.required' => 'Product Name is required',
		]);

		DB::beginTransaction();
		try {
			$postArr['created_by'] = Auth::user()->id;
			
			$itemsku = Product::create($postArr);
			if ($itemsku->exists) {
				DB::commit();
				return redirect()->route('product.index')
					->with('success', 'product created successfully');
			} else {
				$message = 'Product can\'t added';
			}
		} catch (Illuminate\Database\QueryException $e) {
			DB::rollback();
			$message = $e->getMessage();
		} catch (\Exception $e) {
			DB::rollback();
			$message = $e->getMessage();
		} catch (\Throwable $th) {
			DB::rollback();
			$message = $th->getMessage();
		}

		return redirect()->back()
			->with('error', $message);
	}

	public function edit($id) {

		try {
			$product = Product::findOrFail($id);
            $category = Category::select('id', 'name')->where('status', 'ACTIVE')->pluck('name', 'id')->all();

			return view('product.edit', compact('product', 'category'));

		} catch (Illuminate\Database\QueryException $e) {
			$message = $e->getMessage();
		} catch (\Exception $e) {
			$message = $e->getMessage();
		} catch (\Throwable $th) {
			$message = $th->getMessage();
		}
		return redirect()->back()
			->with('error', $message);
	}

	public function update(Request $request, $id) {
		$this->validate($request, [
			'name' => ['required', Rule::unique('product')->where(function ($query) use ($id) {
				return $query->where('status', 'ACTIVE')->where("id", "<>", $id);
			})],
			'description' => ['required']
		], [
			'name.required' => 'Product is required',
			'name.unique' => 'Product is already exists',
            'description.required' => 'Product description is required'
		]);

		DB::beginTransaction();
		try {
			$postArr = $request->all();
			$product = Product::find($id);
            $postArr['updated_by'] = Auth::user()->id;
			if ($product->update($postArr)) {
				DB::commit();
				return redirect()->route('product.index')
					->with('success', 'Product update successfully');
			} else {
				$message = 'product can\'t update';
			}
		} catch (Illuminate\Database\QueryException $e) {
			DB::rollback();
			$message = $e->getMessage();
		} catch (\Exception $e) {
			DB::rollback();
			$message = $e->getMessage();
		} catch (\Throwable $th) {
			DB::rollback();
			$message = $th->getMessage();
		}

		return redirect()->back()
			->with('error', $message);
	}

	public function destroy($id) {
		DB::beginTransaction();
		try {
			$item = Product::findOrFail($id);
            $item->deleted_by = Auth::user()->id;
			$item->status = 'INACTIVE';
			$item->save();
            
			$res = $item->delete();
			if ($res == true) {
				DB::commit();
				return redirect()->route('product.index')
					->with('success', 'Product deleted successfully');
			} else {
				$message = "Unable to delete product";
			}
		} catch (Illuminate\Database\QueryException $e) {
			DB::rollback();
			$message = $e->getMessage();
		} catch (\Exception $e) {
			DB::rollback();
			$message = $e->getMessage();
		} catch (\Throwable $th) {
			DB::rollback();
			$message = $th->getMessage();
		}

		return redirect()->back()
			->with('error', $message);
	}
}
