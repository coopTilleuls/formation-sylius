<?php

namespace App\Payment\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\GetStatusInterface;
use Sylius\Bundle\PayumBundle\Request\ResolveNextRoute;

class RedirectAction implements ActionInterface
{

    /**
     * @param ResolveNextRoute $request
     */
    public function execute($request)
    {
        $request->setRouteName('sylius_shop_order_thank_you');
    }

    public function supports($request)
    {
        return $request instanceof ResolveNextRoute;
    }
}
