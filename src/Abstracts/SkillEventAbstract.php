<?php


namespace JoyBusinessAcademy\Profile\Abstracts;

use JoyBusinessAcademy\Profile\Models\Skill;

abstract class SkillEventAbstract
{
    public $skill;

    public function __construct(Skill $skill)
    {
        $this->skill = $skill;
    }
}