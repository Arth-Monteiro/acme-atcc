<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class People extends Model
{
    use HasFactory;

    const BLOOD_TYPES = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    const QUALIFICATION = ['Visitor', 'Employee'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'cpf',
        'email',
        'cellphone',
        'blood_type',
        'emergency_contact',
        'company',
        'job_title',
        'qualification',
        'tag_id',
        'insert_by',
        'update_by',
        'company_id'
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @return array
     */
    public static function validator($request): array
    {
        return [
            'firstname' => ['required', 'string', 'max:15'],
            'lastname' => ['required', 'string', 'max:32'],
            'cpf' => ['required', 'string', 'min:11', 'max:11',
                Rule::unique('people', 'cpf')->where(function($query) use ($request){
                    return $query->where('company_id', $request->company_id);
                })->ignore($request->id)],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('people', 'email')->where(function($query) use ($request){
                    return $query->where('company_id', $request->company_id);
                })->ignore($request->id)],
            'cellphone' => ['required', 'string', 'max:15'],
            'blood_type' => ['required', Rule::in(self::BLOOD_TYPES)],
            'emergency_contact' => ['required', 'string', 'max:15'],
            'company' => ['string', 'max:64'],
            'job_title' => ['string', 'max:20'],
            'qualification' => ['required', Rule::in(self::QUALIFICATION)],
            'company_id' => ['sometimes', 'required', 'integer', 'exists:companies,id'],
        ];
    }
}
