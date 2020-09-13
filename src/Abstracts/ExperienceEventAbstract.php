<?php


namespace JoyBusinessAcademy\Profile\Abstracts;


use JoyBusinessAcademy\Profile\Models\Experience;

abstract class ExperienceEventAbstract
{
    public $experience;

    public function __construct(Experience $experience)
    {
        $this->experience = $experience;
    }
}