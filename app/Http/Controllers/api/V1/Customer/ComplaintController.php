<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\ContactInquiryResource;
use App\Models\ContactInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $complaints = ContactInquiry::where('email', $user->email)->latest()->paginate(10);

        return $this->paginated($complaints, ContactInquiryResource::class, 'Complaints retrieved.');
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'subject' => ['required', 'string', 'min:3', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        do {
            $ref = 'FM-DIS-'.strtoupper(Str::random(6));
        } while (ContactInquiry::where('reference_no', $ref)->exists());

        $complaint = ContactInquiry::create([
            'reference_no' => $ref,
            'department' => 'escrow',
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '+923000000000',
            'city' => $user->city ?? 'Karachi',
            'message' => '['.$validated['subject'].'] '.$validated['message'],
            'status' => 'new',
        ]);

        return $this->created(new ContactInquiryResource($complaint), 'Your complaint ticket has been dispatched to FixMate arbitration supervisors.');
    }
}
