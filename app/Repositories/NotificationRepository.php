<?php 

namespace App\Repositories;

use App\Generic;
use App\Employee;
use App\Medicine;
use Carbon\Carbon;
use App\Diagnosis;
use App\Preemployment;
use App\Employeesmedical;
use Illuminate\Support\Facades\Gate;

/**
* Movie Repository class
*/
class NotificationRepository
{
    /**
     * Get a list of all movies
     *
     * @return array  Array containing list of all movies
     */
    public function getNotificationList()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')){
            $empsMedsCount = Employeesmedical::where('remarks', 'followUp')->count();
        }
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')){

            $preEmp = Preemployment::get();
            if ($preEmp->count() > 0) {
                foreach ($preEmp as $preEmpID) {
                    $array[] = $preEmpID->employee_id;
                }

                $noPreEmpMedsCount = Employee::whereNotIn('id', $array)->count();
            }else{
                $noPreEmpMedsCount = Employee::count();
            }
        }
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor')){
            $empsMedFF =  Employeesmedical::where('seen', 0)->count();
        }
        if (Gate::allows('isAdmin') || Gate::allows('isHr') ) { 

            $emps = Employee::where('tin_no', '=', NULL)->orWhere('sss_no', '=', NULL)
                                                        ->orWhere('philhealth_no', '=', NULL)
                                                        ->orWhere('hdmf_no', '=', NULL)
                                                        ->count();
                                                        
            $emps2 = Employee::where('employee_type', 0)->get();
            foreach ($emps2 as $reg) {

                $hired_month = $reg->hired_date->diff(Carbon::now())->format('%m');
                $hired_year = $reg->hired_date->diff(Carbon::now())->format('%y');
                $month = (int)$hired_month;
                $year = (int)$hired_year;
                if ($month > 5 || $year >= 1) {
                    $arr[] = $reg->hired_date->diffForHumans();
                }
            }
        }
        return [
             'admin_nurse_doctor' =>  @$empsMedsCount + @$noPreEmpMedsCount,
             'admin_doctor' =>  @$empsMedFF,
             'admin_hr' =>  @$emps,
             'admin_hr2' =>  (@$arr != null) ? count(@$arr) : NULL,
        ];
    }
}