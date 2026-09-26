<?php

namespace App;

enum LotDeliverableType: string
{
    case LotFit = 'lot_fit';
    case PlotPlan = 'plot_plan';
    case HouseStake = 'house_stake';
    case PinFootings = 'pin_footings';
    case FinalMortgageSurvey = 'final_mortgage_survey';
}
