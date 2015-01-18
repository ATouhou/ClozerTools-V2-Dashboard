<?php
class Stats
{ 

  // Helper functions (dates etc)
  public static function getDatesOfWeek($week, $year){
    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7*$week)+1-$day)*24*3600;
    $return[0] = date('Y-m-d', $time);
    $time += 6*24*3600;
    $return[1] = date('Y-m-d', $time);
    return $return;
  }

    public static function get1standLastofMonth($date){
      $return[0] = date('Y-m-01', strtotime($date));
      $return[1] = date('Y-m-t', strtotime($date));
      if(!empty($return)){
        return $return;
      } else {
        return false;
      }
  }

  public static function decimalTime($time) 
  {
    $timeArr = explode(':', $time);
        if (count($timeArr) == 3) {
            $decTime = ($timeArr[0]*60) + ($timeArr[1]) + ($timeArr[2]/60);         
        } else if (count($timeArr) == 2) {
                $decTime = ($timeArr[0]) + ($timeArr[1]/60);
        } else if (count($timeArr) == 1) {
                $decTime = $time;       
        }
    return $decTime;
  }


  // THe MAIN stats function
  // Start Date = $datemin
  // End Date = $datemax
  // City = $city
  // Rep = $rep
  // Usertype = $usertype
  public static function saleStats($datemin,$datemax,$city){
      if($datemin=="MONTH"){
        $dates = Stats::getMonthandWeek();
        $datemin = $dates['month']['start'];
        $datemax = $dates['month']['end'];
      } else if($datemin=="WEEK"){
        $dates = Stats::getMonthandWeek();
        $datemin = $dates['week']['start'];
        $datemax = $dates['week']['end'];
      } else if($datemin=="ALLTIME"){
        $datemin = "2010-01-01";
        $datemax = "2020-01-01";
      }
      $company = explode("-",Setting::find(1)->title);
      $company = $company[0];
      $shortcode = Setting::find(1)->shortcode;
      $weekdetails = DB::query("SELECT *, IF(sales + puton, 100*sales/puton, NULL) AS close, IF(puton+tot, 100*puton/tot, NULL) AS complete
      FROM (SELECT COUNT(*) as tot,rep_name, rep_id, 
      SUM(status!='DISP') tots,
      SUM(status='RB-OF' ) rbof, SUM(status='RB-TF') rbtf, SUM(status='CXL') cxl, SUM(systemsale='defender') def, SUM(systemsale='majestic') maj, SUM(systemsale='2maj') twomaj, SUM(systemsale='3maj') threemaj, SUM(systemsale='system') sys, 
      SUM(systemsale='supersystem') super, SUM(systemsale='megasystem') mega, SUM(systemsale='novasystem') nova, 
      SUM(systemsale='supernova') supernova, SUM(systemsale='2system') twosystem, SUM(systemsale='2defenders') twodef, 
      SUM(systemsale='3defenders') threedef, SUM(systemsale='other') other,
      SUM(status='CXL' AND rep_id!=0) cxlrep,SUM(status='RB-OF' AND rep_id!=0) rbofrep, SUM(status='RB-TF' AND rep_id!=0) rbtfrep, SUM(status='DNS')dns, SUM(status='INC') inc, SUM(status='SOLD') sales,
      SUM(status='DNS' OR status='SOLD') puton, SUM(status='NQ') nq,SUM(status='DISP') disp, SUM(status!='RB-TF' AND status!='RB-OF') total_booked
      FROM appointments WHERE app_date >= DATE('".$datemin."') AND app_date <= DATE('".$datemax."') $city GROUP BY rep_name ORDER BY puton) as SUBQUERY ");
      
      $saledetails = DB::query("SELECT COUNT(*) as tot, user_id, sold_by, SUM(picked_up=0) nettot, SUM(typeofsale='defender') def,
      SUM(typeofsale='majestic') maj,SUM(typeofsale='2maj') twomaj, SUM(typeofsale='3maj') threemaj, SUM(typeofsale='system') system, SUM(status='COMPLETE' OR status='PAID') net,
      SUM(status='CANCELLED' OR status='TURNDOWN' OR status='TBS') cxl,
      SUM(typeofsale='supersystem') super, SUM(typeofsale='novasystem') nova, SUM(typeofsale='supernova') supernova, SUM(typeofsale='megasystem') mega,
      SUM(typeofsale='2defenders') twodef, SUM(typeofsale='3defenders') threedef,
      SUM(typeofsale='2system') twosystem,
      SUM(typeofsale='defender' AND (picked_up=0)) netdef, SUM((picked_up=0) AND typeofsale='majestic') netmaj,
      SUM((picked_up=0) AND typeofsale='2maj') nettwomaj,SUM((picked_up=0) AND typeofsale='3maj') netthreemaj, 
      SUM((picked_up=0) AND typeofsale='system') netsys, SUM((picked_up=0) AND typeofsale='2system') nettwosys, SUM((picked_up=0) AND typeofsale='supersystem') netsuper, 
      SUM((picked_up=0) AND typeofsale='megasystem') netmega, SUM((picked_up=0) AND typeofsale='novasystem') netnova, SUM((picked_up=0) AND typeofsale='supernova') netsupernova,
      SUM((picked_up=0) AND typeofsale='3defenders') netthreedef, 
      SUM((picked_up=0) AND typeofsale='2defenders') nettwodef,
      SUM((picked_up=0) AND typeofsale='other') other
      FROM sales WHERE date >= DATE('".$datemin."') AND date <= DATE('".$datemax."') $city GROUP BY user_id ");
      
      $othersales = Sale::where('typeofsale','=','other')->where('date','>=',$datemin)->where('date','<=',$datemax)->get();


      $salesarray=array();

      $disp=0;$dns=0;$cxl=0;$inc=0;$rbofrep=0 ;$rbtfrep=0; $cxlrep=0;$puton=0;$rbtf=0;$rbof=0;$close=0;$complete=0;$allapp=0;$sold=0;$nq=0;
      $gmaj=0;$nmaj=0;$gdef=0;$gmaj=0;$system_points=0;$gold_points=0;$silver_points=0;$bronze_points=0;
      foreach($weekdetails as $w){
        if($w->sales!=0 || $w->dns!=0){
          $com = 100-(($w->sales+$w->dns)/($w->sales+$w->dns+$w->inc+$w->rbtf+$w->rbof+$w->cxl))*100;
        } else {
          $com = 0;
        }
        $disp+=$w->disp;$dns+=$w->dns;$rbofrep+=$w->rbofrep ;$rbtfrep+=$w->rbtfrep ; $cxlrep+=$w->cxlrep;$cxl+=$w->cxl;$inc+=$w->inc;$rbtf+=$w->rbtf;$rbof+=$w->rbof;$nq+=$w->nq;
        $puton+=$w->puton;$allapp+=$w->total_booked;$sold+=$w->sales;

        if($w->rep_id!=0){
          $user = User::find($w->rep_id);
          if($user){
            $system_points+=$user->system_points;$gold_points+=$user->gold_points;$silver_points+=$user->silver_points;
            $bronze_points+=$user->bronze_points;
        $salesarray[$w->rep_id] = array(
          "name"=>$w->rep_name,
          "avatar"=>$user->avatar_link(),
          "system_points"=>$user->system_points,
          "bronze_points"=>$user->bronze_points,
          "silver_points"=>$user->silver_points,
          "gold_points"=>$user->gold_points,
          "company"=>$company,
          "shortcode"=>$shortcode,
          "rep_id"=>$w->rep_id,
          "appointment" =>array(
            "TOTALS"=>$w->total_booked,
            "SOLD"=>$w->sales,
            "DISP"=>$w->disp,
            "DNS"=>$w->dns,
            "CXL"=>$w->cxl,
            "CXLREP"=>$w->cxlrep,
            "INC"=>$w->inc,
            "RBTF"=>$w->rbtf,
            "RBOF"=>$w->rbof,
            "RBTFREP"=>$w->rbtfrep,
            "RBOFREP"=>$w->rbofrep,
            "PUTON"=>$w->puton,
            "CLOSE"=>$w->close,
            "COMPLETE"=>$com),
          "grosssales"=>0,
          "netsales"=>0,
          "cancelledsales"=>0,
          "grosssale"=>array(
          "defender"=>0,"majestic"=>0,"2maj"=>0,"3maj"=>0,"system"=>0,"supersystem"=>0,
          "novasystem"=>0,"supernovasystem"=>0,"megasystem"=>0,"2system"=>0,"3defenders"=>0,
          "2defenders"=>0,"other"=>0),
          "netsale"=>array(
          "defender"=>0,"majestic"=>0,"2maj"=>0,"3maj"=>0,"system"=>0,"supersystem"=>0,
          "novasystem"=>0,"supernovasystem"=>0,"megasystem"=>0,"2system"=>0,"3defenders"=>0,
          "2defenders"=>0,"other"=>0),
          "totgrossunits"=>0,
          "grossmd"=>array("majestic"=>0,"defender"=>0),
          "grossunits"=>array("defender"=>0,"majestic"=>0,
          "2maj"=>0,"3maj"=>0,
          "system"=>0,"supersystem"=>0,"novasystem"=>0,"supernovasystem"=>0,
          "megasystem"=>0,"2system"=>0,"3defenders"=>0,"2defenders"=>0,"other"=>0),
          "totnetunits"=>0,
          "netmd"=>array("majestic"=>0,"defender"=>0),
          "netunits"=>array("defender"=>0,"majestic"=>0,
          "2maj"=>0,"3maj"=>0,
          "system"=>0,"supersystem"=>0,"novasystem"=>0,"supernovasystem"=>0,
          "megasystem"=>0,"2system"=>0,"3defenders"=>0,"2defenders"=>0,"other"=>0)
          );
          }
        }
      }

    $gsales=0;$nsales=0;$cxlsales=0;
    foreach($saledetails as $s){
      if(array_key_exists($s->user_id,$salesarray)){
        $cxlsales+=$s->cxl;
        $gsales+=$s->tot;$nsales+=$s->nettot;
        
        $salesarray[$s->user_id]["grosssales"]=$s->tot;
        $salesarray[$s->user_id]["netsales"]=$s->nettot;
        $salesarray[$s->user_id]["grosssale"]=array(
          "defender"=>$s->def,"majestic"=>$s->maj,"2maj"=>$s->twomaj,"3maj"=>$s->threemaj,"system"=>$s->system+($s->twosystem*2),"supersystem"=>$s->super,
          "novasystem"=>$s->nova,"supernovasystem"=>$s->supernova,"megasystem"=>$s->mega,"2system"=>$s->twosystem,"3defenders"=>$s->threedef,
          "2defenders"=>$s->twodef,"other"=>$s->other);
        $salesarray[$s->user_id]["netsale"]=array(
          "defender"=>$s->netdef,"majestic"=>$s->netmaj,"2maj"=>$s->nettwomaj,"3maj"=>$s->netthreemaj,"system"=>$s->netsys+($s->nettwosys*2),"supersystem"=>$s->netsuper,
          "novasystem"=>$s->netnova,"supernovasystem"=>$s->netsupernova,"megasystem"=>$s->netmega,"2system"=>$s->nettwosys,"3defenders"=>$s->netthreedef,
          "2defenders"=>$s->nettwodef,"other"=>$s->other);
      };
      }


      
       if($sold!=0 && $puton!=0){
        $close = number_format(($sold/($dns+$sold))*100,2,'.','');
        $complete = number_format(100-(($sold+$dns)/($cxl+$inc+$rbtf+$rbof+$sold+$dns))*100,2,'.','');
     }
     
     $totals=array(
     "name"=>"totals",
     "avatar"=>"",
     "company"=>$company,
     "system_points"=>$system_points,
     "bronze_points"=>$bronze_points,
     "silver_points"=>$silver_points,
     "gold_points"=>$gold_points,
     "shortcode"=>$shortcode,
     "rep_id"=>"totals",
     "appointment" =>array(
            "TOTALS"=>$allapp,
            "SOLD"=>$sold,
            "DISP"=>$disp,
            "DNS"=>$dns,
            "CXL"=>$cxl,
            "CXLREP"=>$cxlrep,
            "INC"=>$inc,
            "RBTF"=>$rbtf,
            "RBOF"=>$rbof,
            "RBTFREP"=>$rbtfrep,
            "RBOFREP"=>$rbofrep,
            "PUTON"=>$puton,
            "CLOSE"=>$close,
            "COMPLETE"=>$complete),
          "grosssales"=>$gsales,
          "netsales"=>$nsales,
          "cancelledsales"=>$cxlsales,
          "grosssale"=>array(
          "defender"=>0,"majestic"=>0,"2maj"=>0,"3maj"=>0,"system"=>0,"supersystem"=>0,
          "novasystem"=>0,"supernovasystem"=>0,"megasystem"=>0,"2system"=>0,"3defenders"=>0,
          "2defenders"=>0,"other"=>0),
          "netsale"=>array(
          "defender"=>0,"majestic"=>0,"2maj"=>0,"3maj"=>0,"system"=>0,"supersystem"=>0,
          "novasystem"=>0,"supernovasystem"=>0,"megasystem"=>0,"2system"=>0,"3defenders"=>0,
          "2defenders"=>0,"other"=>0),
          "totgrossunits"=>0,
          "grossmd"=>array("majestic"=>0,"defender"=>0),
          "grossunits"=>array("defender"=>0,"majestic"=>0,
            "2maj"=>0,"3maj"=>0,
          "system"=>0,"supersystem"=>0,"novasystem"=>0,
          "megasystem"=>0,"supernovasystem"=>0,"2system"=>0,"3defenders"=>0,"2defenders"=>0,"other"=>0),
          "totnetunits"=>0,
          "netmd"=>array("majestic"=>0,"defender"=>0),
          "netunits"=>array("defender"=>0,"majestic"=>0,
            "2maj"=>0,"3maj"=>0,
          "system"=>0,"supersystem"=>0,"novasystem"=>0,"supernovasystem"=>0,
          "megasystem"=>0,"2system"=>0,"3defenders"=>0,"2defenders"=>0,"other"=>0)
        );
    

    foreach($salesarray as $s){
      foreach($s["grosssale"] as $k=>$v){
          if($k!="2system"){
            if($k=="other"){
              $otherdef=0;$othermaj=0;$othertot=0;
              if(!empty($othersales)){
                foreach($othersales as $sale){
                  if($sale->user_id == $s['rep_id']){
                    $items = $sale->items;
                    if(!empty($items)){
                      foreach($items as $i){
                        if($i->item_name=="defender"){
                          $otherdef++;
                          $othertot++;
                        } else if($i->item_name=="majestic"){
                          $othermaj++;
                          $othertot++;
                        } 
                      }                   
                    }
                  }
                }
              }
              $u = array("tot"=>$othertot,"maj"=>$othermaj,"def"=>$otherdef);

            } else {
              $u = Sale::getUnits($k);
            }

            $units = $s["grosssale"][$k]*$u["tot"];
            $majs = $s["grosssale"][$k]*$u["maj"];
            $defs = $s["grosssale"][$k]*$u["def"];
            
            $s["totgrossunits"] = intval($s["totgrossunits"])+intval($units);
            $s["grossmd"]["majestic"] = $s["grossmd"]["majestic"]+$majs;
            $s["grossmd"]["defender"] = $s["grossmd"]["defender"]+$defs;
            $s["grossunits"][$k] = $s["grossunits"][$k]+$units;
            
            $totals["grossunits"][$k] += intval($units);
            $totals["totgrossunits"] +=  intval($units);
            $totals["grosssale"][$k] += $s["grosssale"][$k];
            $totals["grossmd"]["majestic"] += $majs;
            $totals["grossmd"]["defender"] += $defs; 
          
          }
      }
      foreach($s["netsale"] as $k=>$v){
         if($k!="2system"){
          $u = Sale::getUnits($k);
          $units = $s["netsale"][$k]*$u["tot"];
          $majs = $s["netsale"][$k]*$u["maj"];
          $defs = $s["netsale"][$k]*$u["def"];
          
          $s["totnetunits"] = intval($s["totnetunits"])+intval($units);
          $s["netmd"]["majestic"] = $s["netmd"]["majestic"]+$majs;
          $s["netmd"]["defender"] = $s["netmd"]["defender"]+$defs;
          $s["netunits"][$k] = $s["netunits"][$k]+$units;
          
          $totals["netunits"][$k] += intval($units);
          $totals["totnetunits"] +=  intval($units);
          $totals["netsale"][$k] += $s["netsale"][$k];
          $totals["netmd"]["majestic"] += $majs;
          $totals["netmd"]["defender"] += $defs; 
        }
      }
      $newarray[$s["rep_id"]] = $s;
    }
       

      $newarray["totals"] = $totals;
      usort($newarray, function($a, $b){
        return $a['totgrossunits'] - $b['totgrossunits'];
      });
      $newarray = array_reverse($newarray,true);
      $new = array();
      foreach($newarray as $k=>$v){
        $new[$v['rep_id']]= $v;
      }
       
      return $new;
    }

    public static function apptStats($type=null){
      if($type==null){
        $field = "rep_id"; $fieldname="rep_name";
      } else {
        if($type=="salesrep"){
          $field = "rep_id"; $fieldname="rep_name";
        } else if($type=="agent"){
          $field = "booker_id"; $fieldname="booked_by";
        }
      }

      $apps_day = DB::query("SELECT COUNT(*) as cnt, app_date, status, systemsale, $field, $fieldname, SUM(status='SOLD') sold FROM appointments WHERE status='DNS' OR status='SOLD' GROUP BY app_date, $field ");
      $apps_week = DB::query("SELECT COUNT(*) as cnt, app_date,  status, systemsale, $field, $fieldname, SUM(status='SOLD') sold FROM appointments WHERE status='DNS' OR status='SOLD' GROUP BY WEEK(app_date), $field ");
      $apps_month = DB::query("SELECT COUNT(*) as cnt, app_date,  status, systemsale, $field, $fieldname, SUM(status='SOLD') sold FROM appointments WHERE status='DNS' OR status='SOLD' GROUP BY MONTH(app_date), $field ");
      $dems=array();

      foreach($apps_day as $a){
        if($a->cnt>=3){
            $dems[$a->rep_id]['day']['3dems'][$a->app_date]= $a->cnt;
        }
        if($a->sold>=2){
            $dems[$a->rep_id]['day']['2sold'][$a->app_date]= $a->sold;
        }
        if($a->cnt>=4){
             $dems[$a->rep_id]['day']['4dems'][$a->app_date]= $a->cnt;
        }
        if($a->sold>=3){
            $dems[$a->rep_id]['day']['3sold'][$a->app_date]= $a->sold;
        }
        if($a->cnt>=5){
             $dems[$a->rep_id]['day']['5dems'][$a->app_date]= $a->cnt;
        }
        if($a->sold>=4){
            $dems[$a->rep_id]['day']['4sold'][$a->app_date]= $a->sold;
        }
        
      }

      foreach($apps_week as $a){
        if($a->cnt>=15){
            $dems[$a->rep_id]['week']['15dems'][$a->app_date]= $a->cnt;
        }
        if($a->sold>=8){
            $dems[$a->rep_id]['week']['8sold'][$a->app_date]= $a->sold;
        }
        if($a->cnt>=20){
             $dems[$a->rep_id]['week']['20dems'][$a->app_date]= $a->cnt;
        }
        if($a->sold>=12){
            $dems[$a->rep_id]['week']['12sold'][$a->app_date]= $a->sold;
        }
        if($a->cnt>=25){
             $dems[$a->rep_id]['week']['25dems'][$a->app_date]= $a->cnt;
        }
        if($a->sold>=15){
            $dems[$a->rep_id]['week']['15sold'][$a->app_date]= $a->sold;
        }

      }

      foreach($apps_month as $a){
        if($a->cnt>=50){
            $dems[$a->rep_id]['month']['50dems'][$a->app_date]= $a->cnt;
        }
        if($a->sold>=18){
            $dems[$a->rep_id]['month']['18sold'][$a->app_date]= $a->sold;
        }
        if($a->cnt>=60){
             $dems[$a->rep_id]['month']['60dems'][$a->app_date]= $a->cnt;
        }
        if($a->sold>=25){
            $dems[$a->rep_id]['month']['25sold'][$a->app_date]= $a->sold;
        }
        if($a->cnt>=75){
             $dems[$a->rep_id]['month']['75dems'][$a->app_date]= $a->cnt;
        }
        if($a->sold>=30){
            $dems[$a->rep_id]['month']['30sold'][$a->app_date]= $a->sold;
        }
        
      }

      return $dems;
    }
    
    
    public static function bookStats($datemin,$datemax,$city){
      if($datemin=="MONTH"){
        $dates = Stats::getMonthandWeek();
        $datemin = $dates['month']['start'];
        $datemax = $dates['month']['end'];
      } else if($datemin=="WEEK"){
        $dates = Stats::getMonthandWeek();
        $datemin = $dates['week']['start'];
        $datemax = $dates['week']['end'];
      } else if($datemin=="ALLTIME"){
        $datemin = "2010-01-01";
        $datemax = "2020-01-01";
      }
      
      $apps = DB::query("SELECT COUNT(*) as tot, booker_id, SUM(status='SOLD' OR status='DNS') puton, SUM(status='SOLD') sold,SUM(status='DNS') dns FROM appointments 
      WHERE app_date >= DATE('".$datemin."') AND app_date <= DATE('".$datemax."') $city GROUP BY booker_id");
      
      $calls = array();
      foreach($apps as $ap){
        $user = User::find($ap->booker_id);
        if($user){
          $arr[$ap->booker_id]['apps'] = $ap;
          $arr[$ap->booker_id]['calls'] = $calls;
        }
      
      }
      return $arr;
      
    }

    public static function expClose($user,$city,$count){
      $exp=0;$rates=0;$uclose=0;$cbook=0;$cclose=0;$average=0;
      $u = User::find($user);
      if($u){
        $uclose = $u->closePercent();
      }
      $c = City::where('cityname','=',$city)->first();
      if($c){
        $rates = $c->cityRates();
        $cbook = $rates[0]->bookrate;
      }
      if($cbook!=0 || $uclose!=0){
        $average = ($cbook+$uclose)/2;
      }
     
      if($count>0){
        $exp = number_format($count*($average/100),0,'','');
        return $exp;
      } else {
        return "N/A";
      }
    }
    
    //*******END MAIN STATS************//

    public static function reggiestats($period=null,$start=null,$end=null){
            if($start==null){
                $start = date('Y-m-d',strtotime('- 6 Day'));
            }
            if($end==null){
                $end = date('Y-m-d');
            }

            if($period==null){
                $period="MONTH";
            } 
                   $reggies = DB::query("SELECT COUNT(id) as tot, researcher_name, researcher_id,
                        SUM(status='SOLD') sold, SUM(status='DNS') dns, 
                        SUM(status='DNS' OR status='SOLD' OR status='INC' OR status='NQ') demos FROM leads WHERE status!='WrongNumber' AND MONTH(entry_date)=MONTH('".date('Y-m-d')."') AND YEAR(entry_date)=YEAR(NOW()) GROUP BY researcher_name ORDER BY tot DESC");
                   $arr = array();
                   foreach($reggies as $val){
                    $u = User::find($val->researcher_id);
                    if($u){
                        if($u->user_type=="doorrep"){
                            $arr[] = $val;
                        }
                    }
                   }

                   $reggies = $arr;
        return $reggies;
        }
        
        
    

    	public static function salespodium($period=null,$start=null,$end=null){
        
        if($start==null){
            $start = date('Y-m-d',strtotime('- 6 Day'));
        }
        if($end==null){
            $end = date('Y-m-d');
        }

        if($period==null){
            $period="MONTH";
        }


        if($period=="MONTH"){
        $charts = DB::query("SELECT COUNT(id) as tot,app_date,SUM(status='SOLD' OR status='DNS')puton,
        SUM(status='SOLD') sold, SUM(status='DNS') dns, SUM(status='INC') inc FROM appointments 
        WHERE rep_id!=0 AND $period(app_date)=$period('".date('Y-m-d')."') GROUP BY DATE(app_date)");


        $sold="";$dns="";$inc="";$tot="";$dates="";
        foreach($charts as $val){
            $sold.=$val->sold.",";
            $dns.=$val->dns.",";
            $inc.=$val->inc.",";
            $tot.=$val->puton.",";
            $dates.="'".date('D d',strtotime($val->app_date))."',";
        } 

        $charts = array("labels"=>$dates,"sold"=>$sold,"dns"=>$dns,"inc"=>$inc,"tot"=>$tot);
        }
        else {$charts="";}
        
        $sale=array();

        if($period=="WEEK"){
            $salesstats = DB::query("SELECT *, IF(sold + puton, 100*sold/puton, NULL) AS close 
            FROM (SELECT COUNT(id) as tot,rep_id, rep_name,SUM(status='SOLD' OR status='DNS')puton,
            SUM(status='SOLD') sold, SUM(status='DNS') dns, SUM(status='INC') inc, SUM(units) units FROM appointments 
            WHERE rep_id!=0 AND WEEK(app_date,1)=WEEK('".date('Y-m-d')."',1) AND YEAR(app_date)=YEAR(NOW()) GROUP BY rep_name) AS subquery ORDER BY units DESC, sold DESC");

            $salesstatstotals = DB::query("SELECT *, IF(sold + puton, 100*sold/puton, NULL) AS close 
            FROM (SELECT COUNT(id) as tot,SUM(status='SOLD' OR status='DNS')puton,
            SUM(status='SOLD') sold, SUM(status='DNS') dns, SUM(status='INC') inc, SUM(units) units FROM appointments 
            WHERE rep_id!=0 AND WEEK(app_date,1)=WEEK('".date('Y-m-d')."',1) AND YEAR(app_date)=YEAR(NOW())) AS subquery");
    
            $sale = DB::query("SELECT id,payout,typeofsale, ridealong_payout,ridealong_id,user_id,status FROM sales WHERE WEEK(date,1)=WEEK('".date('Y-m-d')."',1) AND YEAR(date)=YEAR(NOW())");

        } else  if(($period=="RANGE")&&(!empty($start))){
           
            $salesstats = DB::query("SELECT *, IF(sold + puton, 100*sold/puton, NULL) AS close 
            FROM (SELECT COUNT(id) as tot,rep_id, rep_name,SUM(status='SOLD' OR status='DNS')puton,
            SUM(status='SOLD') sold, SUM(status='DNS') dns, SUM(status='INC') inc, SUM(units) units FROM appointments 
            WHERE rep_id!=0 AND app_date>='".$start."' AND app_date<='".$end."' GROUP BY rep_name) AS subquery ORDER BY units DESC");

            $salesstatstotals = DB::query("SELECT *, IF(sold + puton, 100*sold/puton, NULL) AS close 
            FROM (SELECT COUNT(id) as tot,SUM(status='SOLD' OR status='DNS')puton,
            SUM(status='SOLD') sold, SUM(status='DNS') dns, SUM(status='INC') inc, SUM(units) units FROM appointments 
            WHERE rep_id!=0 AND app_date>='".$start."' AND app_date<='".$end."') AS subquery");
   
             $sale = DB::query("SELECT id,payout,typeofsale, ridealong_payout,ridealong_id,user_id,status FROM sales WHERE date >= DATE('".$start."') AND date <= DATE('".$end."')");

        } else {
        
            $salesstats = DB::query("SELECT *, IF(sold + puton, 100*sold/puton, NULL) AS close 
            FROM (SELECT COUNT(id) as tot,rep_id, id, rep_name,SUM(status='SOLD' OR status='DNS')puton,
            SUM(status='SOLD') sold, SUM(status='DNS') dns, SUM(status='INC') inc, SUM(units) units FROM appointments 
            WHERE rep_id!=0 AND $period(app_date)=$period('".date('Y-m-d')."') GROUP BY rep_name) AS subquery ORDER BY units DESC");

            $salesstatstotals = DB::query("SELECT *, IF(sold + puton, 100*sold/puton, NULL) AS close 
            FROM (SELECT COUNT(id) as tot,SUM(status='SOLD' OR status='DNS')puton,
            SUM(status='SOLD') sold, SUM(status='DNS') dns, SUM(status='INC') inc, SUM(units) units FROM appointments 
            WHERE rep_id!=0 AND $period(app_date)=$period('".date('Y-m-d')."')) AS subquery");
            
            $sale = DB::query("SELECT id,payout,typeofsale,ridealong_payout,ridealong_id,typeofsale,user_id,status FROM sales WHERE $period(date)=$period('".date('Y-m-d')."')");
        }

        $arr=array();
        foreach($salesstats as $val){
          
            $val->grossunits=0;
            $val->netunits=0;
            $val->maj=0;$val->def=0;$val->netmaj=0;$val->netdef=0;
            $u = User::find($val->rep_id);
            if(!empty($u)){
                if($u->level!=99){
                    if($sale){
                        foreach($sale as $s){
                            if($s->user_id==$val->rep_id){
                                if($s->typeofsale){
                                    $u = Stats::units($s->typeofsale);
                                    if(($s->status!="CANCELLED")&&($s->status!="TURNDOWN")&&($s->status!="TBS")){
                                        $val->netunits = $val->netunits+$u['maj']+$u['def'];
                                        $val->netmaj = $val->netmaj + $u['maj'];
                                        $val->netdef = $val->netdef + $u['def'];
                                    } 
                                        $val->grossunits = $val->grossunits+$u['maj']+$u['def'];
                                        $val->maj = $val->maj + $u['maj'];
                                        $val->def = $val->def + $u['def'];
                                }
                            }
                        }
                    }

                    array_push($arr, $val);
                }
            }
        }


        return array("reps"=>$arr,"totals"=>$salesstatstotals,"charts"=>$charts,"sales"=>$sale);
    }
    

     public static function marketpodium($period=null,$start=null,$end=null){

        if($period==null){
            $period = "MONTH";
        } 

        if($start==null){
            $start = date('Y-m-d',strtotime('- 6 Day'));
        }

        if($end==null){
            $end = date('Y-m-d');
        }


        if($period=="WEEK"){
        //BOOKER STATS AND STUFF
        $allrephold = DB::query("SELECT *, IF(book + tot, 100*book/(book + tot), NULL) AS hold 
        FROM (SELECT COUNT(*) as total, booker_id, booked_by,SUM(status='DNS' OR status='SOLD') book, 
        SUM(status!='DNS' AND status!='SOLD') tot FROM appointments WHERE $period(booked_at,1)= $period('".date('Y-m-d')."',1) 
        GROUP BY booker_id) AS subquery ORDER BY hold DESC, total DESC");

        $allrepputon = DB::query("SELECT COUNT(*) as total, booker_id, booked_by,
        SUM(status !='RB-TF' AND status!='RB-OF') app,
        SUM(status='DNS' OR status='SOLD' OR status='INC')puton FROM appointments WHERE $period(booked_at,1) = $period('".date('Y-m-d')."',1) GROUP BY booker_id ORDER BY puton DESC");
        
        $allrepbook = DB::query("SELECT *, IF(app + ni, 100*app/(app + ni), NULL) AS book 
        FROM (SELECT COUNT(*) as total, caller_id, caller_name,
        SUM(result = 'APP') app,SUM(result = 'NI') ni 
        FROM calls WHERE $period(created_at,1) = $period('".date('Y-m-d')."',1) GROUP BY caller_id) AS subquery ORDER BY app DESC");

        $allapps = DB::query("SELECT booker_id, booked_by, systemsale FROM appointments WHERE status='SOLD' AND $period(booked_at,1) = $period('".date('Y-m-d')."',1) ");

        $monthbookerstats = DB::query("SELECT *, IF(ni, 100*app/(ni+app), NULL) AS book 
        FROM (SELECT COUNT(id) as total, caller_id,SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'APP') app,
        SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
        SUM(result = 'WrongNumber') wrong FROM calls WHERE $period(created_at,1) = $period('".date('Y-m-d')."',1) GROUP BY caller_id) AS subquery ORDER BY app DESC");}
        else {
        
        $allrephold = DB::query("SELECT *, IF(book + tot, 100*book/(book + tot), NULL) AS hold 
        FROM (SELECT COUNT(*) as total, booker_id, booked_by,SUM(status='DNS' OR status='SOLD') book,  SUM(units) units,
        SUM(status!='RB-TF' AND status!='RB-OF' AND status!='INC') tot FROM appointments WHERE $period(booked_at)= $period('".date('Y-m-d')."') 
        GROUP BY booker_id) AS subquery ORDER BY hold DESC");

        $allrepputon = DB::query("SELECT COUNT(*) as total, booker_id, booked_by, systemsale, 
        SUM(status !='RB-TF' AND status!='RB-OF') app,
        SUM(status='DNS' OR status='SOLD' OR status='INC')puton FROM appointments WHERE $period(booked_at) = $period('".date('Y-m-d')."') GROUP BY booker_id ORDER BY puton DESC");
        $allapps = DB::query("SELECT booker_id, booked_by, systemsale FROM appointments WHERE status='SOLD' AND $period(booked_at) = $period('".date('Y-m-d')."') ");
        $allrepbook = DB::query("SELECT *, IF(app + ni, 100*app/(app + ni), NULL) AS book 
        FROM (SELECT COUNT(*) as total, caller_id, caller_name,
        SUM(result = 'APP') app,SUM(result = 'NI') ni 
        FROM calls WHERE $period(created_at) = $period('".date('Y-m-d')."') GROUP BY caller_id) AS subquery ORDER BY app DESC");

        $monthbookerstats = DB::query("SELECT *, IF(ni, 100*app/(ni+app), NULL) AS book 
        FROM (SELECT COUNT(id) as total, caller_id,SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'APP') app,
        SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
        SUM(result = 'WrongNumber') wrong FROM calls WHERE $period(created_at) = $period('".date('Y-m-d')."') GROUP BY caller_id) AS subquery ORDER BY app DESC");

        }

      
        $arr2 = array();
        foreach($monthbookerstats as $val){
            $u = User::find($val->caller_id);
            if(!empty($u)){
            if($u->user_type=="agent"){
                $val->booker_id = $val->caller_id;
                $val->caller_id = $u->firstname." ".$u->lastname;
                array_push($arr2, $val);
            }}
        }

        $allrepholdarray=array();
        foreach($allrephold as $val){
            $maj=0;$def=0;$test=array();
            $u = User::find($val->booker_id);

            foreach($allapps as $v){
                if($v->booker_id==$val->booker_id){
                    $gross = array();
                    $net=array();
                    $test[] = $v;
                    if($v->systemsale!=''){
                         $units = Stats::units($v->systemsale);
                         $maj = $maj + $units['maj'];
                         $def = $def + $units['def'];
                    }
                }
            }


            if(!empty($u)){
            if(($u->user_type=="agent")&&($u->level!=99)){
                $allrepholdarray[] = array(
                    "booker_name"=>$u->firstname." ".$u->lastname,
                    "booker_id"=>$val->booker_id,
                    "hold"=>number_format($val->hold,2,'.',''),
                    "total"=>$val->tot,
                    "test"=>$test,
                    "grossmaj"=>$maj,
                    "grossdef"=>$def,
                    "netmaj"=>$maj,
                    "netdef"=>$def,
                    "alltotal"=>$val->total,
                    "booked"=>$val->book
                    );
            }}
        }

        $allrepbookarray=array();
        foreach($allrepbook as $val){
            $u = User::find($val->caller_id);
            if(!empty($u)){
            if(($u->user_type=="agent")&&($u->level!=99)){
                $allrepbookarray[] = array(
                    "booker_id"=>$val->caller_id,
                    "booker_name"=>$val->caller_name,
                    "app"=>$val->app,
                    "bookper"=>number_format($val->book,2,'.',''),
                    "total"=>$val->total,
                    "ni"=>$val->ni
                    );
            }}
        }
        
        $allrepputonarray=array();
        foreach($allrepputon as $val){
            $u = User::find($val->booker_id);
            if(!empty($u)){
            if(($u->user_type=="agent")&&($u->level!=99)){
                $allrepputonarray[] = array(
                    "booker_id"=>$val->booker_id,
                    "apps"=>$val->app,
                    "puton"=>$val->puton,
                    "booker_name"=>$u->firstname
                    );
            }}
        }
        
        $results=array("puton"=>$allrepputonarray,"booked"=>$allrepbookarray,"hold"=>$allrepholdarray,"stats"=>$arr2);
        return $results;

    }


    // GET CHARTS FOR REPS
    public static function getCharts($id){
        if($id==null){
            return false;
        } else {

            if($id=="all"){
                $user_id = "";
                $rep_id = "";
                $rep="";
                $where_user="";
                $apps = Appointment::where('status','=','SOLD')->or_where('status','=','DNS')->get(array('status','diff','rep_id'));
            } else {
                $apps = Appointment::where('rep_id','=',$id)
                ->where('status','!=','APP')
                ->where('status','!=','CONF')
                ->where('status','!=','BUMP')
                ->where('status','!=','NQ')
                ->where('status','!=','RB-OF')
                ->where('status','!=','RB-TF')
                ->where('status','!=','CXL')
                ->where('status','!=','RB')
                ->where('status','!=','NA')
                ->where('status','!=','INC')
                ->where('status','!=','DISP')
                ->get(array('status','diff','rep_id'));
                $user_id = "AND user_id = '".$id."'";
                $rep_id = "AND rep_id = '".$id."'";
                $rep =  "AND rep = '".$id."'";
                $where_user = "WHERE user_id = '".$id."'";
            }


           $sales = DB::query("SELECT typeofsale, payout, ridealong_id,user_id, status FROM sales WHERE MONTH(date) = MONTH('".date('Y-m-d')."') AND YEAR(date)=YEAR(NOW()) ".$user_id);
           $allsales = DB::query("SELECT typeofsale, payout,  ridealong_id,user_id, status FROM sales ".$where_user."");
           $appointments = DB::query("SELECT COUNT(id) as cnt, diff, app_date, SUM(status='DNS') dns, SUM(status='SOLD') sold,  SUM(status='INC') inc FROM appointments 
           WHERE MONTH(app_date) = MONTH('".date('Y-m-d')."') AND YEAR(app_date)=YEAR(NOW()) AND (status='SOLD' OR status='DNS' OR status='INC') ".$rep_id."  GROUP BY app_date ");
          $times = DB::query("SELECT COUNT(*) as tot, app_time, SUM(status='SOLD') sold, SUM(status='INC') inc, SUM(status='DNS') dns FROM appointments 
          WHERE MONTH(app_date) = MONTH('".date('Y-m-d')."') AND YEAR(app_date)=YEAR(NOW()) AND (status='SOLD' OR status='DNS' OR status='INC') ".$rep_id." GROUP BY app_time ");
          
         
          foreach($apps as $a){ 
            if($a->diff>0){
                 if($a->status=="SOLD"){
                    $avgsold[] = $a->diff;
                } else if($a->status=="DNS") {
                    $avgdns[] = $a->diff;
                }
                $avgtime[] = $a->diff;
            }
           
          }

          if(!empty($avgsold)){
           $avgsold = Stats::getHours(array_sum($avgsold)/count($avgsold));
          } else {
          $avgsold = 0;}
          
          if(!empty($avgdns)){
           $avgdns = Stats::getHours(array_sum($avgdns)/count($avgdns));
          } else {
          $avgdns = 0;}
          
          if(!empty($avgtime)){
           $avgtime = Stats::getHours(array_sum($avgtime)/count($avgtime));
          } else {
          $avgtime = 0;}

            $leadtype = DB::query("SELECT COUNT(*) as cnt, rep, original_leadtype, asthma, rep_name, SUM(status='SOLD' OR status='DNS' OR status='INC') puton, 
          SUM(status='SOLD') sold, SUM(result='DNS') dns FROM leads WHERE MONTH(app_date) = MONTH('".date('Y-m-d')."') AND YEAR(app_date)=YEAR(NOW()) ".$rep." GROUP BY original_leadtype");
            $asthma = DB::query("SELECT COUNT(*) as cnt,asthma, SUM(status='SOLD') sold, SUM(result='DNS') dns FROM leads WHERE MONTH(app_date) = MONTH('".date('Y-m-d')."') AND YEAR(app_date)=YEAR(NOW()) ".$rep." GROUP BY asthma");
          
            $booker = DB::query("SELECT COUNT(*) as cnt, booker_name, SUM(status='SOLD') sold, SUM(result='DNS') dns FROM leads WHERE MONTH(app_date) = MONTH('".date('Y-m-d')."') AND YEAR(app_date)=YEAR(NOW()) ".$rep." GROUP BY booker_name");
            $job = DB::query("SELECT COUNT(*) as cnt,job, SUM(status='SOLD') sold, SUM(result='DNS') dns FROM leads WHERE MONTH(app_date) = MONTH('".date('Y-m-d')."') AND YEAR(app_date)=YEAR(NOW()) ".$rep." GROUP BY job");
            $fullpart = DB::query("SELECT COUNT(*) as cnt,fullpart, SUM(status='SOLD') sold, SUM(result='DNS') dns FROM leads WHERE MONTH(app_date) = MONTH('".date('Y-m-d')."') AND YEAR(app_date)=YEAR(NOW()) ".$rep." GROUP BY fullpart");
            
          $leadtypepie=array();
          $soldpiedata=array();
          $piedata = array();
          $dnspiedata=array();
          $asthmapie=array();$renterpie=array();
          $fullpartpie=array();$thetime=array();$timetotal=array();$timedns=array();$timesold=array();$timeinc=array();$date=array();$time=array();
          $dns=array();
          $sold=array();
          $inc=array();$total=array();
          $jobpie=array();$totunits=array();
          $thejob=array();$bookpie=array();$dnsbookpie=array();

          foreach($booker as $b){
            if($b->sold!=0){
                $dnsbookpie[] =array($b->booker_name, intval($b->dns));
            $bookpie[] =  array($b->booker_name, intval($b->sold));
            }
          }

          foreach($job as $j){
            $jobpie[] = array($j->job, intval($j->sold));
          }
           foreach($fullpart as $fp){
            $fullpartpie[] = array($fp->fullpart, intval($fp->sold));
          }

          foreach($asthma as $a){
            $asthmapie[] = array($a->asthma,intval($a->sold));
          }

            foreach($leadtype as $l){
                if($l->puton>0){
                    if($l->original_leadtype=="paper"){
                        $l->original_leadtype="Manilla";
                    }
                    if($l->original_leadtype=="secondtier"){
                        $l->original_leadtype="Second Tier Survey";
                    }

                    if($l->original_leadtype=="door"){
                        $l->original_leadtype="Door";
                    }

                    if($l->original_leadtype=="other"){
                        $l->original_leadtype="Scratch";
                    }

                     if($l->original_leadtype=="homeshow"){
                        $l->original_leadtype="Homeshow";
                    }

                    if($l->original_leadtype=="ballot"){
                        $l->original_leadtype="Ballot";
                    }

                    if($l->original_leadtype=="referral"){
                        $l->original_leadtype="Referral";
                    }
                      $leadtypepie[] = array($l->original_leadtype, intval($l->sold));
                }   
            }
            foreach($times as $val){
                if($val->tot>0){
                    $piedata[] = array($val->app_time, intval($val->tot));
                }
                  if($val->sold>0){
                $soldpiedata[] = array($val->app_time, intval( $val->sold));
            }
              if($val->dns>0){
                $dnspiedata[] = array($val->app_time,intval( $val->dns));
            }
            $timetotal[] = intval($val->tot);
            $timedns[] = intval($val->dns);
            $timesold[] = intval($val->sold);
            $timeinc[] = intval($val->inc);
            $thetime[] = $val->app_time;
           }
        

           foreach($appointments as $val){
            $total[] = intval($val->cnt);
            $time[] = floatval($val->diff);
            $dns[] = intval($val->dns);
            $sold[] = intval($val->sold);
            $inc[] = intval($val->inc);
            $date[] = date('d',strtotime($val->app_date));
           }

           $maj=array();
           $def=array();
           $balance=0;$bal=array();
            $totbalance=0;$totbal=array();
            $netmaj=0;$netmajestics=array();
            $netmajarr=array();$netdefarr=array();
            $totmajarr=array();
            $totdefarr=array();
            $totmaj=0;$totmajestics=array();
            $totdef=0;$totdefenders=array();
            $netdef=0;$netdefenders=array();
            $cancelcount=0;$turndowncount=0;$totcancel=0;
           foreach($sales as $val){ 
             if($val->typeofsale){
                    $u = Stats::units($val->typeofsale);
                    $maj[] = intval($u['maj']);
                    $def[] = intval($u['def']);
                    $totdefarr[] = $u['def'];
                    $totmajarr[] = $u['maj'];
                    $totmaj = $totmaj+intval($u['maj']);
                    $totmajestics[] = $totmaj;
                    $totdef = $totdef+intval($u['def']);
                    $totdefenders[] = $totdef;
                }

            if(($val->status!="CANCELLED")&&($val->status!="TURNDOWN")&&($val->status!="TBS")){

               if(($val->user_id==$id)||($id=="all")){
                 $netmaj = $netmaj+intval($u['maj']);
                 $netmajestics[] = $netmaj;
                 $netmajarr[] = intval($u['maj']);
                 $netdefarr[] = intval($u['def']);
                 $netdef = $netdef+intval($u['def']);
                 $netdefenders[] = $netdef;
                 $balance = $balance+intval($val->payout);
                 $bal[] = $balance;
                } 
           

            } else {
                if($val->status=="CANCELLED" || $val->status=="TBS"){
                     $cancelcount = $cancelcount+1;
                } else {
                     $turndowncount = $turndowncount+1;
                }
               $totcancel = $totcancel+1;
            }

           }

           
            foreach($allsales as $val){
            if($val->status=="COMPLETE"){
                if($val->typeofsale){
               // $totmaj = $balance+intval($val->payout);
               if(($val->user_id==$id)||($id=="all")){

                    $totunits[] = intval($val->payout);
                 $totbalance = $totbalance+intval($val->payout);
                 $totbal[] = $totbalance;
                } 
            }
        }
           }
           
           $timedata = array("time"=>$thetime,"total"=>$timetotal,"dns"=>$timedns,"sold"=>$timesold,"inc"=>$timeinc);
           $data = array("date"=>$date,"time"=>$time,"dns"=>$dns,"sold"=>$sold,"inc"=>$inc,"maj"=>$maj,"def"=>$def);
           
      
          
            return $chartdata = array("averagetime"=>array("avg"=>$avgtime,"sold"=>$avgsold,"dns"=>$avgdns),
                "fullpartpie"=>$fullpartpie,
                "bookpie"=>$bookpie,
                "dnsbookpie"=>$dnsbookpie,
                "jobpie"=>$jobpie,
                "asthmapie"=>$asthmapie,
                "timedata"=>$timedata,
                "saledata"=>$data,
                "piedata"=>$piedata,
                "cancels"=>$cancelcount,
                "turndowns"=>$turndowncount,
                "allcancels"=>$totcancel,
                "sold"=>$soldpiedata,
                "dns"=>$dnspiedata,
                "leadtype"=>$leadtypepie,
                //"system"=>$systempie,
                "balance"=>$bal,"totbalance"=>$totbal,"totunits"=>$totunits,
                "totmajestics"=>$totmajestics,"totdefenders"=>$totdefenders,
                "totmajchart"=>$totmajarr,"totdefchart"=>$totdefarr,
                "netmajestics"=>$netmajestics,"netdefenders"=>$netdefenders,
                "netmajchart"=>$netmajarr,"netdefchart"=>$netdefarr);

        }

    }

  //**********HELPER FUNCTIONS******************//

  // Get UNIT count for certain type of sale      
  public static function units($type){
    if($type=="defender"){
      return array("def"=>1,"maj"=>0);
    } else if($type=="2maj"){
          return array("def"=>0,"maj"=>2);
    } else if($type=="3maj"){
          return array("def"=>0,"maj"=>3);
    } else if($type=="majestic"){
        return array("def"=>0,"maj"=>1);
    } else if($type=="system"){
        return array("def"=>1,"maj"=>1);
    } else if($type=="supersystem"){
        return array("def"=>2,"maj"=>1);
    } else if($type=="megasystem"){
         return array("def"=>3,"maj"=>1);
    } else if($type=="novasystem"){
          return array("def"=>4,"maj"=>1);
    } else if($type=="2defenders"){
          return array("def"=>2,"maj"=>0);
    } else if($type=="3defenders"){
         return array("def"=>3,"maj"=>0);
    } else if($type=="2system"){
         return array("def"=>2,"maj"=>2);
    } else if($type=="supernova"){
         return array("def"=>5,"maj"=>1);
    }
  }

  //Get month and week dates for stats functions
  public static function getMonthandWeek(){
    $mnth_datemin = date('Y-m-01');
    $mnth_datemax = date('Y-m-t');
    $date = date('Y-m-d') ;// you can put any date you want
    $nbDay = date('N', strtotime($date));
    $monday = new DateTime($date);
    $sunday = new DateTime($date);
    $monday->modify('-'.($nbDay-1).' days');
    $sunday->modify('+'.(7-$nbDay).' days');
    $day = date('w');
    $week_start = date('Y-m-d', strtotime($monday->format('Y-m-d H:i:s')));
    $week_end = date('Y-m-d', strtotime($sunday->format('Y-m-d H:i:s')));
    return array(
      "month"=>array("start"=>$mnth_datemin,"end"=>$mnth_datemax),
      "week"=>array("start"=>$week_start,"end"=>$week_end)
      );
  }

  // Get Hourse of decimal time difference
  public static function getHours($time){
    $seconds = (int)($time  * 3600);
    $hours = floor($time);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    if(strlen($minutes)<=1){
      $minutes = "0".$minutes;
    }
    $avgtime = $hours." : ".$minutes." <span style='color:#aaa;'>hrs</span>";
    return $avgtime;
  }

  // Get Numerology of house numbers
  public static function getNumerology(){
    $address = DB::query("SELECT COUNT(*) as cnt, add_numerology, SUM(status='SOLD') sold, SUM(result='DNS') dns, SUM(status='NI') ni,
    AVG(status='SOLD') avgsold,
    SUM(status='DNC') dnc, SUM(status='APP' OR status='SOLD' OR status='DNS') booked FROM leads GROUP BY add_numerology");
    
    $number = DB::query("SELECT COUNT(*) as cnt, num_numerology, SUM(status='SOLD') sold, SUM(result='DNS') dns, SUM(status='NI') ni,
    AVG(status='SOLD') avgsold,
    SUM(status='DNC') dnc, SUM(status='APP' OR status='SOLD' OR status='DNS') booked FROM leads GROUP BY num_numerology");
    
    return array("address"=>$address,"number"=>$number);
  }
  //************************END HELPER FUNCTIONS*********************//


}