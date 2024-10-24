<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPrice;
class UserPriceSettingsController extends Controller
{
    //


    public function updateUserPriceSettings(Request $request)
    {
       
        try {
            // Validate the request to ensure the data is present and valid
            $request->validate([
                'user_labels' => 'required|array',
                'user_labels.*' => 'required|numeric|exists:users,id', // Check if each user exists in the database
                'user_price' => 'nullable|array',
                'user_price.*' => 'nullable|string|min:1', // Ensure the price is a valid number and non-negative
                'type' => 'nullable|array',
                'type.*' => 'nullable|string|min:1',
            ]); 
    
            // Proceed if validation passes
            if ($request->has('user_labels') && $request->has('user_price')) {
                $userLabels = $request->user_labels;  // user ids
                $userPrices = $request->user_price;
                $type = $request->type;
    
                foreach ($userLabels as $key => $user_id) {
                    // Use a try-catch block for each update/creation process
                    try { 
                        // Find an existing user price setting by user_id
                        $userPriceSetting = UserPrice::where('user_id', $user_id)->first();
    
                        if ($userPriceSetting) {
                            // If it exists, update the price
                            $userPriceSetting->price = $userPrices[$key]==null || ''? null: $userPrices[$key];
                            $userPriceSetting->type = $type[$key]==null || ''? null: $type[$key];
                        } else {
                            // If it doesn't exist, create a new entry
                            $userPriceSetting = new UserPrice();
                            $userPriceSetting->user_id = $user_id;
                            $userPriceSetting->price = $userPrices[$key]==null || ''? null: $userPrices[$key];
                            $userPriceSetting->type = $type[$key]==null || ''? null: $type[$key];
                        }
    
                        // Save the entry (either updated or newly created)
                        $userPriceSetting->save();
                    } catch (\Exception $e) {
                        // Log the error for debugging
                        \Log::error('Failed to update or create UserPriceSetting for user_id: ' . $user_id . '. Error: ' . $e->getMessage());
    
                        // Return an error message specific to this user's data
                        return redirect()->back()->withErrors([
                            'message' => "Failed to update price for user ID: $user_id. Please try again."
                        ]);
                    }
                }
            }
    
            // Success message if everything goes well
            return redirect()->back()->with('message', "Price updated successfully.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation errors and return them back to the user
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log any unexpected error
            \Log::error('Unexpected error during price update: ' . $e->getMessage());
    
            // Return a general error message
            return redirect()->back()->with('error', "An unexpected error occurred. Please try again later.");
        }
    }


    public function deleteUserPriceSettings($id){
        // Check if the user exists in the database
        $userPriceSetting = UserPrice::find($id);
        if ($userPriceSetting) {
            // Delete the user price setting
            $userPriceSetting->delete();
            return response()->json([
                "status" => 200,
                "message" => "User price setting deleted successfully."
            ]);
        } else {
            return response()->json([
                "status" => 400,
                "message" => "Something Went Wrong."
            ]);
        }

    }
    
    
}
