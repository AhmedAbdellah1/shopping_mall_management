<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        return Customer::select(
            'id',
            'brand_name',
            'brand_logo',
            'company_name',
            'tax_number',
            'contact_person_name',
            'contact_person_phone',
            'company_address',
            'shop_location',
            'start_date',
            'end_date'
        )->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required',
            'brand_logo' => 'nullable',
            'company_name' => 'required',
            'tax_number' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            'company_address' => 'required',
            'shop_location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imageName = Str::random() . '.' . $request->brand_logo->getClientOriginalExtension();
        $request->file('brand_logo')->move(public_path('images'), $imageName);

        $customer = Customer::create($request->except('brand_logo') + ['brand_logo' => $imageName]);

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer
        ]);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required',
            'brand_logo' => 'nullable',
            'company_name' => 'required',
            'tax_number' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            'company_address' => 'required',
            'shop_location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // This code is for storing data in the database except for the logo
        $customer->fill($request->except('brand_logo'))->update();

        // This code checks if the logo is uploaded or not
        if ($request->hasFile('brand_logo')) {
            // If the logo is uploaded, rename the logo and store it in the public folder
            $imageName = Str::random() . '.' . $request->file('brand_logo')->getClientOriginalExtension();
            $request->file('brand_logo')->move(public_path('images'), $imageName);

            // This code checks if a logo already exists in the database, and if it does, deletes it
            if ($customer->brand_logo) {
                $existingImage = 'images/' . $customer->brand_logo;
                if (Storage::exists($existingImage)) {
                    Storage::delete($existingImage);
                }
            }
            // Update the logo name in the database and save it
            $customer->brand_logo = $imageName;
            $customer->update();
        }
    }

    public function destroy(Customer $customer)
    {
        // This code checks if a logo already exists in the database, and if it does, deletes it
        if ($customer->brand_logo) {
            $existingImage = 'images/' . $customer->brand_logo;
            if (Storage::exists($existingImage)) {
                Storage::delete($existingImage);
            }
        }
        $customer->delete();
        return response()->json([
            'message' => 'Customer deleted successfully'
        ]);
    }
}
