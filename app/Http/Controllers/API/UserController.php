<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Mail;

class UserController extends BaseController
{
    /*
    *   User login functions
    */
    public function login(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $password = $input['password'];
        
        $validator = Validator::make($input, [

            'email' => 'required|email',
            'password' => 'required',
            ]);
            
            if($validator->fails())
            {
                return $this->sendError('Validation Error.', $validator->errors(),401); 
            
            }

            try
            {
                if(Auth::attempt(['email' => $email, 'password' => $password]))
                { 
                    $user = Auth::user(); 
                    $success['token'] =  $user->createToken('MyApp')->accessToken;
                    $success['name']  = $user->name;
                    $success['id']  = $user->id;
                    $success['email']  = $user->email;
                    return $this->sendResponse($success,'Login successful'); 
                } 
                else
                { 
                    return $this->sendError('Invalid credentials.','', 401); 
                } 
            }
            catch (\Exception $e)
            {
                return $this->sendError('Internal server error', $e->getMessage(),401);
            }
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password'

        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors(),401); 
        
        }

        try
        {
            $mailData = array();
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 
            $user = User::create($input); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
            $success['id'] =  $user->id;

            return $this->sendResponse($success,'User registered successfully');
        }
        catch (\Exception $e) 
        {
            return $this->sendError('Email already exists', $e->getMessage(),401);
        }
    }

    public function logout(Request $request)
    {
        try
        {
            $token = $request->user()->token();
            $token_arr = json_decode($token,true);
            $user_id = $token_arr['user_id'];

            $token->revoke();
        
            $response = 'You have been succesfully logged out!';
            return $this->sendResponse([], $response);
        }
        catch(\Exception $e)
        {
            return $this->sendError('Internal server error', $e->getMessage(),401);
        }
    }
}

?>