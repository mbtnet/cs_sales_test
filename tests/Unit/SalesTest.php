<?php 

namespace App;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use App\Model\Product;
use App\Model\Promo\PromoEveryOverLimitFree;
use App\Model\Promo\PromoPriceOverLimit;
use App\Enum\ProductType;
use App\Service\PromoResolver;
use App\Service\SaleService;

class SalesTest extends TestCase
{
    public function testTwoPromos(): void
    {
        $offer = new Offer(
            products: [
                new Product('Shima Blaze white', ProductType::GLOVE, 120),
                new Product('Shima Blaze fluo', ProductType::GLOVE, 110),
            ],
            promos: [
                new PromoEveryOverLimitFree(),
                new PromoPriceOverLimit(100, 10),
            ],
        );

        $promoResolver = $this->createMock(PromoResolver::class);
        $saleService = new SaleService($promoResolver);

        $this->assertEquals($saleService->getProductsPrice(), $saleService->getCheckoutPrice($offer));
    }

    public function testPromosUnavailable(): void
    {
        //TODO prices too low
    }
}
