<?php

use Illuminate\Database\Seeder;

class delivery_statuses extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::transaction(function () {
			DB::statement('SET FOREIGN_KEY_CHECKS=0');

			DB::table('delivery_status')->delete();

			$data = [
				[
					'id' => 1, 
					"status" => "Sent"
				],
				[
					'id' => 2, 
					"status" => "Failed"
				]
			];

			foreach($data as $value) {
				DB::table('delivery_status')->insert($value);
			}

			DB::statement('SET FOREIGN_KEY_CHECKS=1');
		});
	}
}
