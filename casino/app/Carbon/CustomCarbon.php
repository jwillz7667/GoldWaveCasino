<?php

namespace App\Carbon;

use Carbon\Carbon;

class CustomCarbon extends Carbon
{
    public static function useCustomCarbon()
    {
        Carbon::mixin(new class {
            public function getDaysFromStartOfWeek()
            {
                return function ($weekStartsAt = null) {
                    return parent::getDaysFromStartOfWeek($weekStartsAt);
                };
            }

            public function setDaysFromStartOfWeek()
            {
                return function ($weekStartsAt = null) {
                    return parent::setDaysFromStartOfWeek($weekStartsAt);
                };
            }

            public function utcOffset()
            {
                return function ($minuteOffset = null) {
                    return parent::utcOffset($minuteOffset);
                };
            }

            public function locale()
            {
                return function ($locale = null) {
                    return parent::locale($locale);
                };
            }

            public function setDefaultTimezone()
            {
                return function ($date = null) {
                    return parent::setDefaultTimezone($date);
                };
            }
        });
    }
} 