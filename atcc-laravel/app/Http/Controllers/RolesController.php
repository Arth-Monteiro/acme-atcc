<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\Roles;
use App\Models\Tags;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
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
        $roles = Roles::orderBy('id')->paginate(15, ['id', 'name']);
        return view('roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form to create tag.
     *
     * @return Renderable
     */
    public function createForm(): Renderable
    {
        return view('form.role');
    }

    /**
     * Show the form to edit person.
     *
     * @return Renderable
     */
    public function editForm(int $id): Renderable | RedirectResponse
    {
        $role = Roles::find($id);

        if ($role) {

            return view('form.role', ['role' => $role]);
        }

        return redirect(route('roles_view_create'));
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $post = $request->post();
        $permissions = [];
        foreach ($post as $key => $value) {
            if (str_contains($key, 'permission')) {
                $path = explode('-', $key)[1];
                switch ($value) {
                    case 'editor':
                        array_push($permissions, "{$path}_*");
                        break;
                    case 'viewer':
                        array_push($permissions, ["{$path}_index", "list_$path", "view_edit_$path",]);
                        break;
                }
            }
        }

        $request->merge([
            'permissions' => $permissions
        ]);

        if ($request->validate(Roles::validator())) {
            Roles::create($request->all());
            return redirect(route('roles_index'));
        }
    }
}
