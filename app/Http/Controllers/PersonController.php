<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonShowResource;
use App\Models\Person;
use App\Traits\AddUserFilteringToDataFetchTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PersonController extends Controller
{
    use AddUserFilteringToDataFetchTrait;

    /**
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('is.super.user')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $person = Person::on();
        $this->addUserFilteringToDataFetch($person, 'name', 'where', ['name', 'LIKE']);
        $this->addUserFilteringToDataFetch($person, 'last_name', 'where', ['last_name', 'LIKE']);
        $this->addUserFilteringToDataFetch($person, 'inside_identifier', 'where', ['inside_identifier', 'LIKE']);
        $this->addUserFilteringToDataFetch($person, 'phone', 'where', ['phone', 'LIKE']);
        $this->addUserFilteringToDataFetch($person, 'email', 'where', ['email', 'LIKE']);
        $this->addUserFilteringToDataFetch($person, 'is_employed', 'where', ['is_employed', '=']);

        return ResourceCollection::make($person->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return PersonShowResource
     */
    public function store()
    {
        $validate_data = $this->request->validate([
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'inside_identifier' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email'],
            'is_employed' => ['required', 'boolean'],
        ]);

        $person_model = new Person();

        foreach ($validate_data as $column => $value) {
            $person_model->$column = $value;
        }

        $person_model->save();

        return PersonShowResource::make($person_model);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return PersonShowResource
     */
    public function show(int $id)
    {
        $person = Person::findOrFail($id);

        return PersonShowResource::make($person);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return PersonShowResource
     */
    public function update(int $id)
    {
        $validate_data = $this->request->validate([
            'name' => ['sometimes', 'string'],
            'last_name' => ['sometimes', 'string'],
            'inside_identifier' => ['sometimes', 'string'],
            'phone' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email'],
            'is_employed' => ['sometimes', 'boolean'],
        ]);

        $person_model = Person::findOrFail($id);

        foreach ($validate_data as $column => $value) {
            $person_model->$column = $value;
        }

        $person_model->save();

        return PersonShowResource::make($person_model);
    }

    /**
     * Remove the specified resource from storage. Only available for the super user, won't be allowed if the person is bound to something.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id)
    {
        $person_model = Person::findOrFail($id);

        $person_model->delete();

        return true;
    }
}
