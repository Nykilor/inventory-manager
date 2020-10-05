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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Show the form for creating a new resource.
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = Person::findOrFail($id);

        return PersonShowResource::make($person);
    }

    /**
     * Show the form for editing the specified resource.
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
