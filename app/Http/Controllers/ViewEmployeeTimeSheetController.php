<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Timesheet;

class ViewEmployeeTimeSheetController extends Controller
{
  /*
   * Show List of Employees Timesheets in the system
   */
	public function index()
    {
		  $loggedInUser = Auth::user()->UserID;

      $timesheet_details = DB::select('CALL viewEmployeeTimesheet(0)');

      //Show All Employees Timesheet if it's Admin
      /*if(Auth::user()->Role == 1) {

        $timesheet_details = DB::select("select *, DATE_FORMAT(ts.Date, '%m/%d/%Y') as DateFormatted, TIME_FORMAT(ts.StartTime, '%h:%i %p') as StartTimeFormatted, TIME_FORMAT(ts.EndTime, '%h:%i %p') as EndTimeFormatted, TIME_FORMAT(TIMEDIFF(ts.EndTime,ts.StartTime), '%H:%i') as HoursWorked, (ts.Date >= CURDATE()-14) as CanEdit from timesheet ts inner join project p on ts.ProjectID = p.ProjectID inner join employee e on e.UserID=ts.UserID");
      } else {

        //Show All Employees Timesheet, working under logged in Supervisor's projects
        $timesheet_details = DB::select("select *, DATE_FORMAT(ts.Date, '%m/%d/%Y') as DateFormatted, TIME_FORMAT(ts.StartTime, '%h:%i %p') as StartTimeFormatted, TIME_FORMAT(ts.EndTime, '%h:%i %p') as EndTimeFormatted, TIME_FORMAT(TIMEDIFF(ts.EndTime,ts.StartTime), '%H:%i') as HoursWorked, (ts.Date >= CURDATE()-14) as CanEdit from timesheet ts inner join employee e on ts.UserID=e.UserID inner join project p on ts.ProjectID=p.ProjectID where ts.ProjectID in (select ProjectID from project where SupervisorID=$loggedInUser)");
      }*/

     	return view('viewemployeetimesheet', ['timesheet_details'=>$timesheet_details]);
  	}

  /*
   * Update Employees Existing Timesheet in the system
   */
  	public function updateTimesheet(Request $request)
    {
    	$UserID = $request->input('inputEmployeeId');
	    $ProjectID = $request->input('inputProjectId');
	    $Date = $request->input('inputDate');
	    $StartTime = $request->input('inputStartTime');
	    $EndTime = $request->input('inputEndTime');

		  Timesheet::where(['UserID'=> $UserID, 'ProjectID'=> $ProjectID, 'Date'=> $Date])
            ->update(['StartTime' => $StartTime, 'EndTime' => $EndTime]);

    	return redirect('/employee/viewemployeetimesheet');
  	}
}