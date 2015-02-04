<?php

/**
 * Class Carbon
 *
 *
 *  Ozsa framework gün ve yılla ilgili işlemlerin yapılacağı sınıf
 *
 *
 *
 * @version 1.1
 *
 *
 */

 class Carbon
 {
     /**
      * @var array
      *
      *  Günlerin string olarak yazılışı
      *
      *
      */
     private $days = array(
         0 => 'Monday',
         1 => 'Tuesday',
         2 => 'Wednesday',
         3 => 'Thursday',
         4 => 'Friday',
         5 => 'Saturday',
         6 => 'Sunday'
     );
     /**
      * @var array
      *
      *  Yılların yazılışı
      */
     private $months = array(
         1 => 'January',
         2 => 'February',
         3 => 'March',
         4 => 'April',
         5 => 'May',
         6 => 'June',
         7 => 'July',
         8 => 'August',
         9 => 'September',
         10 => 'October',
         11 => 'November',
         12 => 'December'
     );

     protected $time ;
     protected $minute;
     protected $month;
     protected $hour;
     protected $day;
     protected $sday;
     protected $week;
     protected $year;
     protected $dateFormat = 'd.m.Y';
     protected $timeFormat = 'H:i';
     protected static $format = 'd.m.Y H:i';

     /**
      * @param $time
      */
     public function __construct($time)
     {
         $this->time = $time;
         $this->parse();
     }

     /**
      * @return static
      */
     public static function now()
     {
         return new static(self::$format);
     }


     private function parse()
     {
         $ayir = explode(' ',$this->time);

         $this->parseTime($ayir[1]);

         $this->parseDate($ayir[0]);
     }

     /**
      * @param $time
      * @param bool $return
      * @return array
      */
     private function parseTime($time,$return = false)
     {
         $ayir = explode(':',$time);
         if(!$return)
         {
             $this->hour = $ayir[0];
             $this->minute = $ayir[1];
         }else{
             return array(
                 'hours' => $ayir[0],
                 'minute' => $ayir[1]);
         }


     }

     /**
      * @param $date
      */
     public function parseDate($date)
     {
         $ayir =  explode('.',$date);
         $this->day = $ayir[0];
         $this->month = $ayir[1];
         $this->year = $ayir[2];
         $this->parseWeek();
     }


     private function parseWeek()
     {
         $bol = ($this->day / count($this->days));

         $ybol = ($this-> day % count($this->days));

         $this->week = array(
             'week' => $bol,
             'artday' => $ybol
         );

         $this->sday = $this->days[$ybol];
     }

     /**
      * @param $hours
      * @return null
      */
      private function hourstominute($hours)
         {
           if($hours < 24)
           {
               return $hours*60;
           }
             else{
                 return null;
             }
         }

     /**
      * @param $minute
      * @return null
      */
     private function minutetosecond($minute)
     {
         if($minute < 60)
         {
             return $minute*60;
         }else{
             return null;
         }
     }

     /**
      * @param $second
      * @return mixed
      */
     public function addSecond($second)
     {
         return $second;
     }

     /**
      * @param $min
      * @return mixed
      */
     public function addMinute($min)
     {

             return $this->addSecond(60)*$min;


     }

     /**
      * @param string $format
      */
     public static function setDateFormat($format = 'd.m.Y H:i')
     {
         self::$format = $format;
     }

     /**
      * @param $hours
      * @return mixed
      */

     public function addHours($hours)
     {
         return $hours*$this->addMinute(60);
     }

     /**
      * @param $day
      * @return mixed
      */

     public function addDay($day)
     {

         return $day*$this->addHours(24);
     }

     /**
      * @param $month
      * @return mixed
      */

     public function addMonth($month)
     {

         return $month*$this->addDay(30);
     }

     /**
      * @param $week
      * @return mixed
      */

     public function addWeek($week)
     {
         return $week*$this->addDay(7);
     }

     /**
      * @param $year
      * @return mixed
      */

     public function addYear($year)
     {
         return $year*$this->addMonth(12);
     }

     /**
      * @return mixed
      */

     public function returnNowMonthString()
     {
         return $this->months[$this->month];
     }

     /**
      * @return mixed
      */

     public function returnNowDayString()
     {
         return $this->days[$this->day];
     }

     /**
      * @param $day
      * @return mixed
      */

     public function returnDaySting($day)
     {
         return $this->days[$day];
     }

     /**
      * @param $month
      * @return mixed
      */

     public function returnMonthString($month)
     {
         return $this->months[$month];
     }

     /**
      * @return array
      */

     public function returnDateArrayString()
     {
         return array(
             'day' => $this->days[$this->day],
             'week' => $this->week,
             'month' => $this->months[$this->month],
             'hours' => $this->hour,
             'minute' => $this->minute,
         );
     }

     /**
      * @return array
      */

     public function  returnDateArray()
     {
         return array(
             'day' => $this->day,
             'week' => $this->week,
             'month' => $this->month,
             'hours' => $this->hour,
             'minute' => $this->minute,
         );
     }





 }