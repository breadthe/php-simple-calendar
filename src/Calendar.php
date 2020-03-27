<?php

namespace Breadthe\SimpleCalendar;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

class Calendar
{
    private $today; // today as a reference (any day passed by the user)
    private $padWithNull = false; // pad beginning or end of month with null instead of dates
    private $startOfMonth; // first day of the current month
    private $endOfMonth; // first day of the current month
    private $currentMonth; // the calendar for the current month

    public $startOfPrevMonth;
    public $startOfNextMonth;

    public function __construct(string $today)
    {
        $this->today = CarbonImmutable::make($today);
        $this->startOfMonth = $this->today->startOfMonth();
        $this->endOfMonth = $this->today->endOfMonth();
        $this->startOfPrevMonth = Carbon::make($this->today)->startOfMonth()->subDay()->startOfMonth();
        $this->startOfNextMonth = Carbon::make($this->today)->endOfMonth()->addDay();
    }

    public static function make(string $today): self
    {
        return new static($today);
    }

    public function padWithNull(): self
    {
        $this->padWithNull = true;

        return $this;
    }

    public function grid(): array
    {
        $this->currentMonth = CarbonPeriod::create($this->startOfMonth, $this->endOfMonth)->toArray();

        $this->padStart();

        $this->padEnd();

        return $this->currentMonth;
    }

    // If first day of month > 1 (first week doesn't start on a Monday)...
    // ...then pad the first week with remaining days from previous month
    private function padStart(): void
    {
        // what day in the week is the first of the month?
        $startOfMonthWeekday = $this->startOfMonth->isoWeekday();

        if ($startOfMonthWeekday > 1) {
            $currentMonth = $this->currentMonth;

            $daysToPad = $startOfMonthWeekday - 1;
            $prevMonth = CarbonPeriod::create(
                $this->startOfMonth->subDays($daysToPad),
                $this->startOfMonth->subDay()
            )->toArray();

            $this->padWithNull
                ? $this->currentMonth = array_pad($currentMonth, -(count($currentMonth) + $daysToPad), null)
                : $this->currentMonth = array_merge($prevMonth, $currentMonth);
        }
    }

    // If last day of month < 7 (last week doesn't end on a Sunday)...
    // ...then pad the last week with beginning days from next month
    private function padEnd(): void
    {
        // what day in the week is the last of the month?
        $endOfMonthWeekday = $this->endOfMonth->isoWeekday();

        if ($endOfMonthWeekday < 7) {
            $currentMonth = $this->currentMonth;

            $daysToPad = 7 - $endOfMonthWeekday;
            $nextMonth = CarbonPeriod::create(
                $this->endOfMonth->addDay(),
                $this->endOfMonth->addDays($daysToPad)
            )->toArray();

            $this->padWithNull
                ? $this->currentMonth = array_pad($currentMonth, count($currentMonth) + $daysToPad, null)
                : $this->currentMonth = array_merge($currentMonth, $nextMonth);
        }
    }
}
