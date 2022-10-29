<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Roles extends Model
{
    use HasFactory;

    const PATHS = ['roles', 'companies', 'users', 'people', 'tags', 'panel', 'dashboards', 'buildings'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'permissions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permissions' => 'array',
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @return array
     */
    public static function validator(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'code' => ['required', 'string', 'max:20', 'unique:roles,code'],
            'permissions' => ['required', 'array'],
        ];
    }
}
