<?php 

namespace App\Repositories;

use App\Diagnosis;
use App\Employee;
use App\Generic;
use App\Medicine;
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
                if ($reg->hired_date->diffForHumans() == '6 months ago' || $reg->hired_date->diffForHumans() == '5 months ago') {
                    $arr[] = $reg->hired_date->diffForHumans();
                }
            }
        }
        return [
             'admin_nurse_doctor' =>  @$empsMedsCount,
             'admin_doctor' =>  @$empsMedFF,
             'admin_hr' =>  @$emps,
             'admin_hr2' =>  (@$arr != null) ? count(@$arr) : NULL,
        ];
    }
}