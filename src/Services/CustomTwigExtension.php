<?php

namespace App\Services;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CustomTwigExtension extends AbstractExtension{
    public function getFilters()
    {
        return [new TwigFilter('mon_filtre_twig', [$this, 'monFiltreTwig'])];

    }

    public function monFIltreTwig($value){
        return strtoupper($value);
    }
}