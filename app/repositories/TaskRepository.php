<?php

class TaskRepository {

    protected $task;

    protected $per_page = 50;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function find($ids)
    {
        if (is_array($ids))
        {
            return $this->task->findManyOrFail($ids);
        }

        return $this->task->findOrFail($ids);
    }

    public function create($title, $notes, $checked = false)
    {
        return $this->task->create(compact('title', 'notes', 'checked'));
    }

    public function page()
    {
        return $this->task->paginate($this->per_page);
    }

    public function setPerPage($limit)
    {
        $this->per_page = (int) $limit;
    }

    public function getPerPage()
    {
        return $this->per_page;
    }

}
