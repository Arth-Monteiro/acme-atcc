<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\Tags;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the grid of people.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $people = People::all(['id', 'firstname', 'lastname', 'cpf', 'qualification']);
        return view('people', ['people' => $people]);
    }

    /**
     * Show the form to register person.
     *
     * @return Renderable
     */
    public function createForm(): Renderable
    {
        $tags = Tags::where([
            'status' => 'Active',
            'sub_status' => 'Available'
        ])->get(['id', 'code']);

        return view('form.person', ['tags' => $tags]);
    }

    /**
     * Show the form to edit person.
     *
     * @return Renderable
     */
    public function editForm(int $id) #: Renderable | Redirector
    {
        $person = People::find($id);

        if ($person) {

            $tags = Tags::where([
                'status' => 'Active',
                'sub_status' => 'Available'
            ])
                ->orWhere('id', $person->tag_id)
                ->orderBy('code')
                ->get(['id', 'code']);

            return view('form.person', ['person' => $person, 'tags' => $tags]);
        }

        return redirect(route('view_create_person'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return People
     */
    public function create(Request $request) #: People
    {
        if ($request->validate(People::validator())) {
            $person = People::create($request->all() + [
                'insert_by' => Auth::user()->name,
                'update_by' => Auth::user()->name,
            ]);

            $tag = Tags::find($person->tag_id);
            $tag->sub_status = 'In use';
            $tag->save();

            return redirect(route('list_people'));
        }
    }

    public function update(Request $request) #: People
    {
        $id = $request->id;

        $validators = People::validator();
        array_pop($validators['tag_id']);
        array_pop($validators['email']);
        array_pop($validators['cpf']);

        if (isset($id) && is_numeric($id) && $request->validate($validators)) {

            $person = People::find($id);
            $person->update($request->all() + ['update_by' => Auth::user()->name]);

            return redirect(route('list_people'));
        }
    }
}
