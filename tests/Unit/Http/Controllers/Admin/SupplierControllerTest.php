<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\SupplierController;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Illuminate\View\View;
use Mockery;
use Exception;
use Tests\TestCase;

class SupplierControllerTest extends TestCase
{
    private $supplierRepo;
    private $supplierController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->supplierRepo = Mockery::mock(SupplierRepositoryInterface::class)->makePartial();
        $this->supplierController = new SupplierController($this->supplierRepo);
    }

    protected function tearDown(): void
    {
        unset($this->supplierController);
        Mockery::close();
        parent::tearDown();
    }

    public function test_index()
    {
        // factory ra một list suppliers
        $suppliers = factory(User::class, 5)->make();

        // hàm getAll sẽ lấy hết các supplier trong CSDL ra
        // mock hàm getAll trả về list supplier
        $this->supplierRepo->shouldReceive('getAll')->andReturn($suppliers);

        // chạy hàm index trong SupplierController
        $response = $this->supplierController->index();

        // kiểm tra response có trả về một view không
        $this->assertInstanceOf(View::class, $response);
        // kiểm tra response có chứa list supplier vừa được truy vấn ra không
        $this->assertEquals($suppliers, $response->getData()['suppliers']);
    }

    public function test_supplier_register()
    {
        // factory ra một list các supplier
        $registedSuppliers = factory(User::class, 5)->make();

        // hàm getRegistedSupplier sẽ lấy hết các supplier đã đăng kí thành công ra
        // mock hàm getRegistedSupplier trả về list các supplier
        $this->supplierRepo->shouldReceive('getRegistedSupplier')->andReturn($registedSuppliers);

        // chạy hàm supplierRegister trong SupplierController
        $response = $this->supplierController->supplierRegister();

        // kiểm tra response có trả về một view không
        $this->assertInstanceOf(View::class, $response);
        // kiểm tra response có chứa list supplier vừa được truy vấn ra không
        $this->assertEquals($registedSuppliers, $response->getData()['suppliers']);
    }

    public function test_supplier_block()
    {
        // factory ra một list các supplier
        $blockedSuppliers = factory(User::class, 5)->make();

        // hàm getBlockedSupplier sẽ lấy hết các supplier đã bị khóa tài khoản ra
        // mock hàm getBlockedSupplier trả về list các supplier
        $this->supplierRepo->shouldReceive('getBlockedSupplier')->andReturn($blockedSuppliers);

        // chạy hàm supplierBlock trong SupplierController
        $response = $this->supplierController->supplierBlock();

        // kiểm tra response có trả về một view không
        $this->assertInstanceOf(View::class, $response);
        // kiểm tra response có chứa list supplier vừa được truy vấn ra không
        $this->assertEquals($blockedSuppliers, $response->getData()['suppliers']);
    }

    public function test_show()
    {
        // tạo 1 supplierId và factory 1 supplier
        $supplierId = 1;
        $supplier = factory(User::class)->make();

        // mock hàm find tìm kiếm một supplier và trả về supplier đã factory ở trên
        $this->supplierRepo->shouldReceive('find')->with($supplierId)->andReturn($supplier);

        // factory danh sách các sản phẩm của một supplier
        $supplierPostedProducts = factory(Product::class, 2)->make([
            'category_id' => 1,
            'user_id' => $supplierId,
        ]);

        // hàm getProducts thực hiện lấy danh sách sản phẩm của một supplier
        // mock hàm getProducts trả về danh sách sản phẩm vừa mock ở trên
        $this->supplierRepo->shouldReceive('getProducts')->with($supplier)->andReturn($supplierPostedProducts);

        // chạy hàm show của SupplierController
        $response = $this->supplierController->show($supplierId);

        // kiểm tra response có trả về một view không
        $this->assertInstanceOf(View::class, $response);
        // kiểm tra response có chứa supplier đã truy vấn ở trên không
        $this->assertEquals($supplier, $response->getData()['supplier']);
        // kiểm tra response có chứa danh sách các sản phẩm của supplier không
        $this->assertEquals($supplierPostedProducts, $response->getData()['postProducts']);
    }

    // test branch update trạng thái cho supplier thành công
    public function test_change_status_supplier_success()
    {
        // khởi tạo 2 biến id của supplier và id trạng thái
        $supplierId = 1;
        $statusId = 2;

        // mock hàm updateStatus thực hiện thành công
        $this->supplierRepo->shouldReceive('updateStatus')->with($supplierId, $statusId)->andReturn(true);

        // chạy hàm changeStatusSupplier trong SupplierController
        $response = $this->supplierController->changeStatusSupplier($supplierId, $statusId);

        // kiểm tra response trả về có trả về biến result với giá trị success không
        $this->assertEquals('success', $response->getSession()->get('result'));
    }

    // test branch update trạng thái cho supplier thất bại
    public function test_change_status_supplier_fail()
    {
        // khởi tạo 2 biến id của supplier và id trạng thái
        $supplierId = 1;
        $statusId = 2;

        // mock hàm updateStatus thực hiện thất bại và trả về một Exception
        $this->supplierRepo->shouldReceive('updateStatus')->with($supplierId)->andThrow(new Exception());

        // chạy hàm changeStatusSupplier trong SupplierController
        $response = $this->supplierController->changeStatusSupplier($supplierId, $statusId);

        // kiểm tra response trả về có trả về biến result với giá trị fail không
        $this->assertEquals('fail', $response->getSession()->get('result'));
    }
}
