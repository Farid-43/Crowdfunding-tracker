<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DonationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Anyone can make a donation
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'amount' => 'required|numeric|min:1|max:100000',
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
            'anonymous' => 'boolean',
            'reward_id' => 'nullable|exists:rewards,id',
        ];

        // For guest users, name and email are required
        if (!Auth::check()) {
            $rules['donor_name'] = 'required|string|max:255';
            $rules['donor_email'] = 'required|email|max:255';
        }

        return $rules;
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $rewardId = $this->input('reward_id');
            $amount = $this->input('amount');
            
            if ($rewardId && $amount) {
                $reward = \App\Models\Reward::find($rewardId);
                
                if ($reward) {
                    // Check if reward belongs to the campaign
                    $campaign = $this->route('campaign');
                    if ($reward->campaign_id !== $campaign->id) {
                        $validator->errors()->add('reward_id', 'The selected reward does not belong to this campaign.');
                    }
                    
                    // Check if donation amount meets minimum
                    if ($amount < $reward->minimum_amount) {
                        $validator->errors()->add('amount', "The minimum donation amount for this reward is ${$reward->minimum_amount}.");
                    }
                    
                    // Check if reward is available
                    if (!$reward->is_available) {
                        $validator->errors()->add('reward_id', 'The selected reward is no longer available.');
                    }
                }
            }
        });
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'amount.required' => 'Please enter a donation amount.',
            'amount.numeric' => 'The donation amount must be a valid number.',
            'amount.min' => 'The minimum donation amount is $1.',
            'amount.max' => 'The maximum donation amount is $100,000.',
            'donor_name.required' => 'Please enter your name.',
            'donor_email.required' => 'Please enter your email address.',
            'donor_email.email' => 'Please enter a valid email address.',
            'message.max' => 'Your message cannot exceed 1000 characters.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'donor_name' => 'name',
            'donor_email' => 'email',
        ];
    }
}
