<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;

class CategoryController extends Controller{
    
    public function index(Request $request) {

		if ($request->ajax()) {
			echo json_encode($this->itemTableData($request));
			exit;
		}

		return view('category.index');
    }

    public function create() {
		$category = new Category;

		return view('category.create', compact('category'));
	}

	public function store(Request $request) {

		$this->validate($request, [
			'name' => ['required', Rule::unique('category')->where(function ($query) {
				return $query->where('status', 'ACTIVE');
			})],
			'type' => ['sometimes']
		], [
			'name.required' => 'Category Name is required',
			'name.unique' => 'Category Name is already exists'
		]);

		DB::beginTransaction();
		try {
			$postArr = $request->input();

			$postArr = Arr::except($postArr, array('_token'));

			$postArr['created_by'] = Auth::user()->id;
			$itemsku = Category::create($postArr);

			if ($itemsku->exists) {
				DB::commit();
				return redirect()->route('category.index')
					->with('success', 'Category created successfully');
			} else {
				$message = 'Category can\'t added';
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
			$category = Category::findOrFail($id);
			return view('category.edit', compact('category'));

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
			'name' => ['required', Rule::unique('category')->where(function ($query) use ($id) {
				return $query->where('status', 'ACTIVE')->where("id", "<>", $id);
			})],
			'status' => ['required']
		], [
			'name.required' => 'Category is required',
			'name.unique' => 'Category is already exists'
		]);

		DB::beginTransaction();
		try {
			$postArr = $request->all();
			$itemsku = Category::find($id);
            $postArr['updated_by'] = Auth::user()->id;            
			if ($itemsku->update($postArr)) {
				DB::commit();
				return redirect()->route('category.index')
					->with('success', 'Category update successfully');
			} else {
				$message = 'Category can\'t update';
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
			$item = Category::findOrFail($id);
            $item->deleted_by = Auth::user()->id;
			$item->status = 'INACTIVE';
			$item->save();
            
			$res = $item->delete();
			if ($res == true) {
				DB::commit();
				return redirect()->route('category.index')
					->with('success', 'Category deleted successfully');
			} else {
				$message = "Unable to delete category";
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
