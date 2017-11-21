<?php
namespace App\Classes\ExtraAction;

class ExtraAction
{
    protected $conference;
    public $actions = [];

    public function __construct($conference)
    {
        $this->conference = $conference;
    }
}
