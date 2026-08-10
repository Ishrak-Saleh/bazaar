<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FreshnessChangeRequestDecisionMail;
use App\Models\ProductFreshnessChangeRequest;
use App\Models\ProductFreshnessLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ProductFreshnessChangeRequestController extends Controller
{
    public function index(): View
    {
        $requests = ProductFreshnessChangeRequest::with([
            'product',
            'vendor',
        ])
            ->latest()
            ->get();

        return view(
            'admin.freshness-requests.index',
            compact('requests')
        );
    }

    public function approve(
        Request $request,
        ProductFreshnessChangeRequest $freshnessRequest
    ): RedirectResponse {
        if ($freshnessRequest->status !== 'pending') {
            return back()->with(
                'error',
                'This request has already been reviewed.'
            );
        }

        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $product = $freshnessRequest->product;

        if (!$product) {
            return back()->with(
                'error',
                'The associated product could not be found.'
            );
        }

        DB::transaction(function () use (
            $freshnessRequest,
            $product,
            $validated
        ) {
            $oldArrivalDate = $product->arrival_date;
            $oldShelfLifeDays = $product->shelf_life_days;
            
            $product->update([
                'arrival_date' => $freshnessRequest->requested_arrival_date,
                'shelf_life_days' => $freshnessRequest->requested_shelf_life_days,
                'freshness_locked_at' => now(),
            ]);

            ProductFreshnessLog::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'old_arrival_date' => $oldArrivalDate,
                'new_arrival_date' => $product->arrival_date,
                'old_shelf_life_days' => $oldShelfLifeDays,
                'new_shelf_life_days' => $product->shelf_life_days,
                'changed_at' => now(),
            ]);

            $freshnessRequest->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'admin_note' => $validated['admin_note'] ?? null,
            ]);
        });

        Mail::to($freshnessRequest->vendor->email)
            ->send(
                new FreshnessChangeRequestDecisionMail(
                    $freshnessRequest,
                    'approved'
                )
            );

        return back()->with(
            'success',
            'Freshness change request approved and applied successfully.'
        );
    }

    public function deny(
        Request $request,
        ProductFreshnessChangeRequest $freshnessRequest
    ): RedirectResponse {
        if ($freshnessRequest->status !== 'pending') {
            return back()->with(
                'error',
                'This request has already been reviewed.'
            );
        }

        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ]);

        $freshnessRequest->update([
            'status' => 'denied',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_note' => $validated['admin_note'],
        ]);

        Mail::to($freshnessRequest->vendor->email)
            ->send(
                new FreshnessChangeRequestDecisionMail(
                    $freshnessRequest,
                    'denied'
                )
            );

        return back()->with(
            'success',
            'Freshness change request denied.'
        );
    }
}