<?php

namespace App\Enums;

enum TableStatus: string
{
case Pending = 'pending';
case Avalaiable = 'available';
case Unavaliable = 'unavailable';
}