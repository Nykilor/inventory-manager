<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Models\SubLocalization;
use App\Traits\AddUserFilteringToDataFetchTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubLocalizationController extends Controller
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
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $sub_localization_model = SubLocalization::on();
        $this->addUserFilteringToDataFetch($sub_localization_model, 'name', 'where', ['name', 'LIKE']);
        $this->addUserFilteringToDataFetch($sub_localization_model, 'description', 'where', ['description', 'LIKE']);
        $this->addUserFilteringToDataFetch($sub_localization_model, 'localization_id', 'where', ['localization_id', '=']);

        return BaseResource::collection($sub_localization_model->get());
    }

    /**
     * Index the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return BaseResource
     */
    public function store()
    {
        $validate_data = $this->request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'localization_id' => ['required', 'bail', 'integer', 'exists:\App\Models\Localization,id']
        ]);
        $sub_localization_model = new SubLocalization();

        foreach ($validate_data as $column => $value) {
            $sub_localization_model->$column = $value;
        }

        $sub_localization_model->save();

        return BaseResource::make($sub_localization_model);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return BaseResource
     */
    public function show($id)
    {
        $sub_localization_model = SubLocalization::findOrFail($id);

        return BaseResource::make($sub_localization_model);
    }

    /**
     * Index the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return BaseResource
     */
    public function update($id)
    {
        $validate_data = $this->request->validate([
            'name' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'localization_id' => ['sometimes', 'bail', 'integer', 'exists:\App\Models\Localization,id']
        ]);
        $sub_localization_model = SubLocalization::findOrFail($id);

        foreach ($validate_data as $column => $value) {
            $sub_localization_model->$column = $value;
        }

        $sub_localization_model->save();

        return BaseResource::make($sub_localization_model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sub_localization_model = SubLocalization::findOrFail($id);
        $sub_localization_model->delete();

        return true;
    }
}
