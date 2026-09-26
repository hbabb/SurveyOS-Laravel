<?php

namespace App;

enum ProposalStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Viewed = 'viewed';
    case Accepted = 'accepted';
    case Declined = 'declined';
    case Expired = 'expired';
}
