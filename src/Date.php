<?php

declare(strict_types=1);

namespace BlueTime;

use BlueTime\Simple\Date as SimpleDate;
use function time;
use function is_numeric;
use function is_array;
use function mktime;

class Date extends Calculation
{
    /**
     * error information
     * @var string
     */
    public string $err;

    /**
     * create date object with given timestamp, or current timestamp
     *
     * @param int|array|null $date unix timestamp, or array(hour, minute, second, day, month, year)
     * @example __construct(23424242);
     * @example __construct(array(15, 0, 0, 24, 9, 2011));
     */
    public function __construct(int|array|null $date = null)
    {
        if (empty($date)) {
            $this->unixTimestamp = time();
        } elseif (is_numeric($date)) {
            $this->unixTimestamp = $date;
        } elseif (is_array($date)) {
            $dateArray = [$date[5], $date[4], $date[3]];
            $valid = SimpleDate::valid($dateArray);

            if (!$valid) {
                $this->err = 'INVALID_TIME_FORMAT';
                return;
            }

            $this->unixTimestamp = mktime(
                $date[0],
                $date[1],
                $date[2],
                $date[4],
                $date[3],
                $date[5]
            );
        }
    }

    /**
     * return set up current timestamp
     *
     * @return int
     */
    public function getStamp(): int
    {
        return $this->unixTimestamp;
    }

    /**
     * allow to set new timestamp
     *
     * @param int $stamp
     * @return Date
     */
    public function setStamp(int $stamp): Date
    {
        $this->unixTimestamp = $stamp;

        return $this;
    }

    /**
     * return formatted time stored in object
     *
     * @return string
    */
    public function getFormattedTime(): string
    {
        return SimpleDate::getFormattedTime($this->unixTimestamp);
    }

    /**
     * return date in dd-mm-yyyy or yyyy-mm-dd if $type is set on true
     *
     * @param bool $type false -> dd-mm-yyyy, true -> yyyy-mm-dd
     * @return string
     * @example getDate() - 2013-07-24
     * @example getDate(true) - 24-07-2013
     */
    public function getDate(bool $type = false): string
    {
        return SimpleDate::getDate($this->unixTimestamp, $type);
    }
    
    /**
     * return time in hh-mm-ss format
     *
     * @return string
     */
    public function getTime(): string
    {
        return SimpleDate::getTime($this->unixTimestamp);
    }

    /**
     * return full or short month name, correct with set up localization
     *
     * @param bool $short if true return month name in short version
     * @return string
     */
    public function getMonthName(bool $short = false): string
    {
        return SimpleDate::getMonthName($this->unixTimestamp, $short);
    }

    /**
     * return name of fill or short day in week, correct with set up localization
     *
     * @param bool $short if true return day name in short version
     * @return string nazwa dnia w miesiacu
     */
    public function getDayName(bool $short = false): string
    {
        return SimpleDate::getDayName($this->unixTimestamp, $short);
    }

    /**
     * return current day or day name
     *
     * @param bool $name if true return day name
     * @param bool $short if true return day name in short version
     * @return string day name or number
     * @example getDay()
     * @example getDay(true) - name
     * @example getDay(true, true) - name short version
     */
    public function getDay(bool $name = false, bool $short = false): string
    {
        return SimpleDate::getDay($this->unixTimestamp, $name, $short);
    }

    /**
     * return day number in year
     *
     * @return int
     */
    public function getDayNumber(): int
    {
        return SimpleDate::getDayNumber($this->unixTimestamp);
    }

    /**
     * return number of days in month
     *
     * @return int
     */
    public function getDayCountInMonth(): int
    {
        return SimpleDate::getDayCountInMonth($this->unixTimestamp);
    }

    /**
     * return list of months in year, with month days number
     *
     * @return array
     */
    public function getMonths(): array
    {
        return SimpleDate::getMonths($this->unixTimestamp);
    }

    /**
     * check that year is leap-year
     * if is return true
     *
     * @return bool
     */
    public function isLeapYear(): bool
    {
        return SimpleDate::isLeapYear($this->unixTimestamp);
    }

    /**
     * return current month number or its name
     *
     * @param bool $name if true return month name
     * @param bool $short if true return month name in short version
     * @return string month name or number
     * @example miesiac()
     * @example miesiac(1)
     * @example miesiac(1, 1)
     */
    public function getMonth(bool $name = false, bool $short = false): string
    {
        return SimpleDate::getMonth($this->unixTimestamp, $name, $short);
    }

    /**
     * return year
     * @return int
     */
    public function getYear(): int
    {
        return SimpleDate::getYear($this->unixTimestamp);
    }

    /**
     * return hour
     *
     * @return int
     */
    public function getHour(): int
    {
        return SimpleDate::getHour($this->unixTimestamp);
    }

    /**
     * return minutes
     *
     * @return int
     */
    public function getMinutes(): int
    {
        return SimpleDate::getMinutes($this->unixTimestamp);
    }

