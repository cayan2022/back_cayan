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
    protected $live_token;
    protected $test_token;

    protected $live_url;
    protected $test_url;

    public function __construct()
    {
        $live_token = 'fUIACWCgJMv7pc60Yc7mMDVSaUhRTZ8WAIv8lEJgrNb6W2Fg-i0fyZ6_56q_jXWx0rRjkih_8faMUFJ9HNKr9EjLkM1Ax3cS5i3ekDJFR3JIMHVI4JtUplmnjf4cCwOibVdym_j9R1hYZA4QraH7iuZmNgg8i1qgtAAE8HCdW0wTJnAAOAhBQMs_4QRjBXOYgL8mwz9lL_vumhXIU6T37xOmXJvbVqESwqjLQ6P9gjUrajCf7VcTsXBqC9oFHoN5toIJHshKzK8ngdtpJULt21mLAqsFf1DCQQ9A4zZZA2fT9ElYuqMyq2zLM5_yNrTBkK_n6wb4t9hnUHusy2JkIM_zVVQBteveWOR0ltWMonsHoN7SIprfxK8A9wdkapRlMDIxG-fATOMyWlElnq4ARS7wuI9DBjBtdxIwN8838h4CXco15fOEhFnF2oq0trjZOWtbg-0DF4sGqsqxEbw7f2byo0pE4aj4kc6ky3JKUkTy4bldnpEfFX41ew0a-yZ4DFY48GiCP27SnnWV3qtQbjSAxm9XfMhE9fztJuYLFEOgZgdSvqPETkEzzT2bnG1SQ-qjm0ozALmi2HBd7Ga2Fr1c7pBiDzPH9zm_D4zVtHiZmaVS2Ul86F1FgXkeOr4bAo-XeX7VQZDnnHcXZFsS5farPutkCQELVlSR-LQeF5F6tCv0CNkF48J5FJEDKAPOKcRXoy6zrmKbOYfYzVd5RDHTGkOyydotRQmNzp2gJpYHsw0t';
        $test_token = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn';
        $this->live_token = $live_token;
        $this->test_token = $test_token;
        $this->live_url = 'https://api-sa.myfatoorah.com/v2';
        $this->test_url = 'https://apitest.myfatoorah.com';
    }

    public function getSessionId(Request $request)
    {
        $token = $this->test_token;
        $response = \Http::withToken($token, 'Bearer')
            ->post($this->test_url . '/InitiateSession', [
                'CustomerIdentifier' => $request->CustomerIdentifier,
                "CountryCode" => "SAU"
            ]);
        if ($response->successful()) {
            return $response->json();
        }
        abort($response->status(), 'Error during request.');
    }


    public function getInvoice(Request $request)
    {
        $token = $this->test_token;
        $response = \Http::withToken($token, 'Bearer')
            ->post($this->test_url . '/ExecutePayment', [
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
        $user_tenant = UserTenant::where('domain', $request->domain)->first();
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
