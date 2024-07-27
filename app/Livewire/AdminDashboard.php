<?php

namespace App\Livewire;

use App\Http\Requests\CreateAccountRequest;
use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard');
    }

    public function create(Request $request)
    {
        $accounts = [];
        $users = [];
        foreach ($request->firstname as $index => $firstname){
            $accountNumber = hexdec(uniqid());
            $bankEmail = $accountNumber."@bank.com";
            $accounts [] = [
                'account_number' => $accountNumber,
                'firstname' => $firstname,
                'lastname' => $request->lastname[$index],
                'dob' => $request->dob[$index],
                'address' => $request->address[$index],
            ];

            $users [] = [
                'name' => $request->firstname[$index] ."".$request->lastname[$index],
                'email' => $bankEmail,
                'password' => Hash::make(preg_replace('/[^0-9]/', '', $request->dob[$index])),
                'is_admin' => 0,
                'last_otp_sent_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

       Account::insert($accounts);
        User::insert($users);
        return redirect(route('dashboard'));
    }
}
