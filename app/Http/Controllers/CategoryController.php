<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\CategoryAccess;
use App\Traits\AddUserFilteringToDataFetchTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    use AddUserFilteringToDataFetchTrait;

    /**
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        //Only super_user should be able to make changes to categories
        $this->middleware('is.super.user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');
        $categories = Category::whereHas('categoryAccess', function($query) use($user_category_access) {
            $query->whereIn('category_id', $user_category_access);
        })->get();

        $this->addUserFilteringToDataFetch($categories, 'name', 'where', ['model', 'LIKE']);
        $this->addUserFilteringToDataFetch($categories, 'description', 'where', ['model', 'LIKE']);

        return ResourceCollection::make($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return CategoryResource
     */
    public function store()
    {
        $user = Auth::user();
        $validate_data = $this->request->validate([
            'name' => ['required', 'string'],
            'description' => ['sometimes', 'string', 'nullable'],
        ]);

        $category_model = new Category();

        foreach ($validate_data as $column => $value)  {
            $category_model->$column = $value;
        }

        $category_model->save();

        //Give the creator full privilage
        $category_access_model = new CategoryAccess();
        $category_access_model->create = 1;
        $category_access_model->read = 1;
        $category_access_model->update = 1;
        $category_access_model->users_id = $user->id;
        $category_access_model->category_id = $category_model->id;
        $category_access_model->save();

        return CategoryResource::make($category_model);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CategoryResource
     */
    public function show(int $id)
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');
        $category = Category::whereHas('categoryAccess', function($query) use($user_category_access) {
            $query->whereIn('category_id', $user_category_access);
        })->where('id', '=', $id)->firstOrFail();

        return CategoryResource::make($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return CategoryResource
     */
    public function update(int $id)
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('update');
        $validate_data = $this->request->validate([
            'name' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string', 'nullable'],
        ]);

        $category = Category::whereHas('categoryAccess', function($query) use($user_category_access) {
            $query->whereIn('category_id', $user_category_access);
        })->where('id', '=', $id)->firstOrFail();

        foreach ($validate_data as $column => $value) {
            $category->$column = $value;
        }

        $category->save();

        return CategoryResource::make($category);
    }
}
