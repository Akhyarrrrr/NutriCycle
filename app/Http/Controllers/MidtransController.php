<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request): JsonResponse
    {
        $orderId = (string) $request->input('order_id');
        $statusCode = (string) $request->input('status_code');
        $grossAmount = (string) $request->input('gross_amount');
        $signature = (string) $request->input('signature_key');

        $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.config('midtrans.server_key'));

        abort_unless(hash_equals($expectedSignature, $signature), 403);

        $transactionStatus = (string) $request->input('transaction_status');
        $fraudStatus = (string) $request->input('fraud_status');

        $transaksi = Transaksi::where('kode_transaksi', $orderId)->firstOrFail();

        if (in_array($transactionStatus, ['capture', 'settlement'], true) && $fraudStatus !== 'deny') {
            $transaksi->update(['status_pembayaran' => 'paid']);
        }

        if (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'], true) || $fraudStatus === 'deny') {
            $transaksi->update(['status_pembayaran' => 'failed']);
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
