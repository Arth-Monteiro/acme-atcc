<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_exit',
        'blueprint',
        'floor_id',
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @return array
     */
    public static function validator(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'is_exit' => ['boolean'],
            'blueprint' => ['required', 'string'],
            'floor_id' => ['required', 'integer', 'exists:floors,id'],
        ];
    }
}
