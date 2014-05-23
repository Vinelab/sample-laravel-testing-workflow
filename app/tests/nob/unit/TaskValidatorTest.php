<?php

class TaskValidatorTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
        //
        $this->validator = App::make('TaskValidator');
    }

    public function tearDown()
    {
        //
        parent::tearDown();
    }

    // public function testBinding()
    // {
    //     $this->assertInstanceOf('Najem\Validators\TaskValidator', $this->validator);
    // }

    public function testPassingTaskValidator()
    {
        $task = ['title' => 'jhasdf', 'notes' => 'jkhasdfljk', 'checked' => true];

        $this->assertTrue($this->validator->validate($task));
    }

    /**
     * @expectedException InvalidTaskException
     */
    public function testFailsWithNoTitle()
    {
        $task = ['notes' => 'jkhasdfljk', 'checked' => true];

        $this->validator->validate($task);
    }
}
