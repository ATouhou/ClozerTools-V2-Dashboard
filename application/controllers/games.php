<?php
class Games_Controller extends Base_Controller
{
	public function __construct(){
    	parent::__construct();
    	$this->filter('before','auth');
      $this->puton_points = Game::points("PUTON");
      $this->book_points = Game::points("BOOK");
      $this->sold_points = Game::points("SOLD");
      $this->booksold_points = Game::points("BOOKSOLD");
      $this->dns_points = Game::points("DNS");
      $this->pickup_machines = Game::points("PICKUP");  
      $this->grossunit_points = Game::points("GUNIT");
      $this->congratulate_points = Game::points("CONGRATS");
  	}

  	/*****GAME UPDATING SYSTEM*******/
   public function round_down($number, $precision = 2){
      $fig = (int) str_pad('1', $precision, '0');
      return (floor($number * $fig) / $fig);
    } 
    //*********FUNCTION TO INITIATE THE GAMES MODULE *******//
    public function action_updategames(){
      echo "<a href='".URL::to('games/initHistory')."' target=_blank><button>INIT HISTORY</button></a><br>";
       echo "<a href='".URL::to('games/initPoints')."' target=_blank><button>INIT POINTS</button></a><br>";
       echo "<a href='".URL::to('games/createUserGames')."' target=_blank><button>CREATE USER GAMES TABLE</button></a><br>";
       echo "<a href='".URL::to('games/initiateGames')."' target=_blank><button>INIT GAMES</button></a><br>";
    }
    
    
    public function action_initHistory(){
      DB::query("TRUNCATE TABLE game_history");
      $apps = Appointment::take(300)->order_by('app_date','DESC')->get();
      foreach($apps as $ap){
        $this->applyHistory($ap);
      }
    }
    
    public function action_initPoints(){
        $saleStats = Stats::saleStats("ALLTIME","","");
        $bookStats = Stats::bookStats("ALLTIME","","");
        foreach($saleStats as $k=>$st){
          if($k!="totals"){
            $user = User::find($st['rep_id']);
            if($user){
              $points = 0; $silver = 0; $gold = 0; $bronze =0 ; 
              $silver+=intval($st['grosssales']);
              $gold+=(intval($st['grosssale']['supersystem'])+intval($st['grosssale']['megasystem'])+intval($st['grosssale']['novasystem']));
              $bronze+=intval($st['totgrossunits']);
              $points+=intval($st['appointment']['PUTON'])*intval($this->puton_points);
              $points+=intval($st['grosssales'])*intval($this->sold_points);
              $points+=intval($st['appointment']['DNS'])*intval($this->dns_points);
              $points+=intval($st['totgrossunits'])*intval($this->grossunit_points);
              $user->system_points = $points;
              $user->gold_points = $gold;
              $user->bronze_points = $bronze;
              $user->silver_points = $silver;
              $user->save();
              echo $user->fullName(). " Has ".$points." Points <br>";
            }
          }
        }
        foreach($bookStats as $k=>$st){
         if($k!="totals"){
            $user = User::find($k);
            if($user){
              $points = 0; $silver = 0; $gold = 0; $bronze =0 ; 
              $points+=intval($st['apps']->tot)*intval($this->book_points);
              $points+=intval($st['apps']->puton)*intval($this->puton_points);
              $points+=intval($st['apps']->sold)*intval($this->booksold_points);
              $user->system_points = $points;
              $user->save();
              echo $user->fullName(). " Has ".$points." Points <br>";
            }
          }
        }
        // Update history log with new point system
        $history = GameHistory::get();
        foreach($history as $h){
          if($h->points!=Game::points($h->type)){
            $h->points = Game::points($h->type);
            $h->save();
            echo "saved<br>";
          }
          
          echo $h->lead_id." ".$h->historyMessage()." ".$h->points."<br>";
        }
    }
    
    public function applyHistory($appointment){
      //Register Booker points for booking demo
        GameHistory::writeHistory(1,$appointment,"BOOK",$appointment->booker_id);
        if($appointment->status=="SOLD" || $appointment->status=="DNS"){
          //register a puton for booker and researcher
          GameHistory::writeHistory(1,$appointment,"PUTON",$appointment->booker_id);
          GameHistory::writeHistory(1,$appointment,"PUTON",$appointment->researcher_id);
          //register a completed demo for rep
          if($appointment->status=="SOLD"){
            GameHistory::writeHistory(1,$appointment,"SOLD",$appointment->rep_id);
            GameHistory::writeHistory(1,$appointment,"BOOKSOLD",$appointment->booker_id);
          } else if($appointment->status=="DNS"){
            GameHistory::writeHistory(1,$appointment,"DNS",$appointment->rep_id);
          }
        } 
    }
 
