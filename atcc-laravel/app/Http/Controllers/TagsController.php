<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Tags;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $tags = Tags::orderBy('id');

        if (!!($company_id = Auth::user()->company_id)) {
            $tags = $tags->where(['company_id' => $company_id]);
        }

        if ($request->code) {
            $tags = $tags->where('code', 'like', "%{$request->code}%");
        }

        $tags = $tags->paginate(15, ['id', 'code', 'status', 'sub_status', 'access_level']);

        $html = '';
        foreach ($tags as $tag) {
            $tag->unique = $tag->id . $tag->code;
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
        $companies = $this->getCompaniesPerUser();
        return view('form.tag', compact('companies'));
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
        $companies = $this->getCompaniesPerUser();

        if ($tag) {
            return view('form.tag', ['tag' => $tag, 'companies' => $companies]);
        }

        return redirect(route('tags_view_create', compact('companies')));
    }

    protected function getCompaniesPerUser()
    {
        $company_id = Auth::user()->company_id;
        $companies = [];
        if (!isset($company_id)) {
            $companies = Companies::orderBy('fantasy_name')->get(['id', 'fantasy_name']);
        }

        return $companies;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        if (!isset($request->company_id)) {
            $request->merge([
                'company_id' => Auth::user()->company_id,
            ]);
        }

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

    /**
     * Delete a tag instance.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $id = $request->id;

        try {
            if (Tags::find($id)->delete()) {
                return response()->json(['location' => route('tags_index')]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['msg' => 'Tag in use! Cannot delete this tag.'], 500);

        }
    }
}
