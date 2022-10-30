<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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

    public function index(): Renderable
    {
        return view('users.index');
    }

    public function searchUsers(Request $request): JsonResponse
    {
        $company_id = Auth::user()->company_id;
        $where = isset($company_id) ? ['company_id' => $company_id] : [];
        $users = User::where($where);
        if ($request->code) {
            $users = $users->where('name', 'ilike', "%{$request->code}%");
        }
        $users = $users->orderBy('name')->paginate(15, ['id', 'name', 'email']);

        $html = '';
        foreach ($users as $user) {
            $user->unique = $user->id . $user->name;
            $html .= view('users.card', compact('user'));
        }

        return response()->json(['html' => $html, 'next' => $users]);
    }

    /**
     * Show the form to create tag.
     *
     * @return Renderable
     */
    public function createForm(): Renderable
    {
        [$roles, $companies] = $this->getRolesAndCompanies();
        return view('form.user', compact('companies'), compact('roles'));
    }

    /**
     * Show the form to edit person.
     *
     * @return Renderable
     */
    public function editForm(int $id): Renderable | RedirectResponse
    {
        $user = User::find($id);
        [$roles, $companies] = $this->getRolesAndCompanies();

        if ($user) {
            return view('form.user', [
                'user' => $user,
                'companies' => $companies,
                'roles' => $roles
            ]);
        }

        return redirect(route('users_view_create', compact('companies'), compact('roles')));
    }

    protected function getRolesAndCompanies(): array
    {
        $user = Auth::user();

        $company_id = $user->company_id;
        $companies = [];
        if (!isset($company_id)) {
            $companies = Companies::orderBy('fantasy_name')->get(['id', 'fantasy_name']);
        }

        $role = $user->getRole('code');
        $roles = Roles::orderBy('id');
        if ($role !== 'super_admin') {
            $roles = $roles->where('code', '!=', 'super_admin') ;
        }
        $roles = $roles->get(['id', 'name']);

        return [$roles, $companies];
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

        if ($request->validate(User::validator())) {

            $request->merge([
                'password' => Hash::make($request->password),
            ]);

            User::create($request->all());
            return redirect(route('users_index'));
        }
    }

    /**
     * Update a user instance after a valid registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $id = $request->id;
        if (isset($id) && is_numeric($id)) {
            $user = User::find($id);
            $validators = User::validator();
            array_pop($validators['email']);

            if ($request->validate($validators)) {

                $request->merge([
                    'password' => Hash::make($request->password),
                ]);

                $user->update($request->all());
                return redirect(route('users_index'));
            }
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

        if (User::find($id)->delete()) {
            return response()->json(['location' => route('users_index')]);
        }
    }

}

