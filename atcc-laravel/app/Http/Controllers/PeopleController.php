<?php

namespace App\Http\Controllers;

use App\Models\Buildings;
use App\Models\Companies;
use App\Models\People;
use App\Models\Tags;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
        $this->middleware(['auth', 'role.permission']);
    }

    /**
     * Show the grid of people.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('people.index');
    }

    public function searchPeople(Request $request): JsonResponse
    {
        $company_id = Auth::user()->company_id;

        $where = isset($company_id) ? ['company_id' => $company_id] : [];
        $people = People::where($where);
        if ($request->code) {
            $code = preg_replace('/[.-]/', '', $request->code);
            $people = $people->where('cpf', 'like', "%{$code}%");
        }
        $people = $people->orderBy('firstname')
            ->orderBy('lastname')
            ->paginate(15, ['id', 'firstname', 'lastname', 'qualification', 'cpf', 'tag_id']);

        $html = '';
        foreach ($people as $person) {
            $person->unique = $person->id . $person->cpf;
            $html .= view('people.card', compact('person'));
        }

        return response()->json(['html' => $html, 'next' => $people  ]);
    }

    /**
     * Show the form to register person.
     *
     * @return Renderable
     */
    public function createForm(): Renderable
    {
        $companies = $this->getCompaniesPerUser();
        return view('form.person', compact('companies'));
    }

    /**
     * Show the form to edit person.
     *
     * @param int $id
     * @return Renderable|RedirectResponse
     */
    public function editForm(int $id): Renderable | RedirectResponse
    {
        $person = People::find($id);
        $companies = $this->getCompaniesPerUser();

        if ($person) {
            return view('form.person', ['person' => $person, 'companies' => $companies]);
        }

        return redirect(route('people_view_create', compact('companies')));
    }

    public function setViewTagForPerson(int $people_id, int $tag_id)
    {
        $person = People::find($people_id);

        if ($person) {
            $company_id = Auth::user()->company_id;
            $where = isset($company_id) ? ['company_id' => $company_id] : [];
            $tags = Tags::where(['status' => 'Active', 'sub_status' => 'Available', 'company_id' => $person->company_id] + $where    )
                ->orWhere(['id' => $person->tag_id])
                ->orderBy('code')
                ->get(['id', 'code']);

            return view('form.persontag', [
                'people_id' => $people_id,
                'tag_id' => $tag_id,
                'tags' => $tags,
            ]);

        }

        $companies = $this->getCompaniesPerUser();
        return redirect(route('people_view_create', compact('companies')));
    }

    public function setTagForPerson(Request $request)
    {
        $tag_id = $request->tag_id;

        $tag = Tags::find($tag_id);
        $person = People::find($request->people_id);
        if ($tag->company_id === $person->company_id && (
            ($tag->company_id === Auth::user()->company_id) || (!isset(Auth::user()->company_id)) ) ) {
            if ($person->tag_id !== $tag_id && isset($person->tag_id)) {
                Tags::find($person->tag_id)->update(['sub_status' => 'Available']);
            }
            $person->update(['tag_id' => $tag->id]);
            $tag->update(['sub_status' => 'In use']);
            return redirect(route('people_index'));
        }
    }

    public function removeTagForPerson(Request $request)
    {
        $tag = Tags::find($request->tag_id);
        $person = People::find($request->people_id);
        if ($tag->company_id === $person->company_id && (
                ($tag->company_id === Auth::user()->company_id) || (!isset(Auth::user()->company_id)) ) ) {
            $person->update(['tag_id' => null]);
            $tag->update(['sub_status' => 'Available']);
            return response()->json(['location' => route('people_index')]);
        }
    }

    protected function getCompaniesPerUser()
    {
        $companies = [];
        if (!(Auth::user()->company_id)) {
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

        if ($request->validate(People::validator($request))) {
            People::create($request->all() + [
                'insert_by' => Auth::user()->name,
                'update_by' => Auth::user()->name,
            ]);

            return redirect(route('people_index'));
        }
    }

    /**
     * Edit a user instance after a valid registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $id = $request->id;

        $validators = People::validator($request);

        if (isset($id) && is_numeric($id) && $request->validate($validators)) {

            $person = People::find($id);
            $person->update($request->all() + ['update_by' => Auth::user()->name]);

            return redirect(route('people_index'));
        }
    }

    /**
     * Delete a role instance.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $id = $request->id;

        if (People::find($id)->delete()) {
            return response()->json(['location' => route('people_index')]);
        }
    }
}
