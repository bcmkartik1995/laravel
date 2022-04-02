<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use App\Lead;
use App\contact_us;

class RegisterprofessionalController extends Controller
{
    use ApiResponser;

    public function register_professional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:leads,email|unique:admins,email',
            'phone' => 'required|numeric|digits:10|unique:leads,phone|unique:admins,phone',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $lead = new Lead;
        $lead->name = $request->input('name');
        $lead->email = $request->input('email');
        $lead->phone = $request->input('phone');
        $lead->country_id = $request->input('country_id');
        $lead->state_id = $request->input('state_id');
        $lead->city_id = $request->input('city_id');
        $lead->skill = $request->input('message');

        $lead->save();

        return $this->success([
            'lead' => $lead,
        ]);
    }

    public function contact_us(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits:10',
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $contact_us = new contact_us;
        $contact_us->name = $request->name;
        $contact_us->email = $request->email;
        $contact_us->phone = $request->phone;
        $contact_us->comment = $request->message;

        $contact_us->save();

        return $this->success([
            'contact_us' => $contact_us,
        ]);

    }
}
