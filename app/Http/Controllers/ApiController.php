<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use DB;

use App\Models\ApplicationNotification;


class ApiController extends BaseController
{
    public function create_loan(Request $request)
    {
        $input = $request->all();
        $input['notification_month'] = $request->total_month * 2;
        $input['status'] = 1;

        $response = DB::table('user_loans')->insert($input);
        return $this->sendResponse($input, 'Created');
    }

    public function complete_loan(Request $request)
    {
        $data = DB::table('user_loans')->where('loan_token',$request->loan_token)->first();
        if(!is_null($data)){

            $input['status'] = 0;
            DB::table('user_loans')->where('loan_token',$request->loan_token)->update($input);

            return $this->sendResponseSuccess('Completed');
        }else{
            return $this->sendError('Data Not Found');
        }
    }

    public function test_cron() {

        $today = date("d");
        $today = 28;

        if($today == "28"){
            $data = DB::table('user_loans')->where('notification_month','!=',0)->where('status',1)->get();
            if(count($data) > 0){

                foreach ($data as $key => $id) {

                    $notificationSendData['notification_id'] = config('app.notification_id');
                    $notificationSendData['notification_key'] = config('app.notification_key');
                    $notificationSendData['notification_title'] = "Loan Reminder";
                    $notificationSendData['notification_url'] = "";
                    $notificationSendData['notification_description'] = "Your loan is due soon. Please make sure to pay on time.";
                    $notificationSendData['notification_image'] =  asset('public/ic_appicon.png');
                    $send_notification = ApplicationNotification::sendOneSignalNotificationSchedule($notificationSendData);

                    # remove month count
                    return "done";
                }
            }
        }
        return "back";

    }

}
