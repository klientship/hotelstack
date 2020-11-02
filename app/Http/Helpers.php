<?php
use Carbon\Carbon;

 class Helpers {

    public static function getNights($check_in, $check_out) {
        $date_check_in = Carbon::parse($check_in);
        $date_check_out = Carbon::parse($check_out);
    
            $hours = $date_check_out->diffInHours($date_check_in);
            $quotient = (int)($hours/24);
            $remainder =($hours % 24);
    
            $nights = $quotient;
            if ($remainder >= 2) {
                $nights += 1;
              } else if ($nights < 1) {
                $nights = 1;
              }
              return $nights;
        }

        public static function calculateTotalTax($nights, $rooms) {
             $total = 0;
             if($rooms) {
              foreach ($rooms as $key => $room) {
                $room_total = ((int)$room->price * (int)$nights);
                if ($room_total > 999 && $room_total < 2500) {
                  $total = $total + ($room_total * $room->room->room_type->tax_1) / 100;
                } else if ($room_total > 2499) {
                  $total = $total + ($room_total* $room->room->room_type->tax_2) / 100;
                }
              }

             }
            return $total;
        }

        public static function createUid($id) {
          $my_id = sprintf('%04d', $id);
          $uid = 'SSP' .  $my_id;
            return $uid;
        }

    public static function getThisMonth($class)
    {
      $date = Carbon::now();
        $year = $date->year;
        $month = $date->month;

        if ($month < 10) {
            $month = '0' . $month;
        }

        $search = $year . '-' . $month;

        $data = $class::where('created_at', 'like', $search .'%')->latest()->get();

        return $data;
    }

    public static function getLastMonth($class)
    {
      $date = Carbon::now();
      $year = $date->year;
      $month = $date->month - 1;

      if ($month < 10) {
          $month = '0' . $month;
      }

      $search = $year . '-' . $month;

        $data = $class::where('created_at', 'like', $search .'%')->latest()->get();

        return $data;
    }

    public static function invoice_total($invoices)
    {
      $total = 0;
      foreach($invoices as $invoice) 
      {
          $nights = self::getNights($invoice->reservation->check_in, $invoice->reservation->check_out);
          for ($i = 0; $i < sizeof($invoice->reservation->rooms); $i++) {
              if ($nights) {
                     $total += +$invoice->reservation->rooms[$i]->price * +$nights;
            }else {
              $total += +$invoice->reservation->rooms[$i]->price;
            }
          }
      }

      return $total;
    }

    public static function getSevenDays($array)
    {
  
       $data =  array_fill(0, 7, 0);
       for ($i=0; $i < 7; $i++) { 
 
       if(isset($array[$i]))
       {
         $data[$i] = $array[$i];
       }
      }
       return $data;
 
      
    }


 }