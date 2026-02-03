<?php

namespace App\Enums;

enum RegistrationStatus: string
{
    case Registered = 'registered';
    case PassedWeighIn = 'passed_weigh_in';
    case FailedWeighIn = 'failed_weigh_in';
    case Competed = 'competed';
    case Dns = 'dns';
    case Dq = 'dq';
}
