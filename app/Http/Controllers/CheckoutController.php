<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
use App\Payment\PagSeguro\Boleto;
use App\Payment\PagSeguro\Notification;
use App\Store;
use App\UserOrder;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CheckoutController extends Controller
{
    public function index()
    {
        try {
            if (!auth()->check()) {
                return redirect()->route('login');
            }

            $this->makePagSeguroSession();

            $cartItems = array_map(function ($line) {
                return $line['amount'] * $line['price'];
            }, session()->get('cart'));

            $cartItems = array_sum($cartItems);

            return view('checkout', compact('cartItems'));

        } catch (\Exception $e) {
            session()->forget('pagseguro_session_code');
            redirect()->route('checkout.index');
        }
    }

    public function proccess(Request $request)
    {
        try {
            $cartItems = session()->get('cart');
            $stores = array_unique(array_column($cartItems, 'store_id'));
            $user = auth()->user();
            $dataPost = $request->all();
            $reference = Uuid::uuid4();

            $payment = $dataPost['paymentType'] == 'BOLETO'
                ? new Boleto($cartItems, $user, $reference, $dataPost['hash'])
                : new CreditCard($cartItems, $user, $dataPost, $reference);
            $result = $payment->doPayment();

            $userOrder = [
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cartItems),
                //'type' => $dataPost['paymentType'],
                //'link_boleto' => $result->getPaymentLink()
            ];

            $userOrder = $user->orders()->create($userOrder);
            $userOrder->stores()->sync($stores);
            $store = (new Store())->notifyStoreOwners($stores);

            session()->forget('cart');
            session()->forget('pagseguro_session_code');

            $dataJson = [
                'status' => true,
                'message' => 'Pedido criado com sucesso!!!',
                'order' => $reference
            ];

            if($dataPost['paymentType']) $dataJson['link_boleto'] = $result->getPaymentLink();

            return response()->json([
                'data' => $dataJson
            ], 200);

        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? simplexml_load_string($e->getMessage()) : 'Erro ao processar pedido';
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => $message
                ]
            ], 401);
        }
    }

    public function thanks()
    {
        return view('thanks');
    }

    public function notification()
    {
        try {
            $notification = new Notification();
            $notification = $notification->getTransaction();
            $reference = base64_decode($notification->getReference());
            $userOrder = UserOrder::whereReference($reference);
            $userOrder->update([
                'pagseguro_status' => $notification->getStatus()
            ]);

            if ($notification->getStatus() == 3)//Pago
            {
                //
            }

            return response()->json([], 204);
        } catch (\Exception $e) {
            $message = env['APP_DEBUG'] ? simplexml_load_string($e->getMessage()) : '';
            return response()->json([$message], 500);
        }
    }

    private function makePagSeguroSession()
    {
        if (!session()->has('pagseguro_session_code')) {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            session()->put('pagseguro_session_code', $sessionCode->getResult());
        }
    }
}
