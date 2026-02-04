<?php

declare(strict_types=1);

namespace BlueTime\Simple;

use function time;
use function date;
use function mktime;
use function getdate;
use function checkdate;

class Date
{
    /**
     * return formatted current time
     *
     * @param int|null $stamp optionally unix timestamp
     * @return string
    */
    public static function getFormattedTime(?int $stamp = null): string
    {
        $cfg = 'Y-m-d - H:i:s';

        if (!$stamp) {
            $stamp = time();
        }

        return date($cfg, $stamp);
    }

    /** return date formatted in dd-mm-yyyy or in yyyy-mm-dd
     *
     * @param int|null $stamp optionally unix timestamp
     * @param bool $yearLast type of returned date, if true year will be last
     * @return string
     * @example getDate(null, true)
     * @example getDate()
     * @example getDate(2354365346)
     */
    public static function getDate(?int $stamp = null, bool $yearLast = false): string
    {
        if (!$stamp) {
            $stamp = time();
        }

        if ($yearLast) {
            return date('d-m-Y', $stamp);
        }

        return date('Y-m-d', $stamp);
    }

    /**
     * return time in hh-mm-ss format
     *
     * @param int|null $stamp optionally unix timestamp
     * @return string
     */
    public static function getTime(?int $stamp = null): string
    {
        if (!$stamp) {
            $stamp = time();
        }

        return date('H:i:s', $stamp);
    }

    /**
     * return name of month
     * in example, month length = 2764800s (60*60*24*32)
     *
     * @param int|null|array $stamp optionally unix timestamp
     * @param bool $short if true return name in short version
     * @return string
     * @example monthName() - current month name
     * @example monthName(254543534); - name of month from given timestamp
     * @example monthName(array(12, 12, 1983)) - name of month from given date array
     */
    public static function getMonthName(null|array|int $stamp = null, bool $short = false): string
    {
        $monthType = 'F';

        if (\is_array ($stamp)) {
            $stamp = self::convertToDate($stamp);
        }

        if (!$stamp) {
            $stamp = time();
        }

        if ($short) {
            $monthType = 'M';
        }

        return date($monthType, $stamp);
    }

    /**
     * return day name in week
     * in example, day length = 90000s (60*60*22)
     *
     * @param int|null|array $stamp unix timestamp or array (day, month, year) or day number as string
     * @param bool $short if true will return a short version of day name
     * @return string day name
     * @example getDayName();
     * @example getDayName(23424234);
     * @example getDayName(array(12, 12, 1983))
     */
    public static function getDayName(null|int|array $stamp = null, bool $short = false): string
    {
        $dayType = 'l';

        if (\is_array ($stamp)) {
            $stamp = self::convertToDate($stamp);
        }

        if (!$stamp) {
            $stamp = time();
        }

        if ($short) {
            $dayType = 'D';
        }

        return date($dayType, $stamp);
    }

    /**
     * return number of day in year (from 1 to 356)
     * number of month or day in year without 0 at start
     *
     * @param null|int|array $stamp unix timestamp or array (day, month, year)
     * @return int
     * @example getDayNumber();
     * @example getDayNumber(23424234);
     * @example getDayNumber(array(12, 12, 1983))
     */
    public static function getDayNumber(int|null|array $stamp = null): int
    {
        if (\is_array ($stamp)) {
            $stamp = self::convertToDate($stamp);
        }

        if (!$stamp) {
            $stamp = time();
        }

        $tab = getdate($stamp);
        return $tab['yday'] +1;
    }

    /**
     * return number of days in month
     *
     * @param int|array|null $stamp unix timestamp or array(month, year) if null use current month
     * @return int
     * @example getDayInMonth()
     * @example getDayInMonth(34234234)
     * @example getDayInMonth(array(12, 1983))
     */
    public static function getDayCountInMonth(null|array|int $stamp = null): int
    {
        if (\is_array ($stamp)) {
            if (\count($stamp) <= 2) {
                $stamp = [1, $stamp[0], $stamp[1]];
            }
            $stamp = self::convertToDate($stamp);
        }

        if (!$stamp) {
            $stamp = time();
        }

        $month = self::getMonth($stamp);
        $year = self::isLeapYear(self::getYear($stamp));

        return match ($month) {
            '01', '03', '05', '07', '08', '10', '12' => 31,
            '04', '06', '09', '11' => 30,
            '02' => $year ? 29 : 28,
            default => 0,
        };
    }