    public function action_createUserGames(){
      $games = Game::all();
      $users = User::allUsers();
      foreach($games as $g){
        foreach($users as $u){
          $gu = GameUser::where('user_id','=',$u->id)->where('game_id','=',$g->id)->count();
          if($gu==0){
            if($g->user_type==$u->user_type){
              $gu = New GameUser;
              $gu->game_id = $g->id;
              $gu->user_id = $u->id;
              $gu->order = $g->order;
              $gu->points = 0;
              $gu->status = "locked";
              $gu->game_name = $g->game_name;
              $gu->save();          
            }
          } 
        }
      }
    }

    public function action_initiateGames(){
      $users = User::allUsers();
      $saleStats = Stats::saleStats("ALLTIME","","");
      $apptStats = Stats::apptStats();
      $games = Game::all();
      foreach($games as $g){
        $gameUsers = GameUser::where('game_id','=',$g->id)->get();
        foreach($gameUsers as $users){
          $gameUSER = GameUser::find($users->id);
          $user = User::find($users->id);
          if($gameUSER){
            $query = explode("|",$g->sql_query);

            //Check for any game queries related to SaleStats function
            if(isset($saleStats[$users->user_id])){
              if($g->query_table=="totsales"){
                if(count($query)>1){
                    $cnt = $saleStats[$users->user_id][$query[0]][$query[1]];
                  } else {
                    $cnt = $saleStats[$users->user_id][$query[0]];
                  }
                  if($g->type=="points"){
                    $gameUSER->status="unlocked";
                    $points = $cnt*$g->game_points;
                  } else if($g->type=="achievements" || $g->type=="trophies"){
                    $points = $cnt/$g->game_points;
                    if($points < 1){
                      $points = 0;
                    }
                    if($points==0){
                      $gameUSER->status="locked";
                    } else {
                      $gameUSER->status="unlocked";
                    }
                  }
                  $gameUSER->units = $cnt;
                  $gameUSER->points = $points;
                  $gameUSER->times_achieved = $points;
              }
              
            } 

            //Check for any game queries related to SaleStats function
            if(isset($apptStats[$users->user_id])){
              if($g->query_table=="apps"){
                if(count($query)>1){
                  if(isset($apptStats[$users->user_id][$query[0]][$query[1]])){
                    $demos = $apptStats[$users->user_id][$query[0]][$query[1]];
                  } else {
                    $demos = array();
                  }
                }

                if(!empty($demos)){
                  $times=0;$firstdate="";
                  foreach($demos as $k=>$v){
                    if($v>=$g->game_points){
                      if($gameUSER->date_achieved=="0000-00-00 00:00:00"){
                        $gameUSER->date_achieved = $k;
                      }
                      $times++;
                    }
                    if($times>=1){
                      $gameUSER->times_achieved = $times;
                      $gameUSER->status="unlocked";
                      $gh = DB::query("SELECT COUNT(*) as cnt FROM game_history WHERE 'user_id' = '".$users->user_id."'
                        AND game_id = '".$gameUSER->game_id."' AND DATE(history_date)=DATE('".date('Y-m-d',strtotime($k))."')");

                      if($gh[0]->cnt==0){
                        //HAS HISTORY
                       $hist = New GameHistory;
                       $hist->user_id = $users->user_id;
                       $hist->game_id = $gameUSER->game_id;
                       $hist->history_date = $k;
                       $hist->type="TROPHY";
                       $hist->message = "Earned a Trophy for ".$g->game_description;
                       $hist->user_type="salesrep";
                       $hist->save();
                      } 
                    } else {
                      $gameUSER->times_achieved = 0;
                      $gameUSER->status="locked";
                    }
                  }
                }
              } 
            }
            $gameUSER->save();
          }
        }
      }
    }



    /****END GAME UPDATING***********/

    public function action_viewprofile($id){
      if($id==null){
        return Redirect::back();
      }
      $games = Game::allGames();
      $user = User::find($id);
      $stats = Stats::saleStats("ALLTIME","","");
      return View::make('games.index')
        ->with('stats',$stats)
        ->with('games',$games)
        ->with('user',$user);
    }

  
  
}