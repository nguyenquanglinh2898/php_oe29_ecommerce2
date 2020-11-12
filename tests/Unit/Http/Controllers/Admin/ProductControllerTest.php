<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\ProductController;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected $mockProductRepo;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockProductRepo = Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $this->controller = new ProductController($this->mockProductRepo);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        unset($this->controller);
        parent::tearDown();
    }

    public function test_index()
    {
        $this->mockProductRepo->shouldReceive('getAllProductOfSupplier');
        $view = $this->controller->index();
        $this->assertEquals('admin.product.index', $view->getName());
        $this->assertArrayHasKey('products', $view->getData());
    }

    public function test_show_if_exist_product()
    {
        $productId = 69;
        $this->mockProductRepo->shouldReceive('find')->with($productId)->andReturn(new Product());
        $view = $this->controller->show($productId);
        $this->assertEquals('admin.product.show', $view->getName());
        $this->assertArrayHasKey('product', $view->getData());
        $this->assertInstanceOf(Product::class, $view->getData()['product']);
    }

    public function test_show_if_not_exist_product()
    {
        $productId = 69;
        $response = new Response();
        $response->setStatusCode(404);
        $this->mockProductRepo->shouldReceive('find')->with($productId)->andReturn($response);

        $view = $this->controller->show($productId);
        $this->assertEquals('admin.product.show', $view->getName());
        $this->assertArrayHasKey('product', $view->getData());
        $this->assertInstanceOf(Response::class, $view->getData()['product']);
        $this->assertEquals($response->status(), $view->getData()['product']->status());
    }

    public function test_change_status_equal_true()
    {
        $productId = 69;
        $statusId = 96;
        $this->mockProductRepo->shouldReceive('updateStatus')
            ->with($productId, $statusId)->andReturn(true);

        $response = $this->controller->changeStatus($productId, $statusId);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.products.index'), $response->headers->get('Location'));

        $alertSuccess = json_decode($response->getSession()->get('alert.config'))->title;
        $this->assertEquals(trans('supplier.change_status_success'), $alertSuccess);
    }

    public function test_change_status_equal_false()
    {
        $productId = 69;
        $statusId = 96;
        $this->mockProductRepo->shouldReceive('updateStatus')
            ->with($productId, $statusId)->andReturn(false);

        $response = $this->controller->changeStatus($productId, $statusId);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.products.index'), $response->headers->get('Location'));

        $alertFalse = json_decode($response->getSession()->get('alert.config'))->title;
        $this->assertEquals(trans('supplier.change_status_fail'), $alertFalse);
    }
}
