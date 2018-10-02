<?php
/*
Plugin Name: Smoking vs Investment Calculator
Plugin URI: http://www.devilhunter.net/
Description:  This PlugIn will automatically match your theme's color. Go to Appearance > Widgets, and drag 'PlugIn' in sidebar or footer or into any widgetized area. Insert into page or post by PageBuilder. No need to use any short-code or to edit settings.
Version: 1.0
Author: Tawhidur Rahman Dear
Author URI: http://www.facebook.com/tawhidurrahmandear/ 
License: GPLv2 or later 


Developer: 
Tawhidur Rahman Dear
tawhidurrahmandear@gmail.com
Blog: http://tawhidurrahmandear.blogspot.com/
Facebook: http://www.facebook.com/tawhidurrahmandear/ 
Google Plus: http://plus.google.com/+tawhidurrahmandear/about
YouTube: http://www.youtube.com/tawhidurrahmandear
LinkedIn: http://www.linkedin.com/in/tawhidurrahmandear

 
 */
 
 
class tawhidurrahmandearfortynineWidget extends WP_Widget {
  function tawhidurrahmandearfortynineWidget() {
    $widget_ops = array('classname' => 'tawhidurrahmandearfortynineWidget', 'description' => 'Drag the PlugIn in sidebar or footer. Insert into page or post by PageBuilder' );
    $this->WP_Widget('tawhidurrahmandearfortynineWidget', 'Smoking vs Investment Calculator', $widget_ops);
  }
 
