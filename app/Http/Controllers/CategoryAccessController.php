<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\CategoryAccessListResource;
use App\Models\CategoryAccess;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class CategoryAccessController extends Controller
{
    /**
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display the user categories and his privileges.
     *
     * @param  int  $id \App\Model\User
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category_access_model = CategoryAccess::with('category')->where('users_id', $id)->get();

        return CategoryAccessListResource::collection($category_access_model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id \App\Model\CategoryAccess
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('update');
        $category_access_model = CategoryAccess::with('category')->whereIn('category_id', $user_category_access)->findOrFail($id);

        $validate_data = $this->request->validate([
            'create' => ['sometimes', 'boolean'],
            'read' => ['sometimes', 'boolean'],
            'update' => ['sometimes', 'boolean'],
        ]);

        foreach ($validate_data as $column => $value) {
            $category_access_model->$column = $value;
        }

        $category_access_model->save();

        return CategoryAccessListResource::make($category_access_model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
