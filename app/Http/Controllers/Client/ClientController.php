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
        $address = User_Address::where('id', $request->address_id)->where('user_id', auth()->user()->id)->first();

        if ($address) {
            $isDefault = $address->default;
            $address->delete();

            if ($isDefault) {
                $newDefaultAddress = User_Address::where('user_id', auth()->user()->id)
                    ->where('id', '<>',  $request->address_id)
                    ->first();

                if ($newDefaultAddress) {
                    $newDefaultAddress->default = 1;
                    $newDefaultAddress->save();
                }
            }

            $addresses = User_Address::where('user_id', auth()->user()->id)->get();
            if ($request->ajax()) {
                return view('client.profile.reload-address', compact('addresses'));
            }
        } else {
            return response()->json(['errors' => $address], 422);
        }
    }

    public function address_edit($id)
    {
        $address = User_Address::where('user_id', auth()->user()->id)->where('id', $id)->first();

        if ($address) {
            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            return view('client.profile.editAddressForm', compact('address', 'addressData'));
        } else {
            return redirect()->route('index');
        }
    }

    public function address_update(Request $request, $id)
    {
        $address = User_Address::where('user_id', auth()->user()->id)->where('id', $id)->first();

        if ($address) {
            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            $addresses = $request->validate([
                'barangay' => ['string', 'required', 'max:255'],
                'municipality' => ['string', 'required', 'max:255'],
                'street' => ['string', 'required', 'max:255'],
                'zip_code' => ['integer', 'required', 'digits:4']
            ]);

            // Set the fixed region and province
            $addresses['region'] = '4A';
            $addresses['province'] = 'CAVITE';

            // Validation for municipality and barangay
            $municipality = $request->input('municipality');
            $barangay = $request->input('barangay');

            // Validate if the municipality and barangay are valid within the fixed region and province
            if (
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$municipality]) &&
                in_array($barangay, $addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$municipality]['barangay_list'])
            ) {
                // Address validation successful, continue storing process

                // Rest of the code remains unchanged
            } else {
                throw ValidationException::withMessages([
                    'address' => 'Something went wrong with the address value, please try again.',
                ]);
            }
            $address['region'] = $addresses['region'];
            $address['province'] = $addresses['province'];
            $address['municipality'] = $addresses['municipality'];
            $address['barangay'] = $addresses['barangay'];
            $address['street'] = $addresses['street'];
            $address['zip_code'] = $addresses['zip_code'];
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
        $address = User_Address::where('id', $request->address_id)->where('user_id', auth()->user()->id)->first();
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

            $addresses = User_Address::where('user_id', auth()->user()->id)->get();
            if ($request->ajax()) {
                return view('client.profile.reload-address', compact('addresses'));
            }
        } else {

            return response()->json(['errors' => $address], 422);
        }
    }

    public function edit_profile(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $validator = Validator::make($request->all(), [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::unique('users', 'first_name')->ignore($user->id),
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::unique('users', 'last_name')->ignore($user->id),
            ],
            'mobile_number' => [
                'required',
                'integer',
                'digits:10',
                'regex:/^9/',
                Rule::unique('users', 'mobile_number')->ignore($user->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'user' => $user], 422);
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->mobile_number = $request->mobile_number;

        $user->save();

        if ($request->ajax()) {
            return view('client.profile.reload-user-name', compact('user'));
        }
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
}
