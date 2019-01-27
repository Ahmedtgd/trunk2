<?php
/**
 * Created by PhpStorm.
 */

namespace App\lib;

use DateTime;

class Date
{
    /**
     * @param type $date
     * @param type $format
     * @return type
     */
    function setDateFormat($date, $format)
    {
        $date_object = new DateTime($date);
        $date = $date_object->format($format);
        return $date;
    }

    /**
     * @param type $format
     */
    function getCurrentDateTime($format)
    {
        $date_object = new DateTime();
        $date = $date_object->format($format);
        return $date;
        // return date($format, time());
    }

    /**
     *
     * @param type $date
     * @param type $format
     * @param type $modifiedFormat
     * In place of modified date you can pass '+1 day' for next day date
     * you can pass '+1 year' for next year
     * you can pass '+1 month' for next month
     * you can pass '+1 week' for next week
     * @return type
     */
    function modifyDate($date, $format, $modifiedFormat)
    {
        $date_object = new DateTime($date);
        $date_object->modify($modifiedFormat);
        $date = $date_object->format($format);
        return $date;
    }
    /**
     * Display age in format:
     * '%y years, %m months and %d days old'
     * '%y years and %m months old'
     * '%m years and %d days old'
     *
     * @param  \DateTime $born
     * @param  \DateTime $reference
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    function age(DateTime $born, DateTime $reference = null,$InYears=false,$InMonths=false,$InDays=false)
    {
        $reference = $reference ?: new DateTime;

        if ($born > $reference)
            throw new \InvalidArgumentException('Provided birthday cannot be in future compared to the reference date.');

        $diff = $reference->diff($born);

        if($InYears==true) return $diff->y;
        if($InMonths==true) return "not implemented";
        if($InDays==true) return "not implemented";


        // Not very readable, but all it does is joining age
        // parts using either ',' or 'and' appropriately

        $ageDays = ($d = $diff->d) ? ' and '.$d.' '.str_plural('day', $d) : '';
        $ageMonths = ($m = $diff->m) ? ($ageDays ? ', ' : ' and ').$m.' '.str_plural('month', $m).$ageDays : $ageDays;
        $ageYears = ($y = $diff->y) ? $y.' '.str_plural('year', $y).$ageMonths  : $ageMonths;


        // trim redundant ',' or 'and' parts
        return ($s = trim(trim($ageYears, ', '), ' and ')) ? $s.' old' : 'newborn';
    }
}
