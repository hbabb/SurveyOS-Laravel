<?php

namespace App;

enum ProposalAcceptanceSource: string
{
    case Portal = 'portal';
    case EmployeeEntry = 'employee_entry';
}
