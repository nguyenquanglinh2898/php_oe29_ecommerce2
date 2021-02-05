<?php

namespace Tests\Unit\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    private $loginController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loginController = new LoginController();
    }

    protected function tearDown(): void
    {
        unset($this->loginController);
        parent::tearDown();
    }

    // test authenticated với tài khoản admin
    public function test_authenticated_with_admin_account()
    {
        $admin = factory(User::class)->make([
            'role_id' => config('setting.admin_id'),
        ]);

        // authenticate với tài khoản admin
        $response = $this->loginController->authenticated(new Request(), $admin);

        // kiểm tra xem response trả về có phải một RedirectResponse không
        $this->assertInstanceOf(RedirectResponse::class, $response);
        // kiểm tra route được redirect đến có đúng không
        $this->assertEquals(route('admin.products.index'), $response->headers->get('location'));
    }

    // test authenticated với tài khoản supplier
    public function test_authenticated_with_supplier_account()
    {
        $supplier = factory(User::class)->make([
            'role_id' => config('setting.supplier_id'),
        ]);

        // authenticate với tài khoản supplier
        $response = $this->loginController->authenticated(new Request(), $supplier);

        // kiểm tra xem response trả về có phải một RedirectResponse không
        $this->assertInstanceOf(RedirectResponse::class, $response);
        // kiểm tra route được redirect đến có đúng không
        $this->assertEquals(route('supplier.products.index'), $response->headers->get('location'));
    }

    // test authenticated với tài khoản customer
    public function test_authenticated_with_customer_account()
    {
        $customer = factory(User::class)->make([
            'role_id' => config('setting.customer_id'),
        ]);

        // authenticate với tài khoản customer
        $response = $this->loginController->authenticated(new Request(), $customer);

        // kiểm tra xem response trả về có phải một RedirectResponse không
        $this->assertInstanceOf(RedirectResponse::class, $response);
        // kiểm tra route được redirect đến có đúng không
        $this->assertEquals(route('home.index'), $response->headers->get('location'));
    }
}
