<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TasksTableSeeder');
	}

}

class TasksTableSeeder extends Seeder {

	public function run()
	{
		$tasks = json_decode(file_get_contents(app_path() . '/database/seeds/tasks100.json'));

		foreach ($tasks as $task)
		{
			Task::create((array) $task);
		}
	}
}
