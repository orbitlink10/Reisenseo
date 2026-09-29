<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    private $originalHost;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            \App\Http\Middleware\HomeShortcodeMiddleware::class,
            \App\Http\Middleware\WidgetShortcodeMiddleware::class,
        ]);
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        $this->originalHost = $_SERVER['HTTP_HOST'] ?? null;
        $_SERVER['HTTP_HOST'] = 'catalog.test';

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('user_type');
            $table->integer('site_id');
            $table->integer('page_id');
            $table->timestamps();
        });
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('type');
            $table->integer('category_id');
            $table->integer('sub_category')->nullable();
            $table->integer('site_id');
            $table->integer('writer_id');
            $table->integer('parent_page')->nullable();
            $table->string('ti_icon')->nullable();
            $table->decimal('cost', 12, 2);
            $table->string('meta_description')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        $migration = require database_path('migrations/2026_09_29_000000_add_product_inventory_fields_to_posts_table.php');
        $migration->up();

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cat_type');
        });
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cat_id');
        });
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('domain_name');
        });
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('option_key');
            $table->string('option_value');
        });
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->integer('message_read');
            $table->integer('message_to');
        });

        DB::table('users')->insert(['id' => 1, 'name' => 'Catalog Admin', 'email' => 'admin@example.test', 'user_type' => 'admin', 'site_id' => 1, 'page_id' => 1]);
        DB::table('websites')->insert(['id' => 1, 'domain_name' => 'catalog.test']);
        DB::table('pages')->insert(['id' => 1, 'name' => 'Shop']);
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Routers', 'cat_type' => 4],
            ['id' => 2, 'name' => 'Switches', 'cat_type' => 4],
            ['id' => 3, 'name' => 'Articles', 'cat_type' => 1],
        ]);
        DB::table('sub_categories')->insert([
            ['id' => 1, 'name' => 'Wireless routers', 'cat_id' => 1],
            ['id' => 2, 'name' => 'Managed switches', 'cat_id' => 2],
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

    private function product(array $overrides = []): array
    {
        return array_replace([
            'title' => 'Wireless router',
            'category_id' => 1,
            'sub_category' => 1,
            'site_id' => 1,
            'parent_page' => 1,
            'cost' => '4500.50',
            'marked_price' => '5000.00',
            'quantity' => 12,
            'meta_description' => 'A dual-band wireless router.',
            'description' => '<h2>Fast Wi-Fi</h2><p><strong>Dual band</strong> with <a href="https://example.test/specs">specifications</a>.</p><table><tbody><tr><td>Ports</td><td>5</td></tr></tbody></table>',
        ], $overrides);
    }

    public function test_product_form_renders_the_new_fields_and_category_options(): void
    {
        $this->get(route('products'))->assertOk()->assertViewIs('admin.products')
            ->assertSeeInOrder(['Product Name', 'Price (KES)', 'Marked Price (KES)', 'Quantity', 'Category', 'Subcategory', 'Meta Description', '>Description<'], false)
            ->assertSee('Wireless routers')->assertSee('Managed switches')
            ->assertSee('product-form.js')->assertSee('tinymce@8.9.2')
            ->assertDontSee('ClassicEditor');
    }

    public function test_product_creation_persists_inventory_seo_and_formatted_description(): void
    {
        $data = $this->product();
        $this->from(route('products'))->post(route('anew_product'), $data)
            ->assertRedirect(route('products'))->assertSessionHasNoErrors()
            ->assertSessionHas('success')->assertSessionMissing('_old_input');

        $post = Post::firstOrFail();
        $this->assertSame($data['description'], $post->description);
        $this->assertSame($data['meta_description'], $post->meta_description);
        $this->assertEquals(4500.50, $post->cost);
        $this->assertEquals(5000, $post->marked_price);
        $this->assertEquals(12, $post->quantity);
        $this->assertEquals(1, $post->sub_category);
        $this->assertSame('wireless-router', $post->slug);
    }

    public function test_optional_fields_can_be_blank_and_quantity_defaults_to_zero(): void
    {
        $this->post(route('anew_product'), $this->product([
            'marked_price' => '', 'quantity' => null, 'sub_category' => '', 'meta_description' => '',
        ]))->assertSessionHasNoErrors();

        $post = Post::firstOrFail();
        $this->assertNull($post->marked_price);
        $this->assertNull($post->sub_category);
        $this->assertNull($post->meta_description);
        $this->assertEquals(0, $post->quantity);
    }

    public function test_invalid_prices_stock_and_mismatched_subcategory_keep_the_entered_content(): void
    {
        $data = $this->product(['cost' => -1, 'marked_price' => -2, 'quantity' => 1.5, 'sub_category' => 2]);
        $this->from(route('products'))->post(route('anew_product'), $data)->assertRedirect(route('products'))
            ->assertSessionHasErrors(['cost', 'marked_price', 'quantity', 'sub_category'])
            ->assertSessionHasInput('description', $data['description']);
        $this->assertDatabaseCount('posts', 0);

        $this->get(route('products'))->assertOk()->assertSee('value="Wireless router"', false)
            ->assertSee('Fast Wi-Fi');
    }

    public function test_non_product_categories_and_negative_stock_are_rejected(): void
    {
        $this->post(route('anew_product'), $this->product(['category_id' => 3, 'sub_category' => null, 'quantity' => -1]))
            ->assertSessionHasErrors(['category_id', 'quantity']);
        $this->assertDatabaseCount('posts', 0);
    }
}