  function form($instance) {
    $instance = wp_parse_args((array) $instance, array( 'title' => '' ));
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title (optional) :<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance) {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
 ?>

<script language="JavaScript">

function sn(num) {

   num=num.toString();


   var len = num.length;
   var rnum = "";
   var test = "";
   var j = 0;

   var b = num.substring(0,1);
   if(b == "-") {
      rnum = "-";
   }

   for(i = 0; i <= len; i++) {

      b = num.substring(i,i+1);

      if(b == "0" || b == "1" || b == "2" || b == "3" || b == "4" || b == "5" || b == "6" || b == "7" || b == "8" || b == "9" || b == ".") {
         rnum = rnum + "" + b;

      }

   }

   if(rnum == "" || rnum == "-") {
      rnum = 0;
   }

   rnum = Number(rnum);

   return rnum;

}



function fns(num, places, comma, type, show) {

    var sym_1 = "";
    var sym_2 = ""; 

    var isNeg=0;

    if(num < 0) {
       num=num*-1;
       isNeg=1;
    }

    var myDecFact = 1;
    var myPlaces = 0;
    var myZeros = "";
    while(myPlaces < places) {
       myDecFact = myDecFact * 10;
       myPlaces = Number(myPlaces) + Number(1);
       myZeros = myZeros + "0";
    }
    
	onum=Math.round(num*myDecFact)/myDecFact;
		
	integer=Math.floor(onum);

	if (Math.ceil(onum) == integer) {
		decimal=myZeros;
	} else{
		decimal=Math.round((onum-integer)* myDecFact)
	}
	decimal=decimal.toString();
	if (decimal.length<places) {
        fillZeroes = places - decimal.length;
	   for (z=0;z<fillZeroes;z++) {
        decimal="0"+decimal;
        }
     }

   if(places > 0) {
      decimal = "." + decimal;
   }

   if(comma == 1) {
	integer=integer.toString();
	var tmpnum="";
	var tmpinteger="";
	var y=0;

	for (x=integer.length;x>0;x--) {
		tmpnum=tmpnum+integer.charAt(x-1);
		y=y+1;
		if (y==3 & x>1) {
			tmpnum=tmpnum+",";
			y=0;
		}
	}

	for (x=tmpnum.length;x>0;x--) {
		tmpinteger=tmpinteger+tmpnum.charAt(x-1);
	}


	finNum=tmpinteger+""+decimal;
   } else {
      finNum=integer+""+decimal;
   }

    if(isNeg == 1) {
       if(type == 1 && show == 1) {
          finNum = "-" + sym_1 + "" + finNum + "" + sym_2;
       } else {
          finNum = "-" + finNum;
       }
    } else {
       if(show == 1) {
          if(type == 1) {
             finNum = sym_1 + "" + finNum + "" + sym_2;
          } else
          if(type == 2) {
             finNum = finNum + "%";
          }

       }

    }

	return finNum;
}


function computeForm(form) {

   var VunitCost = sn(document.calc.unitCost.value);
   var VunitsPerDay = sn(document.calc.unitsPerDay.value);
   var VsmokeDaysPerPeriod = sn(document.calc.smokeDaysPerPeriod.value);
   var VnumYears = sn(document.calc.numYears.value);
   var VintRate = sn(document.calc.intRate.value);

   if(VunitCost == 0) {
      alert("Please enter the average cost per selected unit.");
      document.calc.unitCost.focus();
   } else
   if(VunitsPerDay == 0) {
      alert("Please the number of selected-units smoked per day.");
      document.calc.unitsPerDay.focus();
   } else
   if(VsmokeDaysPerPeriod == 0) {
      alert("Please enter number of smoking days per selected period of time.");
      document.calc.smokeDaysPerPeriod.focus();
   } else
   if(VnumYears == 0) {
      alert("Please enter number of years you would like to calculate the savings for.");
      document.calc.numYears.focus();
   } else
   if(VintRate == 0) {
      alert("Please enter the interest rate you could earn if you invested the savings from quitting smoking.");
      document.calc.intRate.focus();
   } else {

      var Vunit = document.calc.unit.options[document.calc.unit.selectedIndex].value;

      var costPerCig = VunitCost / Vunit;

      var VdailyUnits = document.calc.dailyUnits.options[document.calc.dailyUnits.selectedIndex].value;

      var cigsPerDay  = VunitsPerDay * VdailyUnits;

      var VsmokeDayPeriod = document.calc.smokeDayPeriod.options[document.calc.smokeDayPeriod.selectedIndex].value;

      var smokeDaysPerMonth = VsmokeDayPeriod * VsmokeDaysPerPeriod / 12;

      var monthlySavings = costPerCig * cigsPerDay * smokeDaysPerMonth;

      if (VintRate >= 1.0) {
         VintRate /= 100;
      }
      VintRate /= 12;

      var numMonths = VnumYears * 12;

      var prin = 0;
      var count = 0;
      var yearCount = 0;
      var intEarned = 0;
      var accumInt = 0;
      var accumAnnSave = 0;
      var accumAnnInt = 0;

      var chart_rows = "";
      var numCol = "";
      var intCol = "";
      var saveCol = "";
      var balCol = "";

      while(count < numMonths) {

         count = Number(count) + Number(1);

         intEarned = prin * VintRate;
         prin = Number(prin) + Number(monthlySavings) + Number(intEarned);
         accumInt = Number(accumInt) + Number(intEarned);
         accumAnnInt = Number(accumAnnInt) + Number(intEarned);
         accumAnnSave = Number(accumAnnSave) + Number(monthlySavings);

         if((count > 1 && count % 12 == 0) || count  == numMonths) {

            yearCount = Number(yearCount) + 1;

            numCol = yearCount;
            intCol = fns(accumAnnInt,2,1,1,1);
            saveCol =fns(accumAnnSave,2,1,1,1);
            balCol = fns(prin,2,1,1,1);



            accumAnnInt = 0;
            accumAnnSave = 0;

         }

      }

      var VmoneySaved = monthlySavings * numMonths;
      document.calc.moneySaved.value = fns(VmoneySaved,2,1,1,1);

      document.calc.intEarned.value = fns(accumInt,2,1,1,1);

      var VgrandTotal = Number(VmoneySaved) + Number(accumInt);
      document.calc.grandTotal.value = fns(VgrandTotal,2,1,1,1);

 


   }
}

function clear_results(form) {

   var chart_fld = document.getElementById("save_chart");
   chart_fld.innerHTML = "";

   document.calc.moneySaved.value = "";
   document.calc.intEarned.value = "";
   document.calc.grandTotal.value = "";


}

function reset_calc(form) {

   var chart_fld = document.getElementById("save_chart");
   chart_fld.innerHTML = "";

   document.calc.reset();

   document.calc.unitCost.focus();

}</script>



<form name="calc" method="post" action="#">

<p> <font> Cost per</font></p>
<p> <font>
 <select name="unit" onchange="clear_results(this.form)" style="display:inline;">
 <option value="1" selected="selected">Cigarette</option>
 <option value="20">Pack</option>
 <option value="200">Carton</option>
 </select></font></p>
<p> <input name="unitCost" value="5.00" onkeyup="clear_results(this.form)" type="text" size="20" maxlength="20" ></p>


<hr>

<p> <font>Everyday I am smoking</font> </p>

<p> <input name="unitsPerDay" value="20" onkeyup="clear_results(this.form)" type="text" size="20" maxlength="20" ></p>

<p> <font>
 <select name="dailyUnits" onchange="clear_results(this.form)" style="display:inline;">
 <option value="1" selected="selected">Cigarettes</option>
 <option value="20">Packs</option>
 </select></font></p>

<hr>

<p hidden> <font> Number of smoke days per</font></p>

<p hidden> <input name="smokeDaysPerPeriod" value="7" onkeyup="clear_results(this.form)" type="text" size="20" maxlength="20" ></p>

<p hidden> <font>
 <select name="smokeDayPeriod" onchange="clear_results(this.form)" style="display:inline;">
 <option value="52" selected="selected">Week</option>
 <option value="12">Month</option>
 <option value="1">Year</option>
 </select></font></p>


<p> <font> Number of years I would like to calculate the savings for:</font></p>
<p> <input name="numYears" value="10" onkeyup="clear_results(this.form)" type="text" size="20" maxlength="20" ></p>
<p> <font> Interest rate I could earn if I invest the savings (%): </font> </p>
<p> <input name="intRate" value="5" onkeyup="clear_results(this.form)" type="text" size="20" maxlength="20" ></p>
<p> <input class="button-action button replace blue" value="Calculate" onclick="computeForm(this.form)" type="button"></p>
<p> <font> Total cigarette savings: </font> </p>
<p> <input name="moneySaved" type="text" readonly="readonly" size="20" maxlength="20"></p>
<p> <font> Total Interest earned on savings: </font> </p>
<p> <input name="intEarned" type="text" readonly="readonly" size="20" maxlength="20"></p>
<p> <font> Balance of future quit-smoking savings account: </font> </p>
<p> <input name="grandTotal" type="text" readonly="readonly" size="20" maxlength="20"></p>

 
 </form>


 
<?php
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("tawhidurrahmandearfortynineWidget");') );?>