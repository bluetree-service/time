<?php

/**
 * @author Michał Adamiak <michal.adamiak@orba.co>
 * @copyright Copyright (C) 2026 Orba Sp. z o.o. (http://orba.pl)
 */

declare(strict_types=1);

namespace BlueTime;

abstract class Calculation
{
    /**
     * contains unix timestamp
     * @var int
     */
    protected int $unixTimestamp = 0;

    /**
     * return differences between given values
     * @param int|string $value1
     * @param int|string $value2
     * @param Date $date
     * @param bool $relative absolute difference, or depending of set time
     * @param string $additionalCalculation type of difference
     * @return float difference
     */
    protected function calculateDifference(
        int|string $value1,
        int|string $value2,
        Date $date,
        bool $relative,
        string $additionalCalculation
    ): float {
        $stamp = $date->getStamp();

        if ($relative) {
            $diff = $value1 - $value2;
        } else {
            $diff = $this->calculateTimeDifference($date);

            $diff = match ($additionalCalculation) {
                'seconds' => $diff,
                'minutes' => $diff / 60,
                'hours' => $diff / 60 / 60,
                'days' => $diff / 24 / 60 / 60,
                'weeks' => $diff / 7 / 24 / 60 / 60,
                'months' => $diff / 30 / 24 / 60 / 60,
                'years' => $diff / 365 / 24 / 60 / 60,
            };
        }

        return $this->calculateSign($diff, $stamp);
    }

    /**
     * return differences between seconds
     *
     * @param Date $date
     * @param bool $relative absolute difference, or depending of set time
     * @return int difference
     */
    protected function getSecondsDifference(Date $date, bool $relative): int
    {
        return (int) $this->calculateDifference(
            $this->getSeconds(),
            $date->getSeconds(),
            $date,
            $relative,
            'seconds'
        );
    }

    /**
     * return differences between minutes
     *
     * @param Date $date
     * @param bool $relative absolute difference, or depending of set time
     * @return float difference
     */
    protected function getMinutesDifference(Date $date, bool $relative): float
    {
        return $this->calculateDifference(
            $this->getMinutes(),
            $date->getMinutes(),
            $date,
            $relative,
            'minutes'
        );
    }

    /**
     * return differences between hours
     *
     * @param Date $date
     * @param bool $relative absolute difference, or depending of set time
     * @return float difference
     */
    protected function getHoursDifference(Date $date, bool $relative): float
    {
        return $this->calculateDifference(
            $this->getHour(),
            $date->getHour(),
            $date,
            $relative,
            'hours'
        );
    }

    /**
     * return differences between weeks
     *
     * @param Date $date
     * @param bool $relative absolute difference, or depending of set time
     * @return float difference
     */
    protected function getWeeksDifference(Date $date, bool $relative): float
    {
        return $this->calculateDifference(
            $this->getWeek(),
            $date->getWeek(),
            $date,
            $relative,
            'weeks'
        );
    }

    /**
     * return differences between days
     *
     * @param Date $date
     * @param bool $relative absolute difference, or depending of set time
     * @return float difference
     */
    protected function getDaysDifference(Date $date, bool $relative): float
    {
        return $this->calculateDifference(
            $this->getDay(),
            $date->getDay(),
            $date,
            $relative,
            'days'
        );
    }

    /**
     * return differences between months
     *
     * @param Date $date
     * @param bool $relative absolute difference, or depending of set time
     * @return float difference
     */
    protected function getMonthsDifference(Date $date, bool $relative): float
    {
        return $this->calculateDifference(
            $this->getMonth(),
            $date->getMonth(),
            $date,
            $relative,
            'months'
        );
    }

    /**
     * return differences between years
     *
     * @param Date $date
     * @param bool $relative
     * @return float difference
     */
    protected function getYearsDifference(Date $date, bool $relative): float
    {
        return $this->calculateDifference(
            $this->getYear(),
            $date->getYear(),
            $date,
            $relative,
            'years'
        );
    }

    /**
     * check if value should be positive or negatove
     */
    private function calculateSign(float $value, int $stamp): float
    {
        $diff = $this->unixTimestamp <=> $stamp;
        $value = \round(\abs($value), 5);

        return match ($diff) {
            0 => 0,
            -1 => $value,
            1 => -$value,
        };
    }

    /**
     * return difference between seconds for given time
     *
     * @param Date $data
     * @return int difference
     */
    private function calculateTimeDifference(Date $data): int
    {
        return $this->unixTimestamp - $data->getStamp();
    }
}
