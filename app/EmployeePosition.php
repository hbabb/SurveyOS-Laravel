<?php

namespace App;

enum EmployeePosition: string
{
    case OfficeAdmin = 'office_admin';
    case Researcher = 'researcher';
    case Cad = 'cad';
    case Field = 'field';
    case Pls = 'pls';
}
