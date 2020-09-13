<?php


namespace JoyBusinessAcademy\Profile\Abstracts;


use JoyBusinessAcademy\Profile\Models\Education;

class EducationEventAbstract
{
    public $education;

    public function __construct(Education $education)
    {
        $this->education = $education;
    }
}