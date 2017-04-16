<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoryAPIRequest;
use App\Http\Requests\API\UpdateCategoryAPIRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CategoryController
 * @package App\Http\Controllers\API
 */

class CategoryAPIController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     * GET|HEAD /categories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->categoryRepository->pushCriteria(new RequestCriteria($request));
        $this->categoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $categories     = $this->categoryRepository->all();
        $all_categories = [];
        $children       = [];
        foreach ($categories as $key => $category) {
          $category->image['image'] = 'CategoriesImages/'.$category->image['image'];
          $category->recipe_count   = count($category->recipes);
          if ($category->parent_category == null) {
            $subcategories = $category->subcategories;
            if (!($subcategories->isEmpty())) {
              foreach ($subcategories as $key => $child) {
                $child->image['image'] = 'CategoriesImages/'.$child->image['image'];
                $child->recipe_count   = count($child->recipes);
                $child                 = ((collect($child))->only('id', 'name', 'image', 'recipe_count'))->all();
                array_push($children,$child);
              }
              $category['children'] = $children;
            }
              $category = ((collect($category))->except('parent_category','recipes','subcategories','image_id','created_at','updated_at','deleted_at'))->all();
          }else {
            $parent                 = $category->parentCategory;
            $parent->image['image'] = 'CategoriesImages/'.$parent->image['image'];
            $parent->recipe_count   = count($parent->recipes);
            $parent                 = ((collect($parent))->only('id', 'name', 'image', 'recipe_count'))->all();
            $category['parent']     = $parent;
            $category               = ((collect($category))->except('parent_category','recipes','subcategories','image_id','created_at','updated_at','deleted_at'))->all();
          }
          array_push($all_categories,$category);
        }
        return $this->sendResponse($all_categories, 'Categories retrieved successfully');
    }



    /**
     * Display the specified Category.
     * GET|HEAD /categories/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        return $this->sendResponse($category->toArray(), 'Category retrieved successfully');
    }

}
