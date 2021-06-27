<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class UserDashboardController extends Controller
{

    public function addAddressData(Request $request)
    {
       
        $id = Auth::user()->id_ushop;

        $street = $request->input('name-of-street');
        $apartment_number = $request->input('apartment-number');
        $house_number = $request->input('house-number');
        $post_code = $request->input('post-code');
        $city = $request->input('name-of-city');
        $state = $request->input('name-of-state');

        DB::table('user_addresses')->insert([
            'name_of_city' => $city,
            'post_code' => $post_code,
            'name_of_street' => $street,
            'county' =>  $state,
            'apartment_number' => $apartment_number,
            'house_number' => $house_number,

        ]);
        //$address_id = DB::select( DB::raw("select id_user_address from user_addresses ORDER BY id_user_address DESC FETCH FIRST 1 ROWS ONLY") );
        $address_id = DB::table('user_addresses')->latest('id_user_address')->first();
        //$id_addr = $address_id->pluck('id_user_address');
        //$id_addr->all();

        DB::table('ushop')
        ->where('id_ushop', $id)
        ->update(['id_user_address' => $address_id->id_user_address]);

        return redirect()->route('user.dashboard')->with('message', 'Your address details have been added!');

       /// return view('frontend.privacy');
    }

    public function updateAccountData(Request $request)
    {
        //dd($request);
        $id = Auth::user()->id_ushop;
        
        $name = $request->input('user-name');
        $surname = $request->input('user-surname');
        $mobile = $request->input('user-mobile');
        $email = $request->input('user-email');

        DB::table('ushop')
        ->where('id_ushop', $id)
        ->update([
            'name' => $name,
            'surname' => $surname,
            'mobile' => $mobile,
            'email' => $email,
        ]);

        return redirect()->route('user.dashboard')->with('message', 'Your account data have been changed!');
    }
}
