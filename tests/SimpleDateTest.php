<?php

namespace BlueTime\Test;

use BlueTime\Simple\Date;
use PHPUnit\Framework\TestCase;

class SimpleDateTest extends TestCase
{
    protected $time = 1770126169;
    public function testGetFormattedTime()
    {
        $time = Date::getFormattedTime();
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2} - \d{2}:\d{2}:\d{2}/', $time);

        $time = Date::getFormattedTime($this->time);
        $this->assertEquals('2026-02-03 - 13:42:49', $time);
    }

    public function testGetDate()
    {
        $time = Date::getDate();
        $this->assertMatchesRegularExpression('/\d{2}-\d{2}-\d{4}/', $time);

        $time = Date::getDate($this->time, true);
        $this->assertEquals('2026-02-03', $time);

        $time = Date::getDate(null, true);
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2}/', $time);

        $time = Date::getDate($this->time);
        $this->assertEquals('03-02-2026', $time);
    }

    public function testGetTime()
    {
        $time = Date::getTime();
        $this->assertMatchesRegularExpression('/\d{2}:\d{2}:\d{2}/', $time);

        $time = Date::getTime($this->time);
        $this->assertEquals('13:42:49', $time);
    }

    public function testGetMonthName()
    {
        $month = Date::getMonthName();
        $this->assertMatchesRegularExpression('/[A-Z]{1}[a-z]{3,10}/', $month);
        
        $month = Date::getMonthName(null, true);
        $this->assertMatchesRegularExpression('/[A-Z]{1}[a-z]{2}/', $month);

        $month = Date::getMonthName($this->time, true);
        $this->assertEquals('Feb', $month);

        $month = Date::getMonthName($this->time);
        $this->assertEquals('February', $month);
    }

    public function testGetDayName()
    {
        $day = Date::getDayName();
        $this->assertMatchesRegularExpression('/[A-Z]{1}[a-z]{3,10}/', $day);

        $day = Date::getDayName(null, true);
        $this->assertMatchesRegularExpression('/[A-Z]{1}[a-z]{2}/', $day);

        $day = Date::getDayName($this->time, true);
        $this->assertEquals('Tue', $day);

        $day = Date::getDayName($this->time);
        $this->assertEquals('Tuesday', $day);
    }

    public function testGetDayNumber()
    {
        $day = Date::getDayNumber();
        $this->assertMatchesRegularExpression('/[\d]{1,3}/', $day);

        $day = Date::getDayNumber($this->time);
        $this->assertEquals(34, $day);
    }

    public function testGetDayInMonth()
    {
        $day = Date::getDayInMonth();
        $this->assertMatchesRegularExpression('/[\d]{2}/', $day);

        $day = Date::getDayInMonth($this->time);
        $this->assertEquals(28, $day);
    }

    public function testGetMonths()
    {
        $list = Date::getMonths($this->time);
        
        $this->assertIsArray($list);
        $this->assertCount(12, $list);
        $this->assertEquals(
            [
                1 => 31,
                2 => 28,
                3 => 31,
                4 => 30,
                5 => 31,
                6 => 30,
                7 => 31,
                8 => 31,
                9 => 30,
                10 => 31,
                11 => 30,
                12 => 31,
            ], 
            $list
        );
    }

    public function testValid()
    {
        $result = Date::valid([2024, 2, 28]);
        $this->assertTrue($result);

        $result = Date::valid([2024, 2, 34]);
        $this->assertFalse($result);

        $result = Date::valid(-10);
        $this->assertTrue($result);
    }

    public function testIsLeapYear()
    {
        $this->assertTrue(Date::isLeapYear(2020));
        $this->assertFalse(Date::isLeapYear(2021));
    }

    public function testGetDay()
    {
        $day = Date::getDay($this->time);
        $this->assertEquals(3, $day);

        $day = Date::getDay();
        $this->assertMatchesRegularExpression('/[1-31]/', $day);

        $day = Date::getDay($this->time, true);
        $this->assertEquals('Tuesday', $day);

        $day = Date::getDay($this->time, true, true);
        $this->assertEquals('Tue', $day);
    }

    public function testGetMonth()
    {
        $month = Date::getMonth($this->time);
        $this->assertEquals(2, $month);

        $month = Date::getMonth();
        $this->assertMatchesRegularExpression('/[1-12]/', $month);


        $month = Date::getMonth($this->time, true);
        $this->assertEquals('February', $month);


        $month = Date::getMonth($this->time, true, true);
        $this->assertEquals('Feb', $month);
    }

    public function testGetYear()
    {
        $year = Date::getYear($this->time);
        $this->assertEquals(2026, $year);

        $year = Date::getYear();
        $this->assertMatchesRegularExpression('/[\d]{4}/', $year);
    }

    public function testGetHour()
    {
        $time = Date::getHour($this->time);
        $this->assertEquals(13, $time);

        $time = Date::getHour();
        $this->assertMatchesRegularExpression('/[0-23]/', $time);
    }

    public function testGetMinutes()
    {
        $time = Date::getMinutes($this->time);
        $this->assertEquals(42, $time);

        $time = Date::getMinutes();
        $this->assertMatchesRegularExpression('/[0-59]/', $time);
    }

    public function testGetSecond()
    {
        $time = Date::getSeconds($this->time);
        $this->assertEquals(49, $time);

        $time = Date::getSeconds();
        $this->assertMatchesRegularExpression('/[0-59]/', $time);
    }

    public function testGetWeek()
    {
        $time = Date::getWeek($this->time);
        $this->assertEquals('05', $time);

        $time = Date::getWeek();
        $this->assertMatchesRegularExpression('/[\d]{2}/', $time);
    }
}
