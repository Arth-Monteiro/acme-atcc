<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
        return view('tags.index');
    }

    public function searchTags(Request $request): JsonResponse
    {
        $tags = Tags::paginate(15, ['id', 'code', 'status', 'sub_status', 'access_level']);

        $html = '';
        foreach ($tags as $tag) {
            $html .= view('tags.card', compact('tag'));
        }

        return response()->json(['html' => $html, 'next' => $tags  ]);
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
     * @param int $id
     * @return Renderable|RedirectResponse
     */
    public function editForm(int $id): Renderable | RedirectResponse
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        if ($request->validate(Tags::validator())) {

            Tags::create($request->all());
            return redirect(route('tags_index'));

        }
    }

    public function update(Request $request): RedirectResponse
    {
        $id = $request->id;

        $validators = Tags::validator();
        array_pop($validators['code']);

        if (isset($id) && is_numeric($id) && $request->validate($validators)) {

            $tag = Tags::find($id);
            $tag->update($request->all());

            return redirect(route('tags_index'));
        }
    }
}
