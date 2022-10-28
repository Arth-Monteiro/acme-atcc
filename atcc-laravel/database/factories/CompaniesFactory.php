<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompaniesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cnpj = strval(rand(11111111111111, 99999999999999));
        $cnpj = $this->mask($cnpj, '##.###.###/####-##');
        $company_name = $this->faker->company();
        return [
            'cnpj' => $cnpj,
            'name' => $company_name,
            'fantasy_name' => $company_name,
            'contact_email' => $this->faker->email(),
        ];
    }

    function mask($val, $mask): string
    {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k])) $maskared .= $val[$k++];
            } else {
                if(isset($mask[$i])) $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}
