<?php
namespace App\Classes\SessionImporter;

class SessionImporter
{
    /**
     * @var \App\Model\Entity\Conference
     */
    protected $conference;

    public function __construct($conference)
    {
        $this->conference = $conference;
    }
}
