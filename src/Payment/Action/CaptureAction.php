<?php

namespace App\Payment\Action;

use App\Payment\Config\FakeConfig;
use Http\Client\Exception\RequestException;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Model\Identity;
use Payum\Core\Request\Capture;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Repository\PaymentRepositoryInterface;

class CaptureAction implements ActionInterface, ApiAwareInterface
{
    private FakeConfig $api;

    public function __construct(private PaymentRepositoryInterface $paymentRepository)
    {
    }

    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        if ($request->getModel() instanceof Identity) {
            $payment = $this->paymentRepository->find($request->getModel()->getId());
        } else {

            /** @var PaymentInterface $payment */
            $payment = $request->getModel();
        }


        try {
            // TODO do a request to the API
//            $response = $this->client->request('POST', 'https://sylius-payment.free.beeceptor.com', [
//                'body' => json_encode([
//                    'price' => $payment->getAmount(),
//                    'currency' => $payment->getCurrencyCode(),
//                    'api_key' => $this->api->getApiKey(),
//                ]),
//            ]);
        } catch (RequestException $exception) {
            //$response = $exception->getResponse();
            $payment->setDetails(['status' => 400]);
        } finally {
            //$payment->setDetails(['status' => $response->getStatusCode()]);
            $payment->setDetails(['status' => 200]);
        }
    }

    public function supports($request): bool
    {
        return
            $request instanceof Capture &&
            ($request->getModel() instanceof PaymentInterface || $request->getModel() instanceof Identity)
            ;
    }

    public function setApi($api): void
    {
        if (!$api instanceof FakeConfig) {
            throw new UnsupportedApiException('Not supported. Expected an instance of ' . FakeConfig::class);
        }

        $this->api = $api;
    }
}
