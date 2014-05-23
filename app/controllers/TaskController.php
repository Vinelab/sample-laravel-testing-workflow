<?php

class TaskController extends Controller {

    protected $tasks;

    public function __construct(TaskRepository $tasks, TaskValidator $validator)
    {
        $this->tasks = $tasks;
        $this->validator = $validator;
    }

    public function index()
    {
        return Response::json($this->tasks->page()->getItems());
    }

    public function edit($id)
    {
        return View::make('tasks.edit', ['task' => $this->tasks->find($id)]);
    }

    public function store()
    {
        $this->validator->validate(Input::get());

        return $this->tasks->create(Input::get('title'),
                                    Input::get('notes'));
    }
}
