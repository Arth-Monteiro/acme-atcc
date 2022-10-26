<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cnpj',
        'name',
        'fantasy_name',
        'contact_email',
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @return array
     */
    public static function validator(): array
    {
        return [
            'cnpj' => ['required', 'string', 'max:20', 'unique:companies,cnpj'],
            'name' => ['required', 'string', 'max:64',],
            'fantasy_name' => ['required', 'string', 'max:64'],
            'contact_email' => ['required', 'string', 'email', 'max:50']
        ];
    }
}
