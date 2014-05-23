<?php

class Task extends Eloquent {

    protected $table = 'tasks';

    protected $fillable = ['title', 'notes', 'checked'];
}
