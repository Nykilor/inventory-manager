<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryAccessListResource;
use App\Models\CategoryAccess;
use Illuminate\Http\Request;

class UserCategoryAccessController extends Controller
{

    public function __construct()
    {
        $this->middleware('is.super.user');
    }

    /**
     * Display the user categories and his privileges.
     *
     * @param  int  $id \App\Model\User
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $category_access_model = CategoryAccess::with('category')->where('users_id', $id)->get();

        return CategoryAccessListResource::collection($category_access_model);
    }
}
