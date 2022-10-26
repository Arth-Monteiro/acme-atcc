<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
            $permissions = [];
            foreach ($role->permissions as $permission) {
                $path = explode('_', $permission)[0];
                if (!isset($permissions[$path])) {
                    $permissions[$path] = (str_contains($permission, '*') ?  'editor' : 'viewer');

                }
            }
            return view('form.role', ['role' => $role, 'permissions' => $permissions]);
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
        $request = $this->extractPermissionValue($request);

        if ($request->validate(Roles::validator())) {
            Roles::create($request->all());
            return redirect(route('roles_index'));
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
        $request = $this->extractPermissionValue($request);

        $validators = Roles::validator();
        array_pop($validators['code']);

        if (isset($id) && is_numeric($id) && $request->validate($validators)) {
            $role = Roles::find($id);
            $role->update($request->all());
            return redirect(route('roles_index'));
        }
    }

    protected function extractPermissionValue(Request $request): Request
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
                        array_push($permissions, "{$path}_index", "{$path}_list", "{$path}_view_edit",);
                        break;
                }
            }
        }

        $request->merge([
            'permissions' => $permissions
        ]);

        return $request;
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

        if (Roles::find($id)->delete()) {
            return response()->json(['location' => route('roles_index')]);
        }
    }

}
