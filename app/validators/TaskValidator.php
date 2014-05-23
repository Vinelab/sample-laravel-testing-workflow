<?php

class InvalidTaskException extends Exception {

    public function __construct($messages, $code = 0, $previous = null)
    {
        $message = implode(',', $messages);
        $this->messages = $messages;

        parent::__construct($message, $code, $previous);
    }

    public function messages()
    {
        return $this->messages;
    }
}

class TaskValidator extends NobValidator {

    protected $rules = [
        'title' => 'required|max:255',
        'notes' => 'required'
    ];

    public function validate($attributes)
    {
        $validation = $this->validation($attributes);

        if ($validation->fails())
        {
            throw new InvalidTaskException($validation->messages()->all());
        }

        return true;
    }
}
