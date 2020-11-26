<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_login_view()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSeeLink(env('APP_NAME'))
                ->assertSeeLink(trans('sentences.login'))
                ->assertSeeLink(trans('sentences.register'))
                ->assertSeeIn('form', trans('sentences.email_address'))
                ->assertSeeIn('form', trans('passwords.password'))
                ->assertSeeIn('form', trans('sentences.remember_me'))
                ->assertSeeIn('form .login-btn', trans('sentences.login'))
                ->assertSeeIn('form', trans('passwords.forgot_your_password'));
        });
    }

    public function test_login_fail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'tathiminhhuyen@sun.com')
                ->type('password', '12345678')
                ->press('form .login-btn')
                ->assertPathIs('/login');
        });
    }

    public function test_login_for_customer()
    {
        $user = factory(User::class)->create([
            'role_id' => config('setting.customer_id'),
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', '12345678')
                ->press('form .login-btn')
                ->assertPathIs('/');
        });

        $user->forceDelete();
    }

    public function test_login_for_supplier()
    {
        $user = factory(User::class)->create([
            'role_id' => config('setting.supplier_id'),
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', '12345678')
                ->press('form .login-btn')
                ->assertPathIs('/supplier/products');
        });

        $user->forceDelete();
    }

    public function test_login_for_admin()
    {
        $user = factory(User::class)->create([
            'role_id' => config('setting.admin_id'),
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', '12345678')
                ->press('form .login-btn')
                ->assertPathIs('/admin/products');
        });

        $user->forceDelete();
    }

    public function test_register_link()
    {
        $this->browse(function ($browser){
            $browser->visit('/login')
                ->press('.register-btn')
                ->assertPathIs('/register');
        });
    }

    public function test_forgot_password_link()
    {
        $this->browse(function ($browser){
            $browser->visit('/login')
                ->press('.forgot-password-btn')
                ->assertPathIs('/password/reset');
        });
    }
}
