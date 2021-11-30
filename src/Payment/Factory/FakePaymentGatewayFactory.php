<?php

namespace App\Payment\Factory;

use App\Payment\Action\CaptureAction;
use App\Payment\Action\RedirectAction;
use App\Payment\Action\StatusAction;
use App\Payment\Config\FakeConfig;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class FakePaymentGatewayFactory extends GatewayFactory
{
    public function __construct(
        private CaptureAction $captureAction,
        private StatusAction $statusAction
    )
    {
        parent::__construct([]);
    }

    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name' => 'app_fake_payment',
            'payum.factory_title' => 'Fake Payment',
            'payum.action.status' => $this->statusAction,
            'payum.action.capture' => $this->captureAction,
            'payum.action.redirect' => new RedirectAction(),
        ]);

        $config['payum.api'] = function (ArrayObject $config) {
            return new FakeConfig($config['api_key']);
        };
    }
}