    /**
     * return array of months with days in year
     *
     * @param int|null $stamp unix timestamp, if null current year, if string year
     * @param bool $isYear
     * @return array
     * @example getMonths()
     * @example getMonths(23423423423)
     * @example getMonths(2011, true)
     */
    public static function getMonths(?int $stamp = null, bool $isYear = false): array
    {
        if ($isYear) {
            $stamp = self::convertToDate([1, 1, $stamp]);
        }

        if (!$stamp) {
            $stamp = time();
        }

        $list = [];
        $year = self::getYear($stamp);

        for ($i = 1; $i <= 12; $i++) {
            $list[$i] = self::getDayCountInMonth([$i, $year]);
        }

        return $list;
    }

    /**
     * check that date is correct
     *
     * @param int|array|null $stamp unix timestamp, date array or current date
     * @return bool return true if date is correct
     * @example valid()
     * @example valid(34234234)
     * @example valid(array(12, 12, 1983)) day, month, year
     */
    public static function valid(int|array|null $stamp = null): bool
    {
        if (is_array($stamp) && isset($stamp[0], $stamp[1], $stamp[2])) {
            [$year, $month, $day] = $stamp;
        } else {

            $month = (int) self::getMonth($stamp);
            $year = self::getYear($stamp);
            $day = (int) self::getDay($stamp);
        }

        return checkdate($month, $day, $year);
    }

    /**
     * check that year is leap-year
     *
     * @param int|null $year year to check, or current year
     * @return bool true if year is an leap-year
     */
    public static function isLeapYear(?int $year = null): bool
    {
        if (!$year) {
            $year = self::getYear();
        }

        return ($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0;
    }

    /**
     * return given from unix timestamp or current day or ith name in month
     *
     * @param int|null $stamp
     * @param bool $name if true return as name
     * @param bool $short if true return as short name
     * @return string
     * @example getDay()
     * @example getDay(252453, false, true)
     * @example getDay(null, false, true)
     * @example getDay(2423424, true, true)
     */
    public static function getDay(?int $stamp = null, bool $name = false, bool $short = false): string
    {
        if(!$stamp){
            $stamp = time();
        }

        if ($name) {
            if ($short) {
                return self::getDayName($stamp, true);
            }

            return self::getDayName($stamp);
        }

        return date('d', $stamp);
    }

    /**
     * current month or given from timestamp
     *
     * @param int|null $stamp
     * @param bool $name if true return as name
     * @param bool $short if true return as short name
     * @return string
     * @example getMonth(3424234, true)
     * @example getMonth()
     * @example getMonth(234234234, true, true) short version
     */
    public static function getMonth(?int $stamp = null, bool $name = false, bool $short = false): string
    {
        if (!$stamp) {
            $stamp = time();
        }

        if ($name) {
            if ($short) {
                return self::getMonthName($stamp, true);
            }

            return self::getMonthName($stamp);
        }

        return date('m', $stamp);
    }

    /**
     * current year, or given in timestamp
     *
     * @param int|null $stamp
     * @return int
     */
    public static function getYear(?int $stamp = null): int
    {
        if (!$stamp) {
            $stamp = time();
        }

        return (int) date('Y', $stamp);
    }

    /**
     * return current hour, or given in timestamp
     *
     * @param int|null $stamp
     * @return int
     */
    public static function getHour(?int $stamp = null): int
    {
        if (!$stamp) {
            $stamp = time();
        }

        return (int) date('H', $stamp);
    }

    /**
     * return current minute or given in timestamp
     *
     * @param int|null $stamp
     * @return int
     */
    public static function getMinutes(?int $stamp = null): int
    {
        if (!$stamp) {
            $stamp = time();
        }

        return (int) date('i', $stamp);
    }

    /**
     * return current second or given in timestamp
     *
     * @param int|null $stamp
     * @return int
     */
    public static function getSeconds(?int $stamp = null): int
    {
        if (!$stamp) {
            $stamp = time();
        }

        return (int) date('s', $stamp);
    }

    /**
     * return current week number or given in timestamp correct with ISO8601:1998
     *
     * @param int|null $stamp
     * @return int
     */
    public static function getWeek(?int $stamp = null): int
    {
        if (!$stamp) {
            $stamp = time();
        }

        return (int) date('W', $stamp);
    }

    /**
     * convert date array to unix timestamp
     */
    protected static function convertToDate(array $date): int
    {
        if (!isset($date[0], $date[1], $date[2])) {
            throw new \InvalidArgumentException('Date array must contain exactly three elements: day, month, year.');
        }

        return mktime(0, 0, 0, $date[1], $date[0], $date[2]);
    }
}
