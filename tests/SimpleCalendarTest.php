<?php

namespace Breadthe\SimpleCalendar\Tests;

use Breadthe\SimpleCalendar\Calendar;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class SimpleCalendarTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideGridCount
     */
    public function it_returns_the_correct_number_of_days($expectedResult, $setDate)
    {
        $currentMonth = (new Calendar($setDate))->grid();

        self::assertEquals($expectedResult, count($currentMonth));
    }

    /**
     * @test
     * @dataProvider providePadWithDatesData
     */
    public function it_pads_the_beginning_and_end_with_prev_and_next_month_dates($index, $prevMonthDate)
    {
        $date = '2020-03-17';
        $currentMonth = (new Calendar($date))->grid();

        self::assertEquals($prevMonthDate, $currentMonth[$index]->toDateString());
    }

    /** @test */
    public function it_pads_the_beginning_and_end_with_null()
    {
        $date = '2020-03-17';
        $currentMonth = (new Calendar($date))->padWithNull()->grid();

        foreach (array_merge(range(0, 5), range(37, 41)) as $index) {
            self::assertNull($currentMonth[$index]);
        }
    }

    /** @test */
    public function it_has_the_correct_start_of_prev_and_next_months()
    {
        $date = '2020-03-17';
        $currentMonth = Calendar::make($date);

        self::assertInstanceOf(Carbon::class, $currentMonth->startOfPrevMonth);
        self::assertEquals('2020-02-01', $currentMonth->startOfPrevMonth->toDateString());

        self::assertInstanceOf(Carbon::class, $currentMonth->startOfNextMonth);
        self::assertEquals('2020-04-01', $currentMonth->startOfNextMonth->toDateString());
    }

    public function provideGridCount()
    {
        yield '7 x 6 month middle of month' => [42, '2020-03-17'];
        yield '7 x 5 month first of month' => [35, '2020-04-01'];
        yield '7 x 5 month last of month' => [35, '2020-04-30'];
    }

    public function providePadWithDatesData()
    {
        yield 'first date' => [0, '2020-02-24'];
        yield 'last date' => [41, '2020-04-05'];
    }
}
