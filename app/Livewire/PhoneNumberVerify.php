<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Twilio\Rest\Client;

class PhoneNumberVerify extends Component
{
    public $code = null;
    public $error;

    public function mount()
    {
        if (Auth::user() && Auth::user()->phone_verified == 1){
            return redirect()->route('dashboard');
        }

        // Check if OTP has been sent recently
        if(Carbon::parse(Auth::user()->last_otp_sent_at)->addMinutes(5)->isPast()) {
            $this->sendCode();
        }
    }
    public function sendCode()
    {
        try {
            $twilio = $this->connect();
            $verification = $twilio->verify
                ->v2
                ->services(config('services.twilio.vsid'))
                ->verifications
                ->create("+91".str_replace('-', '', Auth::user()->phone_number), "sms");

            if ($verification->status === "pending") {
                session()->flash('message', 'OTP sent successfully');
            }
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            session()->flash('error', $this->error);
        }
    }

    public function verifyCode()
    {
        $twilio = $this->connect();
        try {
            $check_code = $twilio->verify
                ->v2
                ->services(config('services.twilio.vsid'))
                ->verificationChecks
                ->create(
                    [
                        "to" => "+91" . str_replace('-', '', Auth::user()->phone_number),
                        "code" => $this->code
                    ]
                );

            if ($check_code->valid === true) {
                User::where('id', Auth::user()->id)
                    ->update([
                        'phone_verified' => $check_code->valid
                    ]);

                $redirectTo = Auth::user()->is_admin ? route('dashboard') : route('dashboard');
                return redirect();
            } else {
                session()->flash('error', 'Verification failed, Invalid code.');
            }
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            session()->flash('error', $this->error);
        }
    }

    public function connect()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        return new Client($sid, $token);
    }

    public function render()
    {
        return view('livewire.phone-number-verify');
    }
}
