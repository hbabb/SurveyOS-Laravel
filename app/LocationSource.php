<?php

namespace App;

enum LocationSource: string
{
    case Geocoded = 'geocoded';
    case Manual = 'manual';
}
