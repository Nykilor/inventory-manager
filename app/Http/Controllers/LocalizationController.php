<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Models\Localization;
use App\Traits\AddUserFilteringToDataFetchTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LocalizationController extends Controller
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
        $localization_model = Localization::on();
        $this->addUserFilteringToDataFetch($localization_model, 'city', 'where', ['city', 'LIKE']);
        $this->addUserFilteringToDataFetch($localization_model, 'code', 'where', ['code', 'LIKE']);
        $this->addUserFilteringToDataFetch($localization_model, 'street', 'where', ['street', 'LIKE']);
        $this->addUserFilteringToDataFetch($localization_model, 'name', 'where', ['name', 'LIKE']);
        $this->addUserFilteringToDataFetch($localization_model, 'description', 'where', ['description', 'LIKE']);
        $this->addUserFilteringToDataFetch($localization_model, 'longitude', 'where', ['longitude', 'LIKE']);
        $this->addUserFilteringToDataFetch($localization_model, 'latitude', 'where', ['latitude', 'LIKE']);

        return BaseResource::collection($localization_model->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return BaseResource
     */
    public function store()
    {
        $validate_data = $this->request->validate([
            'city' => ['required', 'string'],
            'code' => ['required', 'string'],
            'street' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
            'latitude' => ['nullable', 'string'],
        ]);
        $localization_model = new Localization();

        foreach ($validate_data as $column => $value) {
            $localization_model->$column = $value;
        }

        $localization_model->save();

        return BaseResource::make($localization_model);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return BaseResource
     */
    public function show(int $id)
    {
        $localization_model = Localization::with('subLocalization')->findOrFail($id);

        return BaseResource::make($localization_model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return BaseResource
     */
    public function update(int $id)
    {
        $validate_data = $this->request->validate([
            'city' => ['sometimes', 'string'],
            'code' => ['sometimes', 'string'],
            'street' => ['sometimes', 'string'],
            'name' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'longitude' => ['sometimes', 'string'],
            'latitude' => ['sometimes', 'string'],
        ]);
        $localization_model = Localization::findOrFail($id);

        foreach ($validate_data as $column => $value) {
            $localization_model->$column = $value;
        }

        $localization_model->save();

        return BaseResource::make($localization_model);
    }

    /**
     * Remove the specified resource from storage. It will only allow it if the Localization model is not bound to other models
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id)
    {
        $localization_model = Localization::findOrFail($id);
        $localization_model->delete();

        return true;
    }
}
