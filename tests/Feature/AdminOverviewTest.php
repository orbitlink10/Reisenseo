<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminOverviewTest extends TestCase
{
    private $originalHost;

    protected function setUp(): void
    {
        parent::setUp();

        // These public-site filters replace the view response with a string.
        $this->withoutMiddleware([
            \App\Http\Middleware\HomeShortcodeMiddleware::class,
            \App\Http\Middleware\WidgetShortcodeMiddleware::class,
        ]);

        // Isolate these checks from the configured application database.
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        $this->originalHost = $_SERVER['HTTP_HOST'] ?? null;
        $_SERVER['HTTP_HOST'] = 'dashboard.test';

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_type');
            $table->integer('active_status');
            $table->timestamp('last_activity')->nullable();
            $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');
            $table->string('slug');
            $table->integer('status');
            $table->timestamps();
        });
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('type');
            $table->integer('category_id')->nullable();
            $table->decimal('cost');
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cat_type');
        });
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 12, 2);
            $table->integer('status');
            $table->string('payment_source');
        });
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('domain_name');
        });
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('option_key');
            $table->string('option_value');
        });

        DB::table('websites')->insert(['id' => 1, 'domain_name' => 'dashboard.test']);
        DB::table('options')->insert(['option_key' => '1_currency_sign', 'option_value' => 'KSh']);
        DB::table('users')->insert([
            'id' => 1, 'name' => 'Test Admin', 'user_type' => 'admin', 'active_status' => 1,
            'created_at' => now()->subDays(60), 'last_activity' => now(),
        ]);
        $this->actingAs(User::findOrFail(1));
    }

    protected function tearDown(): void
    {
        if ($this->originalHost === null) {
            unset($_SERVER['HTTP_HOST']);
        } else {
            $_SERVER['HTTP_HOST'] = $this->originalHost;
        }

        parent::tearDown();
    }

    public function test_dashboard_renders_empty_states_and_zero_revenue(): void
    {
        $this->get('/dashboard')
            ->assertOk()
            ->assertViewIs('admin.overview')
            ->assertViewHas('stats', fn ($stats) => (float) $stats['revenue'] === 0.0 && $stats['orders'] === 0)
            ->assertSee('No orders yet.')
            ->assertSee('No products yet.')
            ->assertSee('No accounts awaiting activation.')
            ->assertSee('KSh')
            ->assertSee('Admin Overview');
    }

    public function test_dashboard_uses_paid_order_revenue_and_recent_user_activity(): void
    {
        DB::table('payments')->insert([
            ['amount' => 1250.50, 'status' => 1, 'payment_source' => 'Order paid'],
            ['amount' => 250, 'status' => 1, 'payment_source' => 'Order paid'],
            ['amount' => 9999, 'status' => 0, 'payment_source' => 'Order paid'],
            ['amount' => 5000, 'status' => 1, 'payment_source' => 'Wallet TopUp'],
        ]);
        DB::table('users')->insert([
            ['id' => 2, 'name' => 'Recent Customer', 'user_type' => 'client', 'active_status' => 1, 'created_at' => now()->subDays(2), 'last_activity' => now()->subHours(12)],
            ['id' => 3, 'name' => 'Pending Customer', 'user_type' => 'client', 'active_status' => 0, 'created_at' => now()->subDays(40), 'last_activity' => now()->subHours(25)],
            ['id' => 4, 'name' => 'Never Active', 'user_type' => 'client', 'active_status' => 1, 'created_at' => now()->subDays(40), 'last_activity' => null],
        ]);
        DB::table('orders')->insert(['id' => 1, 'user_id' => 2, 'title' => 'Test order', 'slug' => 'test-order', 'status' => 0, 'created_at' => now()]);
        DB::table('posts')->insert(['id' => 1, 'title' => 'Test product', 'slug' => 'test-product', 'type' => 'product', 'cost' => 800, 'created_at' => now()]);

        $this->get('/dashboard')
            ->assertOk()
            ->assertViewHas('stats', fn ($stats) =>
                (float) $stats['revenue'] === 1500.50
                && $stats['activeUsers'] === 2
                && $stats['newUsers'] === 1
                && $stats['approvals'] === 1
                && $stats['pending'] === 1
                && $stats['products'] === 1
            )
            ->assertSee('1,500.50')
            ->assertSee('Recent Customer')
            ->assertSee('Pending Customer')
            ->assertSee('Test product')
            ->assertSee('Uncategorized')
            ->assertSee(route('products').'#add-product', false)
            ->assertSee(route('products').'#recent-products', false);
    }
}
