<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use App\Models\Challenge;

Schedule::command('challenges:award-weekly-xp')
    ->everyMinute();