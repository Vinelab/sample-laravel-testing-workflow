<?php

class TasksTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
        //
        Artisan::call('migrate');

        $this->repo = App::make('TaskRepository');
    }

    public function tearDown()
    {
        //
        parent::tearDown();
    }

    public function testMigration()
    {
        $tasks = Task::all();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $tasks);
    }

    public function testFetchingPaginatedTasks()
    {
        $this->seed();

        $response = $this->call('GET', '/tasks');

        $this->assertResponseOk();

        $this->assertCount($this->repo->getPerPage(), (array) $response->getData());
    }

    public function testStoringATask()
    {
        $task = ['title' => 'My Title', 'notes' => 'This is a note'];

        $response = $this->call('POST', '/tasks', $task);

        $stored = $response->original;

        $this->assertTrue($stored['exists']);
        $this->assertGreaterThan(0, $stored['id']);
        $this->assertEquals('My Title', $stored['title']);
        $this->assertEquals('This is a note', $stored['notes']);
        $this->assertFalse($stored['checked']);
    }

    /**
     * @depends testStoringATask
     * @expectedException InvalidTaskException
     * @expectedExceptionMessage title
     */
    public function testValidatingTasksWithNoTitle()
    {
        $task = ['notes' => 'aiuhaasdjfh'];

        $this->call('POST', '/tasks', $task);
    }

    /**
     * @depends testStoringATask
     * @expectedException InvalidTaskException
     * @expectedExceptionMessage title
     */
    public function testValidatingTasksWithNullTitle()
    {
        $task = ['title'=>null, 'notes' => 'aiuhaasdjfh'];

        $this->call('POST', '/tasks', $task);
    }

    /**
     * @depends testStoringATask
     * @expectedException InvalidTaskException
     * @expectedExceptionMessage title
     */
    public function testValidatingTasksWithEmptyTitle()
    {
        $task = ['title' => '', 'notes' => 'aiuhaasdjfh'];

        $this->call('POST', '/tasks', $task);
    }

    /**
     * @depends testStoringATask
     * @expectedException InvalidTaskException
     * @expectedExceptionMessage title
     */
    public function testValidatingTasksWithLongTitle()
    {
        $task = ['title' => 'ljkah sdflkhgasdlhfglahjsdgfljhasdgfjhasgdfjhasgdfkhjagsdfkjhagsdkfjhgasdkjfhgaksjdhfgkajsdhgfkjhasgdkfjgaskdfjgaskdjfgaksjdgfkjasdgfkjakajsdgfkjhasgdfkjhagsdfkjhgasdkjfhgasdkjhfgkajshdfgkjahsgdfkjasdfuyasgdhfjkagsdfkjhasgdfkjhagsdfkjghsadkfgasdjfhvsadkjfh', 'notes' => 'aiuhaasdjfh'];

        $this->call('POST', '/tasks', $task);
    }

    /**
     * @expectedException InvalidTaskException
     * @expectedExceptionMessage notes
     */
    public function testValidatingTasksWithNoNotes()
    {
        $task = ['title' => 'jhasdfhba'];

        $this->call('POST', '/tasks', $task);
    }

    /**
     * @expectedException InvalidTaskException
     * @expectedExceptionMessage notes
     */
    public function testValidatingTasksWithNullNotes()
    {
        $task = ['title' => 'jhasdfhba', 'notes' => null];

        $this->call('POST', '/tasks', $task);
    }

    /**
     * @expectedException InvalidTaskException
     * @expectedExceptionMessage notes
     */
    public function testValidatingTasksWithEmptyNotes()
    {
        $task = ['title' => 'jhasdfhba', 'notes' => ''];

        $this->call('POST', '/tasks', $task);
    }

    public function testOpeningTaskForEditing()
    {
        $this->seed();

        $task = Task::first();

        $response = $this->route('GET', 'tasks.edit', ['id' => $task->id]);
        $view = $response->original;
        $this->assertInstanceOf('Illuminate\View\View', $view);
        $this->assertEquals($task, $view['task']);
    }

}
