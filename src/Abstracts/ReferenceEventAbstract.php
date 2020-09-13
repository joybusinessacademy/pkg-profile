<?php


namespace JoyBusinessAcademy\Profile\Abstracts;


use JoyBusinessAcademy\Profile\Models\Reference;

abstract class ReferenceEventAbstract
{
    public $reference;

    public function __construct(Reference $reference)
    {
        $this->reference = $reference;
    }
}