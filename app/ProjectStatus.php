<?php

namespace App;

enum ProjectStatus: string
{
    case Research = 'research';
    case ReadyForSchedule = 'ready_for_schedule';
    case Scheduled = 'scheduled';
    case ReadyForDrafting = 'ready_for_drafting';
    case ReadyForReview = 'ready_for_review';
    case ReadyForInvoice = 'ready_for_invoice';
    case AwaitingPayment = 'awaiting_payment';
    case ReadyToDeliver = 'ready_to_deliver';
    case Delivered = 'delivered';
}
