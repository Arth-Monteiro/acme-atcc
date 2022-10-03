<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class TagsController extends Controller
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
        $tags = Tags::all(['id', 'code', 'status', 'sub_status', 'access_level']);
        return view('tags', ['tags' => $tags]);
    }

    /**
     * Show the form to create tag.
     *
     * @return Renderable
     */
    public function createForm(): Renderable
    {
        return view('form.tag');
    }

    /**
     * Show the form to edit tag.
     *
     * @return Renderable
     */
    public function editForm(int $id) #: Renderable | Redirector
    {
        $tag = Tags::find($id);

        if ($tag) {
            return view('form.tag', ['tag' => $tag]);
        }

        return redirect(route('view_create_tag'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return Tags
     */
    public function create(Request $request) #: Tags
    {
        if ($request->validate(Tags::validator())) {

            Tags::create($request->all());
            return redirect(route('list_tags'));

        }
    }

    public function update(Request $request) #: Tags
    {
        $id = $request->id;

        $validators = Tags::validator();
        array_pop($validators['code']);

        if (isset($id) && is_numeric($id) && $request->validate($validators)) {

            $tag = Tags::find($id);
            $tag->update($request->all());

            return redirect(route('list_tags'));
        }
    }
}
