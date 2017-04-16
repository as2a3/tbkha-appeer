<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Input;

class CategoryController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->categoryRepository->pushCriteria(new RequestCriteria($request));
        $categories = $this->categoryRepository->all();

        return view('categories.index')
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->all();
        return view('categories.create')->with('categories', $categories);
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();
        if (Input::file('image')) {
					$input['image']=Input::file('image')->getClientOriginalName();
	        $request->file('image')->move(public_path().'/CategoriesImages/', $input['image']);
				}
        if ($request->input('parent_name')!=0) {
          $input['parent'] = $request->input('parent_name');
        }
        $category = $this->categoryRepository->create($input);
        Flash::success('Category saved successfully.');
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }
        $parent_category = $this->categoryRepository->findWithoutFail($category->parent);

        return view('categories.show')->with('category', $category)->with('parent_category', $parent_category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);
        $categories = $this->categoryRepository->all();
        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }
        $parent_category = $this->categoryRepository->findWithoutFail($category->parent);
        return view('categories.edit')->with('category', $category)
                ->with('categories', $categories)->with('parent_category', $parent_category);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);
        $input  = $request->all();

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }
        if (Input::file('image')) {
          $category['image']=Input::file('image')->getClientOriginalName();
          $img=$request->file('image')->move(public_path().'/CategoriesImages/', $category['image']);
        }
        $input['image'] = $category['image'];
        if ($request->input('parent_name')!=0) {
          $input['parent'] = $request->input('parent_name');
        }elseif ($request->input('parent_name')==0) {
          $input['parent'] = null;
        }
        else {
          $input['parent'] = $category->parent;
        }
        $category = $this->categoryRepository->update($input, $id);
        Flash::success('Category updated successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $this->categoryRepository->delete($id);

        Flash::success('Category deleted successfully.');

        return redirect(route('categories.index'));
    }
}
