<?php

namespace App\Payment\StateMachine;

use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use Sylius\Bundle\ApiBundle\Applicator\PaymentStateMachineTransitionApplicatorInterface;
use Sylius\Component\Payment\Model\PaymentInterface;
use Sylius\Component\Payment\PaymentTransitions;

class TransitionApplicator implements PaymentStateMachineTransitionApplicatorInterface
{
    public function __construct(
        private PaymentStateMachineTransitionApplicatorInterface $decorated,
        private StateMachineFactoryInterface $stateMachineFactory
    )
    {
    }

    public function complete(PaymentInterface $data): PaymentInterface
    {
        return $this->decorated->complete($data);
    }

    public function fail(PaymentInterface $data): PaymentInterface
    {
        $stateMachine = $this->stateMachineFactory->get($data, PaymentTransitions::GRAPH);
        $stateMachine->apply(PaymentTransitions::TRANSITION_FAIL);

        return $data;
    }
}
