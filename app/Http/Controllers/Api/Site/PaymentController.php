<?php

namespace App\Http\Controllers\Api\Site;

use App\Models\Tiding;
use App\Http\Controllers\Controller;
use App\Models\UserTenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\TidingResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    public function getSessionId(Request $request)
    {
        $token = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';
        $response = \Http::withToken($token, 'Bearer')
            ->post('https://apitest.myfatoorah.com/v2/InitiateSession', [
                'CustomerIdentifier' => $request->CustomerIdentifier,
                "CountryCode" => "KWT"
            ]);
        if ($response->successful()) {
            return $response->json();
        }
        abort($response->status(), 'Error during request.');
    }


    public function getInvoice(Request $request)
    {
        $token = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';
        $response = \Http::withToken($token, 'Bearer')
            ->post('https://apitest.myfatoorah.com/v2/ExecutePayment', [
                'SessionId' => $request->sessionId,
                'InvoiceValue' => $request->invoiceValue,
                'CallBackUrl' => 'http://localhost:39222/checkout/status/success',
                'ErrorUrl' => 'http://localhost:39222/checkout/status/failed',
            ]);
        if ($response->successful()) {
            return $response->json();
        }

        abort($response->status(), 'Error during request.');
    }

    public function renewTenant(Request $request)
    {
        $user_tenant = UserTenant::where('user_id', $request->domain)->first();
        $user_tenant->update([
            'is_paid' => 1,
            'amount' => $request->amount,
            'invoice_number' => $request->invoice_number,
            'expired_at' => Carbon::now()->addMonths($request->duration),
        ]);
        $user_tenant->user->update([
            'is_block' => 0,
        ]);

        return true;
    }
}
