<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class StateCityCountrySeeder extends Seeder
{
    public function run()
    {
        $citiesTable = Config::get('laravel-location.cities_table');
        $statesTable = Config::get('laravel-location.states_table');
        DB::table($citiesTable)
            ->orderBy('id')
            ->chunk(100, function ($cities) use ($citiesTable, $statesTable) {
               foreach ($cities as $city) {
                   $state = DB::table($statesTable)->where('id', $city->state_id)->first();

                       DB::table($citiesTable)->where('id', $city->id)->update([
                           'country_id' => $state->country_id,
                       ]);
               }
            });
    }
}
