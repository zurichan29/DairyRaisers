<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_Address;

use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;


class ClientController extends Controller
{
    public function menu()
    {
        return view('client.profile.menu');
    }

    public function address()
    {
        $address = User_Address::where('user_id', auth()->user()->id)->get();

        return view('client.profile.address', ['addresses' => $address]);
    }

    public function address_create()
    {
        $address = User_Address::where('user_id', auth()->user()->id)->get();

        if ($address->count() != 2) {

            return view('client.shop.location');
        } else {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'title' => 'Error',
                'body' => 'You have reach maximum address creation (2).',
                'period' => false,
            ]);
        }
    }

    public function address_store(Request $request)
    {
        $address = User_Address::where('user_id', auth()->user()->id)->get();

        if ($address->count() != 2) {
            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            $addresses = $request->validate([
                'region' => ['string', 'required', 'max:255'],
                'province' => ['string', 'required', 'max:255'],
                'barangay' => ['string', 'required', 'max:255'],
                'municipality' => ['string', 'required', 'max:255'],
                'street' => ['string', 'required', 'max:255'],
                'label' => ['required', 'max:255', 'in:home,office'],
                'zip_code' => ['integer', 'required', 'digits:4']
            ]);


            if (
                isset($addressData[$addresses['region']]) &&
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]) &&
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]) &&
                in_array($addresses['barangay'], $addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]['barangay_list'])
            ) {
                $regionName = $addressData[$request->input('region')]['region_name'];
                // User input is valid
            } else {
                // User input is invalid
                throw ValidationException::withMessages([
                    'error' => 'Something went wrong on the address value, please try again.',
                ]);
            }

            $user_address = new User_Address;
            $user_address->user_id = auth()->user()->id;
            $user_address->region = $regionName;
            $user_address->province = $request->input('province');
            $user_address->municipality = $request->input('municipality');
            $user_address->barangay = $request->input('barangay');
            $user_address->street = $request->input('street');
            $user_address->label = $request->input('label');
            $user_address->zip_code = $request->input('zip_code');
            ($address->count() == 0) ? $user_address->default = 1 : $user_address->default = 0;

            $user_address->save();

            return redirect()->route('profile.address')->with('message', [
                'type' => 'info',
                'title' => 'New Address',
                'body' => 'You have successfully created a new address.',
                'period' => false,
            ]);
        }

        throw ValidationException::withMessages([
            'error' => 'Maximum user address',
        ]);
    }

    public function address_delete(Request $request)
    {
        $address = User_Address::where('id', $request->id)->where('user_id', auth()->user()->id)->first();

        if ($address) {
            $isDefault = $address->default;
            $address->delete();

            if ($isDefault) {
                $newDefaultAddress = User_Address::where('user_id', auth()->user()->id)
                    ->where('id', '<>',  $request->id)
                    ->first();

                if ($newDefaultAddress) {
                    $newDefaultAddress->default = 1;
                    $newDefaultAddress->save();
                }
            }
            
            return redirect()->route('profile.address')->with('message', [
                'type' => 'info',
                'title' => 'Address update',
                'body' => 'User address has been deleted.',
                'period' => false,
            ]);
            // return response()->json(['address' => $address]);
        } else {
            // return response()->json(['errors' => $address],422);
            return redirect()->route('profile.address')->with('message', [
                'type' => 'error',
                'title' => 'Error',
                'body' => 'Something went wrong. Please try again.',
                'period' => false,
            ]);
        }
    }

    public function address_edit($id)
    {
        $address = User_Address::where('id', $id)->where('user_id', auth()->user()->id)->first();
        
        if ($address) {
            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            $allowedRegionCodes = ['01', '02', '03', '4A', '05', 'CAR', 'NCR'];

            $regions = array_filter($addressData, function ($regionCode) use ($allowedRegionCodes) {
                return in_array($regionCode, $allowedRegionCodes);
            }, ARRAY_FILTER_USE_KEY);

            return view('client.profile.EditAddressForm', compact('address', 'regions', 'addressData'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function address_update(Request $request, $id)
    {
        $address = User_Address::where('user_id', auth()->user()->id)->where('id', $id)->first();

        if ($address) {
            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            $addresses = $request->validate([
                'region' => ['string', 'required', 'max:255'],
                'province' => ['string', 'required', 'max:255'],
                'barangay' => ['string', 'required', 'max:255'],
                'municipality' => ['string', 'required', 'max:255'],
                'street' => ['string', 'required', 'max:255'],
                'label' => ['required', 'max:255', 'in:home,office'],
                'zip_code' => ['integer', 'required', 'digits:4']
            ]);

            if (
                isset($addressData[$addresses['region']]) &&
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]) &&
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]) &&
                in_array($addresses['barangay'], $addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]['barangay_list'])
            ) {
                $regionName = $addressData[$addresses['region']]['region_name'];
            } else {
                throw ValidationException::withMessages([
                    'address' => 'Something went wrong with the address value, please try again.',
                ]);
            }
            $address['region'] = $regionName;
            $address['province'] = $addresses['province'];
            $address['municipality'] = $addresses['municipality'];
            $address['barangay'] = $addresses['barangay'];
            $address['street'] = $addresses['street'];
            $address['zip_code'] = $addresses['zip_code'];
            $address['label'] = $addresses['label'];
            $address->save();

            return redirect()->route('profile.address')->with('message', [
                'type' => 'info',
                'title' => 'Address updated',
                'body' => 'Address has been updated.',
                'period' => false,
            ]);
        } else {
            return redirect()->route('index');
        }
    }

    public function address_default(Request $request)
    {
        $address = User_Address::where('id', $request->id)->where('user_id', auth()->user()->id)->first();

        if ($address && $address->default == 0) {
            $currentDefault = User_Address::where('user_id', auth()->user()->id)
                ->where('default', 1)
                ->first();
            if ($currentDefault) {
                $currentDefault->default = 0;
                $currentDefault->save();
            }
            $address->default = 1;
            $address->save();

            return redirect()->route('profile.address')->with('message', [
                'type' => 'info',
                'title' => 'Address update',
                'body' => 'Address has been selected as default.',
                'period' => false,
            ]);
        } else {
            return redirect()->route('profile.address')->with('message', [
                'type' => 'error',
                'title' => 'Error',
                'body' => 'Invalid address or already set as default.',
                'period' => false,
            ]);
        }
    }

    public function editName(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255|min:3',
            'last_name' => 'required|string|max:255|min:3',
            'mobile_number' => ['required', 'integer', 'digits:10', 'regex:/^9/'],
        ]);

        $user = User::where('id', auth()->user()->id)->first();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->mobile_number = $request->mobile_number;

        $user->save();

        return redirect()->route('profile')->with('message', [
            'type' => 'success',
            'title' => 'Profile updated',
            'body' => 'Your profile has been updated.',
            'period' => false,
        ]);
    }

    public function showChangePassForm()
    {
        return view('client.profile.ChangePassForm');
    }

    public function validatePass(Request $request)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                'min:6',
                'different:current_password',
                'regex:/^(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/',
            ],
        ], [
            'password.regex' => 'The password must be at least 6 characters long and contain at least one uppercase letter and one number.',
            'password.different' => 'The new password must be different from the current password.',
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Incorrect current password',
            ]);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('profile')->with('message', [
            'type' => 'info',
            'title' => 'Profile Update',
            'body' => 'Your password has been updated successfully.',
            'period' => false,
        ]);
    }

    public function EmailForm()
    {
        if (auth()->check()) {
            $user = User::where('id', auth()->user()->id)->first();
            if ($user->email != NULL && $user->email_verified_at == NULL) {
                return view('client.profile.verifyEmail', ['user' => $user]);
            } else if ($user->email == NULL) {
                return view('client.profile.EmailForm');
            } else {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function EmailVerifyShow()
    {
        if (auth()->check()) {
            $user = User::where('id', auth()->user()->id)->first();
            if ($user->email != NULL && $user->email_verified_at == NULL) {
                return view('client.profile.verifyEmail', ['user' => $user]);
            } else {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function createEmail(Request $request)
    {
        if (auth()->check()) {
            $user = User::where('id', auth()->user()->id)->first();

            $token = Str::random(40);

            // Validate the uniqueness of the token
            $validator = Validator::make($request->all(), [
                'verification_token' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('users')->where(function ($query) use ($token) {
                        return $query->where('verification_token', $token);
                    }),
                ],
            ]);

            // If the token is not unique, generate a new one
            if ($validator->fails()) {
                $token = Str::random(40);
            }

            $request->validate([
                'email' => 'required|email',
            ]);

            $user->email = $request->input('email');
            $user->email_verify_token = $token;
            $user->save();

            Mail::to($user->email)->send(new VerifyEmail($user));

            return redirect()->route('email.show');
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function resendMail()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user && auth()->check()) {

            if ($user->email_code_cooldown != null && $user->email_code_cooldown <= Carbon::now()) {
                $user->email_code_cooldown = null;
                $user->email_code_count = 0;
                $user->save();
            }

            if ($user->email_code_count < 3) {

                $token = Str::random(40);
                $user->email_verify_token = $token;
                $user->email_code_count = $user->email_code_count + 1;
                $user->save();
                Mail::to($user->email)->send(new VerifyEmail($user));
                return redirect()->back()->with('message', 'Code successfully sent. Please again your mailbox.');
            }

            if ($user->email_code_cooldown == NULL) {
                $user->email_code_cooldown = Carbon::now()->addMinutes(60);
                $user->save();
            }

            $remainingTime = Carbon::createFromFormat('Y-m-d H:i:s', $user->email_code_cooldown)->format('Y-m-d g:i A');

            return redirect()->back()->withErrors('resend', 'You have reach maximum sent of OTP. Please wait in ' . $remainingTime);
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function verifyEmail($token, $email)
    {
        $user = User::where('email', $email)->where('email_verify_token', $token)->first();

        if (!$user) {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }

        $user->email_code_count = 0;
        $user->email_code_cooldown = null;
        $user->email_verified_at = Carbon::now();
        $user->email_verify_token = null;
        $user->save();

        return redirect('/')->with('success', 'Email verified successfully.');
    }

    public function ChangeEmailForm()
    {
        if (auth()->check()) {
            $user = User::where('id', auth()->user()->id)->first();
            if ($user->email != NULL && $user->email_verified_at == NULL) {
                return view('client.profile.changeEmail');
            } else {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function ChangeEmail(Request $request)
    {
        if (auth()->check()) {
            $user = User::where('id', auth()->user()->id)->first();
            if ($user->email) {
                $token = Str::random(40);

                // Validate the uniqueness of the token
                $validator = Validator::make($request->all(), [
                    'verification_token' => [
                        'nullable',
                        'string',
                        'max:255',
                        Rule::unique('users')->where(function ($query) use ($token) {
                            return $query->where('verification_token', $token);
                        }),
                    ],
                ]);

                // If the token is not unique, generate a new one
                if ($validator->fails()) {
                    $token = Str::random(40);
                }

                $user = User::where('id', auth()->user()->id)->first();

                $request->validate([
                    'email' => 'required|email',
                ]);

                $user->email = $request->input('email');
                $user->email_verify_token = $token;
                $user->save();

                Mail::to($user->email)->send(new VerifyEmail($user));

                return redirect()->route('email.show');
            } else {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }
}
