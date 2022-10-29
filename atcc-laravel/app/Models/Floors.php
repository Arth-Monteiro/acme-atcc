<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Floors extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'order',
        'building_id',
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @return array
     */
    public static function validator($request): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'order' => ['required', 'integer',  Rule::unique('floors', 'order')->where(function($query) use ($request){
                return $query->where('building_id', $request->building_id);
            })->ignore($request->id)],
            'building_id' => ['required', 'integer', 'exists:buildings,id'],
        ];
    }
}
