<?php 

namespace App;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use App\Model\Product;
use App\Model\Offer;
use App\Model\Promo\PromoEveryOverLimitFree;
use App\Model\Promo\PromoPriceOverLimit;
use App\Enum\ProductType;
use App\Service\PromoResolver;
use App\Service\SaleService;

class SalesTest extends TestCase
{
    private function createExampleOffer(): Offer
    {
        return new Offer(
            products: [
                new Product('Shima Blaze white', ProductType::GLOVES, 11),
                new Product('Shima Blaze fluo', ProductType::GLOVES, 12),
                new Product('Shima Blaze red', ProductType::GLOVES, 13),
                new Product('Seca TracTech black', ProductType::GLOVES, 14),
                new Product('Held Sparrow', ProductType::GLOVES, 15),
                new Product('Dainese Druid black', ProductType::GLOVES, 16),
            ],
            promos: [
                new PromoEveryOverLimitFree(5),
                new PromoPriceOverLimit(100, 10),
            ],
        );
    }

    private function createExampleSmallOffer(): Offer
    {
        return new Offer(
            products: [
                new Product('Shima Blaze white', ProductType::GLOVES, 80),
                new Product('Shoei NXR', ProductType::HELMET, 210),
            ],
            promos: [
                new PromoEveryOverLimitFree(5),
                new PromoPriceOverLimit(100, 10),
            ],
        );
    }

    //Big offer - PromoEveryOverLimitFree promo chosen
    public function testDiscountPrice(): void
    {
        $offer = $this->createExampleOffer();
        $saleService = new SaleService(
            new PromoResolver()
        );

        $checkoutPrice = $saleService->getCheckoutPrice($offer);

        $this->assertLessThan($saleService->getProductsPrice($offer), $checkoutPrice);
        $this->assertEquals($checkoutPrice, 66);
    }

    public function testPromoChoice(): void
    {
        $promoResolover = new PromoResolver();
        $promo = $promoResolover->pickPromo($this->createExampleOffer());

        $this->assertInstanceOf(PromoEveryOverLimitFree::class, $promo);
    }

    //Small offer - PromoPriceOverLimit promo choosen
    public function testDiscountPriceForSmallOffer(): void
    {
        $offer = $this->createExampleSmallOffer();
        $saleService = new SaleService(
            new PromoResolver()
        );

        $checkoutPrice = $saleService->getCheckoutPrice($offer);

        $this->assertLessThan($saleService->getProductsPrice($offer), $checkoutPrice);
        $this->assertEquals($checkoutPrice, 261);
    }

    public function testPromoChoiceForSmallOffer(): void
    {
        $promoResolover = new PromoResolver();
        $promo = $promoResolover->pickPromo($this->createExampleSmallOffer());

        $this->assertInstanceOf(PromoPriceOverLimit::class, $promo);
    }

    //Mini offer, no promos in the offer
    public function testNoPromos(): void
    {
        $miniOffer = (new Offer())
            ->addProduct(new Product('RST Tracktech EVO white', ProductType::BOOTS, 70))
        ;

        $promoResolver = new PromoResolver();
        $saleService = new SaleService($promoResolver);

        $checkoutPrice = $saleService->getCheckoutPrice($miniOffer);

        $this->assertEquals($saleService->getProductsPrice($miniOffer), $checkoutPrice);
        $this->assertEquals($checkoutPrice, 70);
        $this->assertNull($promoResolver->pickPromo($miniOffer));
    }

    //Both promos work, but 10% discount is cheaper
    public function testCheaperPromoPicker(): void
    {
        $expensiveOffer = $this->createExampleOffer()
            ->addProduct(new Product('Dainese Axial 2 Air', ProductType::BOOTS, 2770.4));

        $this->assertInstanceOf(PromoPriceOverLimit::class, (new PromoResolver())->pickPromo($expensiveOffer));
    }
}
