<?php

namespace BlueTime\Test;

use BlueTime\Date;
use PHPUnit\Framework\TestCase;

class DateObjectTest extends TestCase
{
    protected $time = 1770126169;

    public function testCreateObject()
    {
        $date = new Date();
        $this->assertInstanceOf(Date::class, $date);
        $this->assertMatchesRegularExpression('/[\d]*/', $date->getStamp());

        $date = new Date(1770126169);
        $this->assertInstanceOf(Date::class, $date);
        $this->assertEquals(1770126169, $date->getStamp());

        $date = new Date([15, 0, 0, 24, 9, 2011]);
        $this->assertInstanceOf(Date::class, $date);
        $this->assertEquals(1316876400, $date->getStamp());
    }

    public function testCreateInvalidObject()
    {
        $date = new Date([15, 0, 0, 2011, 9, 1]);
        $this->assertInstanceOf(Date::class, $date);
        $this->assertEquals(0, $date->getStamp());
        $this->assertEquals('INVALID_TIME_FORMAT', $date->err);
    }
    
    public function testSetStamp()
    {
        $date = new Date();
        $date->setStamp($this->time);
        
        $this->assertEquals(1770126169, $date->getStamp());
    }

    public function testGetFormattedTime()
    {
        $date = new Date($this->time);
        $this->assertEquals('2026-02-03 - 13:42:49', $date->getFormattedTime());
    }

    public function testGetDate()
    {
        $date = new Date($this->time);
        $this->assertEquals('2026-02-03', $date->getDate());
    }

    public function testGetTime()
    {
        $date = new Date($this->time);
        $this->assertEquals('13:42:49', $date->getTime());
    }

    public function testGetMonthName()
    {
        $date = new Date($this->time);
        $this->assertEquals('February', $date->getMonthName());
    }

    public function testGetDayName()
    {
        $date = new Date($this->time);
        $this->assertEquals('Tuesday', $date->getDayName());
    }

    public function testGetDay()
    {
        $date = new Date($this->time);
        $this->assertEquals('03', $date->getDay());
    }

    public function testGetDayNumber()
    {
        $date = new Date($this->time);
        $this->assertEquals(34, $date->getDayNumber());
    }

    public function testGetDayCountInMonth()
    {
        $date = new Date($this->time);
        $this->assertEquals(28, $date->getDayCountInMonth());
    }

    public function testGetMonths()
    {
        $date = new Date($this->time);
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
            $date->getMonths()
        );
    }

    public function testIsLeapYear()
    {
        $date = new Date($this->time);
        $this->assertFalse($date->isLeapYear());
    }

    public function testGetMonth()
    {
        $date = new Date($this->time);
        $this->assertEquals('02', $date->getMonth());
    }

    public function testGetYear()
    {
        $date = new Date($this->time);
        $this->assertEquals(2026, $date->getYear());
    }
    
    public function testGetHour()
    {
        $date = new Date($this->time);
        $this->assertEquals('13', $date->getHour());
    }
    
    public function testGetMinutes()
    {
        $date = new Date($this->time);
        $this->assertEquals('42', $date->getMinutes());
    }
    
    public function testGetSeconds()
    {
        $date = new Date($this->time);
        $this->assertEquals('49', $date->getSeconds());
    }
    
    public function testGetWeek()
    {
        $date = new Date($this->time);
        $this->assertEquals(6, $date->getWeek());
    }
    
    public function testCompareDates()
    {
        $date = new Date($this->time);
        $date2 = new Date($this->time);
        $date3 = new Date($this->time + 1000);
        
        $this->assertTrue($date->compareDates($date2));
        $this->assertFalse($date->compareDates($date3));
    }

    public function testGetDfference()
    {
        $date = new Date($this->time);
        $date2 = new Date($this->time + 100000000);

        $this->assertEquals(
            [
                "seconds" => 100000000,
                "years" => 3.17098,
                "months" => 38.58025,
                "weeks" => 165.34392,
                "days" => 1157.40741,
                "hours" => 27777.77778,
                "minutes" => 1666666.66667,
            ],
            $date->getDifference($date2)
        );

        $this->assertEquals(
            [
                "seconds" => 20,
                "years" => 3.0,
                "months" => 2.0,
                "weeks" => 8.0,
                "days" => 2.0,
                "hours" => 10.0,
                "minutes" => 13.0,
            ],
            $date->getDifference($date2, null, true)
        );

        $this->assertEquals(
            [
                "seconds" => -20.0,
                "years" => -3.0,
                "months" => -2.0,
                "weeks" => -8.0,
                "days" => -2.0,
                "hours" => -10.0,
                "minutes" => -13.0,
            ],
            $date2->getDifference($date, null, true)
        );

        $this->assertEquals(
            -20.0,
            $date2->getDifference($date, 'seconds', true)
        );

        $this->assertEquals(
                -13.0,
            $date2->getDifference($date, 'minutes', true)
        );

        $this->assertEquals(
                -3.0,
            $date2->getDifference($date, 'years', true)
        );

        $this->assertEquals(
                -2.0,
            $date2->getDifference($date, 'months', true)
        );

        $this->assertEquals(
                -8.0,
            $date2->getDifference($date, 'weeks', true)
        );

        $this->assertEquals(
                -2.0,
            $date2->getDifference($date, 'days', true)
        );

        $this->assertEquals(
                -10.0,
            $date2->getDifference($date, 'hours', true)
        );
    }

    public function testToString()
    {
        $date = new Date($this->time);

        $this->assertEquals('2026-02-03 - 13:42:49', (string) $date);
    }

    public function testGetOtherFormats()
    {
        $date = new Date($this->time);

        $this->assertEquals('03/02/2026', $date->getOtherFormats('d/m/Y'));
        $this->assertEquals('02-03-2026', $date->getOtherFormats('m-d-Y'));
        $this->assertEquals('2026.02.03', $date->getOtherFormats('Y.m.d'));
    }

    public function testCheckDate()
    {
        $date = new Date($this->time);
        $this->assertTrue($date->checkDate());
    }
}
