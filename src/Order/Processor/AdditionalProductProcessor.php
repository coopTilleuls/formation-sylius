<?php

namespace App\Order\Processor;

use App\Entity\Order\OrderItem;
use App\Entity\Order\OrderItemUnit;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;

class AdditionalProductProcessor implements OrderProcessorInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ChannelContextInterface $channelContext,
        private LocaleContextInterface $localeContext,
        private TaxonRepositoryInterface $taxonRepository,
        private CartItemFactoryInterface $cartItemFactory,
    )
    {
    }

    public function process(OrderInterface $order): void
    {
        $tShirtCount = 0;

        /** @var OrderItem $orderItem */
        foreach ($order->getItems() as $orderItem) {
            $productTaxons = $orderItem->getProduct()->getProductTaxons();

            foreach ($productTaxons as $productTaxon) {
                if ($productTaxon->getTaxon()->getCode() === 't_shirts') {
                    $tShirtCount++;
                }
            }
        }

        if ($tShirtCount > 0) {
            /** @var ChannelInterface $channel */
            $channel = $this->channelContext->getChannel();
            $dressTaxon = $this->taxonRepository->findOneBy(['code' => 'dresses']);
            $products = $this
                ->productRepository
                ->createShopListQueryBuilder(
                    $channel,
                    $dressTaxon,
                    $this->localeContext->getLocaleCode(),
                )
                ->getQuery()
                ->getResult()
            ;
            $cartItem = $this->cartItemFactory->createForProduct($products[0]);
            $cartItem->addUnit(new OrderItemUnit($cartItem));
            $order->addItem($cartItem);

            // Do not call to avoid infinite loop !!!
            //$this->orderModifier->addToOrder($order, $cartItem);
        }
    }
}
