<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompaniesController extends Controller
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
        return view('companies.index');
    }

    public function searchCompanies(Request $request): JsonResponse
    {
        $companies = Companies::orderBy('cnpj');

        if ($request->code) {
            $companies = $companies->where('cnpj', 'ilike', "%{$request->code}%")    ;
        }

        $companies = $companies->paginate(15, ['id', 'fantasy_name', 'contact_email', 'cnpj']);

        $html = '';
        foreach ($companies as $company) {
            $company->unique = $company->id;
            $html .= view('companies.card', compact('company'));
        }

        return response()->json(['html' => $html, 'next' => $companies  ]);
    }

    /**
     * Show the form to create tag.
     *
     * @return Renderable
     */
    public function createForm(): Renderable
    {
        return view('form.company');
    }

    /**
     * Show the form to edit person.
     *
     * @return Renderable
     */
    public function editForm(int $id): Renderable | RedirectResponse
    {
        $company = Companies::find($id);

        if ($company) {
            return view('form.company', ['company' => $company]);
        }

        return redirect(route('companies_view_create'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        if ($request->validate(Companies::validator())) {
            Companies::create($request->all());
            return redirect(route('companies_index'));
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

        $validators = Companies::validator();
        array_pop($validators['cnpj']);

        if (isset($id) && is_numeric($id) && $request->validate($validators)) {

            $company = Companies::find($id);
            $company->update($request->all());

            return redirect(route('companies_index'));
        }
    }

    /**
     * Delete a comapny instance.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $id = $request->id;

        if (Companies::find($id)->delete()) {
            return response()->json(['location' => route('companies_index')]);
        }
    }
}
