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
        if (auth()->check()) {
            $user = User::where('id', auth()->user()->id)->first();
            return view('client.profile.menu', ['user' => $user]);
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function address()
    {
        if (auth()->check()) {
            $address = User_Address::where('user_id', auth()->user()->id)->get();

            return view('client.profile.address', ['addresses' => $address]);
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function createAddress(Request $request)
    {
        if (auth()->check()) {
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

                return redirect()->route('profile.address')->with('message', 'User Address Successfully created');
            }

            throw ValidationException::withMessages([
                'error' => 'Maximum user address',
            ]);
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function deleteAddress($id)
    {
        if (auth()->check()) {
            $address = User_Address::where('id', $id)->where('user_id', auth()->user()->id)->first();

            if ($address) {
                $isDefault = $address->default;
                $address->delete();

                if ($isDefault) {
                    $newDefaultAddress = User_Address::where('user_id', auth()->user()->id)
                        ->where('id', '<>', $id)
                        ->first();

                    if ($newDefaultAddress) {
                        $newDefaultAddress->default = 1;
                        $newDefaultAddress->save();
                    }
                }
                return redirect()->back()->with('success', 'User address has been deleted.');
            } else {
                // Address not found or does not belong to the authenticated user
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function editAddress($id)
    {
        if (auth()->check()) {
            $address = User_Address::findOrFail($id)->where('user_id', auth()->user()->id)->first();
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

        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function updateAddress(Request $request, $id)
    {
        if (auth()->check()) {

            $address = User_Address::findOrFail($id)->where('user_id', auth()->user()->id)->first();

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
                    // User input is valid
                } else {
                    // User input is invalid
                    throw ValidationException::withMessages([
                        'error' => 'Something went wrong with the address value, please try again.',
                    ]);
                }

                $address->region = $regionName;
                $address->province = $addresses['province'];
                $address->municipality = $addresses['municipality'];
                $address->barangay = $addresses['barangay'];
                $address->street = $addresses['street'];
                $address->label = $addresses['label'];
                $address->zip_code = $addresses['zip_code'];

                $address->save();

                return redirect()->route('profile.address')->with('message', 'User Address Successfully updated');
            } else {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function defaultAddress(Request $request)
    {
        $id = $request->query('id');
        if (auth()->check()) {
            $address = User_address::where('id', $id)->where('user_id', auth()->user()->id)->first();

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

                return redirect()->route('profile.address')->with('message', 'Default Address Successfully Changed');
            }

            return redirect()->route('profile.address')->with('error', 'Invalid address or already set as default');
        }

        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function editName(Request $request)
    {
        if (auth()->check()) {

            $data = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255|min:3',
                'last_name' => 'required|string|max:255|min:3',
            ]);

            if ($data->fails()) {
                return redirect()->back()
                    ->withErrors($data)
                    ->withInput();
            } else {
                $user = User::where('id', auth()->user()->id)->first();
                if ($user) {
                    $user->first_name = $request->input('first_name');
                    $user->last_name = $request->input('last_name');

                    $user->save();
                }
                return redirect()->back()->with('success', 'Data updated successfully');
            }
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function showChangePassForm()
    {
        if (auth()->check()) {
            return view('client.profile.ChangePassForm');
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
    }

    public function validatePass(Request $request)
    {
        if (auth()->check()) {
            $user = Auth::user();
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|confirmed|min:6|different:current_password|regex:/^(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/',
            ]);
            if (Hash::check($request->input('password'), $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'Incorrect password',
                ]);
            }

            $user->password = Hash::make($request->input('password'));
            $user->save();

            return redirect()->route('profile')->with('message', 'Password has been change successfully.');
        }
        throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
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
