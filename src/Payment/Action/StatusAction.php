<?php

namespace App\Payment\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Model\Identity;
use Payum\Core\Request\GetStatusInterface;
use Sylius\Bundle\PayumBundle\Request\GetStatus;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Repository\PaymentRepositoryInterface;

class StatusAction implements ActionInterface
{
    public function __construct(private PaymentRepositoryInterface $paymentRepository)
    {
    }

    /**
     * @param GetStatus $request
     */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);
        dump('trace');

        if ($request->getModel() instanceof Identity) {
            $payment = $this->paymentRepository->find($request->getModel()->getId());
        } else {
            /** @var PaymentInterface $payment */
            $payment = $request->getModel();
        }
        $details = $payment->getDetails();
        $request->setModel($request->getModel());

        if (200 === $details['status']) {
            $request->markCaptured();

            return;
        }

        if (400 === $details['status']) {
            $request->markFailed();

            return;
        }
        die('ko');
    }

    public function supports($request): bool
    {
        return
            $request instanceof GetStatusInterface &&
            ($request->getFirstModel() instanceof PaymentInterface || $request->getModel() instanceof Identity)
            ;
    }
}