    /**
     * return seconds
     *
     * @return int
     */
    public function getSeconds(): int
    {
        return SimpleDate::getSeconds($this->unixTimestamp);
    }

    /**
     * week number in year, correct with ISO8601:1998
     *
     * @return int
     */
    public function getWeek(): int
    {
        return SimpleDate::getWeek($this->unixTimestamp);
    }

    /**
     * compare two dates, and check that rae the same
     *
     * @param Date $data
     * @return bool return true if dates are the same
     */
    public function compareDates(Date $data): bool
    {
        return $data->getStamp() === $this->unixTimestamp;
    }

    /**
     * return list of differences between dates, or value or specific difference
     * if date in object is older, return as positive value, if younger, wil return negative
     * if some value is same, will return 0
     * default differences will return sec, min, hour, day, week, months, years
     *
     * @param Date $data
     * @param string|null $differenceType type of differences (default all)
     * @param bool $relative if false will return absolute comparison, else depending of other parameters
     * @return array|float|int return difference, or array of differences
     * @example diff($data_object, 0, 1)
     * @example diff($data_object)
     * @example diff($data_object, 'days', 1)
     * @example diff($data_object, 'weeks', 0)
     * @example diff($data_object, 'hours')
     */
    public function getDifference(
        Date $data,
        ?string $differenceType = null,
        bool $relative = false
    ): array|float|int {
        return match ($differenceType) {
            'seconds' => $this->getSecondsDifference($data, $relative),
            'years' => $this->getYearsDifference($data, $relative),
            'months' => $this->getMonthsDifference($data, $relative),
            'weeks' => $this->getWeeksDifference($data, $relative),
            'days' => $this->getDaysDifference($data, $relative),
            'hours' => $this->getHoursDifference($data, $relative),
            'minutes' => $this->getMinutesDifference($data, $relative),
            default => [
                'seconds' => $this->getSecondsDifference($data, $relative),
                'years'   => $this->getYearsDifference($data, $relative),
                'months'  => $this->getMonthsDifference($data, $relative),
                'weeks'   => $this->getWeeksDifference($data, $relative),
                'days'    => $this->getDaysDifference($data, $relative),
                'hours'   => $this->getHoursDifference($data, $relative),
                'minutes' => $this->getMinutesDifference($data, $relative)
            ],
        };
    }

    /**
     * return formatted time while object is used as string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFormattedTime();
    }

    /**
     * return formatted time, correct with strftime() function
     * all depends from set localization
     * d - Day of the month with leading zeros (01 to 31)
     * D - A textual representation of a day, three letters (Mon through Sun)
     * j - Day of the month without leading zeros (1 to 31)
     * l - A full textual representation of the day (Sunday through Saturday)
     * N - ISO-8601 numeric day of the week (1=Monday to 7=Sunday)
     * w - Numeric day of the week (0=Sunday to 6=Saturday)
     * z - Day of the year (0 to 365)
     * W - ISO-8601 week number of year, weeks starting on Monday
     * F - A full textual representation of a month (January through December)
     * m - Month as a number with leading zeros (01 to 12)
     * M - A short textual representation of a month (Jan through Dec)
     * n - Month without leading zeros (1 to 12)
     * t - Number of days in the given month
     * L - Whether it's a leap year (1 or 0)
     * Y - A full four digit year
     * y - A two digit year
     * a - Lowercase Ante meridiem and Post meridiem (am or pm)
     * A - Uppercase Ante meridiem and Post meridiem (AM or PM)
     * g - 12-hour format without leading zeros (1 to 12)
     * G - 24-hour format without leading zeros (0 to 23)
     * h - 12-hour format with leading zeros (01 to 12)
     * H - 24-hour format with leading zeros (00 to 23)
     * i - Minutes with leading zeros (00 to 59)
     * s - Seconds with leading zeros (00 to 59)
     * i - Minutes with leading zeros (00 to 59)
     * a - Lowercase Ante meridiem and Post meridiem (am or pm)
     * h:i:s A - time in a.m. or p.m. notation
     * H:i - time in 24-hour notation
     * s - Seconds with leading zeros (00 to 59)
     * H:i:s - current time
     * N - ISO-8601 numeric day of the week (1=Monday to 7=Sunday)
     * W - ISO-8601 week number of year, weeks starting on Monday
     * V - ISO-8601 week number of year (01 to 53)
     * W - Week number of the year
     * w - Numeric representation of the day of the week (0=Sunday to 6=Saturday)
     * d/m/Y - localized date format
     * H:i:s - localized time format
     * y - Two digit representation of the year
     * Y - Full numeric representation of a year, 4 digits
     * T - Timezone abbreviation
     * % - Literal % character
     *
     * @param string $format
     * @return string
     * @example getOtherFormats("%A - day name correct with localization ")
     */
    public function getOtherFormats(string $format): string
    {
        return date($format, $this->unixTimestamp);
    }

    /**
     * check that date is correct
     *
     * @return bool
     */
    public function checkDate(): bool
    {
        return SimpleDate::valid($this->unixTimestamp);
    }
}
