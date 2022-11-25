<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Tags extends Model
{
    use HasFactory;

    const STATUS = ['Ativo', 'Inativo'];
    const SUB_STATUS = ['Em uso', 'Disponível', 'Fora do Complexo', 'Perdido', 'Quebrado'];
    const ACCESS_LEVEL = ['A', 'B', 'C'];

    protected $fillable = [
        'code',
        'status',
        'sub_status',
        'access_level',
        'company_id',
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @return array
     */
    public static function validator(): array
    {
        return [
            'code' => ['required', 'string', 'unique:tags,code'],
            'status' => ['required', Rule::in(self::STATUS)],
            'sub_status' => ['required', Rule::in(self::SUB_STATUS)],
            'access_level' => ['required', Rule::in(self::ACCESS_LEVEL)],
            'company_id' => ['sometimes', 'required', 'integer', 'exists:companies,id'],
        ];
    }
}
