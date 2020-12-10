<?php

namespace App\Http\Controllers\API\User;
use App\Models\EmployeePersonal;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeePersonalController extends Controller
{
    use MustVerifyEmail;

    public $successStatus = 200;

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'emp_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        unset($input['c_password']);   
        $input['password'] = bcrypt($input['password']);
        $input['created_emp'] = $request->user()->id;
        $input['updated_emp'] = $request->user()->id;
        DB::beginTransaction();
        try {
            $user = EmployeePersonal::create($input);
            // send verification email
            $user->sendApiEmailVerificationNotification();
            $data['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
            $data['token'] = $user->createToken('MyApp')->accessToken;
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info($th->getMessage());
            $data['message'] = $th->getMessage();
        }
        return response()->json(['data' => $data], $this->successStatus);
    }

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request) {
        if(Auth::attempt(['email'=>$request->input('email'), 'password'=>$request->input('password')])) {
            $user = Auth::user();
            if($user->email_verified_at !== NULL){
                $success['token'] = $user->createToken('MyApp')->accessToken;
                return response()->json(['success' => $success], $this->successStatus); 
            }else{
                return response()->json(['error'=>'Please Verify Email'], 401);
            }
        } else {
            return response()->json(['error'=>'Unauthorised'], 401); 
        }
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details() {
        $user = Auth::user();
        return response()->json(['success'=>$user], $this->successStatus);
    }

}
