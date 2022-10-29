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
        $this->middleware('auth');
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

    public function searchPeople(): JsonResponse
    {
        $company_id = Auth::user()->company_id;
        $where = isset($company_id) ? ['company_id' => $company_id] : [];
        $people = People::where($where)
            ->orderBy('id')
            ->paginate(15, ['id', 'firstname', 'lastname', 'qualification', 'cpf']);

        $html = '';
        foreach ($people as $person) {
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
