<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryAccessListResource;
use App\Models\CategoryAccess;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserCategoryAccessController extends Controller
{

    public function __construct()
    {
        $this->middleware('is.super.user');
    }

    /**
     * Display the user categories and his privileges.
     *
     * @param int $id \App\Model\User
     * @return AnonymousResourceCollection
     */
    public function __invoke(int $id)
    {
        $category_access_model = CategoryAccess::with('category')->where('users_id', $id)->get();

        return CategoryAccessListResource::collection($category_access_model);
    }
}
