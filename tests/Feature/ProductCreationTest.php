<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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
            $table->string('meta_title')->nullable();
            $table->string('keywords')->nullable();
            $table->string('demo_url')->nullable();
            $table->boolean('show_in_header_menu')->nullable();
            $table->boolean('show_in_footer_menu')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        $migration = require database_path('migrations/2026_09_29_000000_add_product_inventory_fields_to_posts_table.php');
        $migration->up();

        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id')->nullable();
            $table->integer('site_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('name');
            $table->string('file_path');
            $table->string('image_type');
            $table->string('status');
            $table->timestamps();
        });
        Storage::fake('public');

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cat_type');
            $table->string('slug')->nullable();
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
            ['id' => 1, 'name' => 'Routers', 'cat_type' => 4, 'slug' => 'routers'],
            ['id' => 2, 'name' => 'Switches', 'cat_type' => 4, 'slug' => 'switches'],
            ['id' => 3, 'name' => 'Articles', 'cat_type' => 1, 'slug' => 'articles'],
        ]);
        DB::table('options')->insert([
            ['option_key' => '1_theme', 'option_value' => 'marketi'],
            ['option_key' => '1_currency_sign', 'option_value' => 'KES'],
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
        $this->get(route('create_product'))->assertOk()->assertViewIs('admin.product_create')
            ->assertSeeInOrder(['Product Name', 'Main product image', 'Gallery images (optional)', 'Price (KES)', 'Marked Price (KES)', 'Quantity', 'Category', 'Meta Description', '>Description<'], false)
            ->assertSee('Routers')->assertSee('Switches')
            ->assertSee('enctype="multipart/form-data"', false)
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

        $this->get(route('create_product'))->assertOk()->assertSee('value="Wireless router"', false)
            ->assertSee('Fast Wi-Fi');
    }

    public function test_non_product_categories_and_negative_stock_are_rejected(): void
    {
        $this->post(route('anew_product'), $this->product(['category_id' => 3, 'sub_category' => null, 'quantity' => -1]))
            ->assertSessionHasErrors(['category_id', 'quantity']);
        $this->assertDatabaseCount('posts', 0);
    }

    public function test_main_image_and_gallery_are_saved_and_displayed_on_the_product_page(): void
    {
        $this->post(route('anew_product'), $this->product([
            'product_image' => UploadedFile::fake()->image('front.jpg'),
            'gallery_images' => [UploadedFile::fake()->image('back.png')],
        ]))->assertSessionHasNoErrors()->assertSessionHas('success');

        $post = Post::firstOrFail();
        $this->assertCount(2, $post->uploads);
        $this->assertSame('1', $post->uploads[0]->status);
        $this->assertSame('0', $post->uploads[1]->status);
        foreach ($post->uploads as $image) {
            Storage::disk('public')->assertExists(substr($image->file_path, strlen('/storage/')));
        }

        auth()->logout();
        $response = $this->get(route('shop_description', $post->slug));
        $response->assertOk()->assertSee('KES 4,500.50')->assertSee('KES 5,000.00')
            ->assertSee('Buy Now')->assertSee('In stock')->assertSee('Additional information')
            ->assertSee('data-gallery-thumbnail', false)->assertSee('data-gallery-dialog', false)
            ->assertSee('https://schema.org/InStock', false)
            ->assertSee('Fast Wi-Fi')->assertSee('product-details.js');
        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
        $response->assertSeeInOrder([$post->uploads[0]->file_path, $post->uploads[1]->file_path], false);
    }

    public function test_replacing_the_main_image_keeps_old_images_and_updates_catalog_thumbnail(): void
    {
        $this->post(route('anew_product'), $this->product(['product_image' => UploadedFile::fake()->image('old.jpg')]));
        $post = Post::firstOrFail();
        $original = $post->uploads->first();
        $editUrl = route('edit_product', $post->id);
        $this->from($editUrl)->post(route('updatesingle_product'), $this->product([
            'page_id' => $post->id,
            'product_image' => UploadedFile::fake()->image('new.jpg'),
            'gallery_images' => [UploadedFile::fake()->image('detail.png')],
        ]))->assertRedirect($editUrl)->assertSessionHasNoErrors()->assertSessionHas('success');

        $images = $post->fresh()->uploads;
        $this->assertCount(3, $images);
        $this->assertNotEquals($original->id, $images->first()->id);
        $this->assertSame('1', $images->first()->status);
        $this->assertSame('0', $original->fresh()->status);
        Storage::disk('public')->assertExists(substr($original->file_path, strlen('/storage/')));
        $this->get($editUrl)->assertOk()->assertSee('Current images')->assertSee($images->first()->file_path, false);
        $this->get(route('products'))->assertOk()->assertSee($images->first()->file_path, false);

        $this->post(route('updatesingle_product'), $this->product(['page_id' => $post->id]))
            ->assertSessionHas('success');
        $this->assertDatabaseCount('uploads', 3);
        $this->assertSame($images->first()->id, $post->fresh()->uploads->first()->id);
    }

    public function test_gallery_only_uploads_get_a_main_image_and_later_additions_keep_it(): void
    {
        $this->post(route('anew_product'), $this->product([
            'gallery_images' => [UploadedFile::fake()->image('first.jpg')],
        ]))->assertSessionHas('success');
        $post = Post::firstOrFail();
        $main = $post->uploads->first();
        $this->assertSame('1', $main->status);
        $this->post(route('updatesingle_product'), $this->product([
            'page_id' => $post->id,
            'gallery_images' => [UploadedFile::fake()->image('second.jpg')],
        ]))->assertSessionHas('success');
        $this->assertSame($main->id, $post->fresh()->uploads->first()->id);
    }

    public function test_invalid_or_oversize_images_do_not_create_a_product(): void
    {
        $this->post(route('anew_product'), $this->product([
            'product_image' => UploadedFile::fake()->create('document.pdf', 10, 'application/pdf'),
            'gallery_images' => [UploadedFile::fake()->image('large.jpg')->size(2049)],
        ]))->assertSessionHasErrors(['product_image', 'gallery_images.0']);
        $this->assertDatabaseCount('posts', 0);
        $this->assertDatabaseCount('uploads', 0);
        $this->assertEmpty(Storage::disk('public')->allFiles());
    }

    public function test_adding_to_a_legacy_gallery_keeps_its_existing_main_image(): void
    {
        $this->post(route('anew_product'), $this->product(['product_image' => UploadedFile::fake()->image('legacy.jpg')]));
        $post = Post::firstOrFail();
        $main = $post->uploads->first();
        $main->update(['status' => '0']);
        $this->post(route('updatesingle_product'), $this->product([
            'page_id' => $post->id,
            'gallery_images' => [UploadedFile::fake()->image('extra.jpg')],
        ]))->assertSessionHas('success');
        $this->assertSame($main->id, $post->fresh()->uploads->first()->id);
        $this->assertSame('1', $main->fresh()->status);
    }

    public function test_gallery_image_count_is_limited(): void
    {
        $images = [];
        for ($index = 0; $index < 9; $index++) {
            $images[] = UploadedFile::fake()->image('gallery-'.$index.'.jpg');
        }
        $this->post(route('anew_product'), $this->product(['gallery_images' => $images]))
            ->assertSessionHasErrors('gallery_images');
        $this->assertDatabaseCount('posts', 0);
        $this->assertEmpty(Storage::disk('public')->allFiles());
    }

    public function test_invalid_image_update_preserves_product_and_existing_images(): void
    {
        $this->post(route('anew_product'), $this->product(['product_image' => UploadedFile::fake()->image('front.jpg')]));
        $post = Post::firstOrFail();
        $this->post(route('updatesingle_product'), $this->product([
            'page_id' => $post->id, 'title' => 'Should not save',
            'product_image' => UploadedFile::fake()->create('script.php', 1, 'text/plain'),
        ]))->assertSessionHasErrors('product_image');
        $this->assertSame('Wireless router', $post->fresh()->title);
        $this->assertDatabaseCount('uploads', 1);
    }

    public function test_a_failed_image_save_rolls_back_the_product_and_cleans_up_files(): void
    {
        Upload::creating(function () { throw new \RuntimeException('Simulated storage record failure'); });
        try {
            $this->post(route('anew_product'), $this->product([
                'product_image' => UploadedFile::fake()->image('front.jpg'),
            ]))->assertSessionHas('error');
            $this->assertDatabaseCount('posts', 0);
            $this->assertDatabaseCount('uploads', 0);
            $this->assertEmpty(Storage::disk('public')->allFiles());
        } finally {
            Upload::flushEventListeners();
        }
    }

    public function test_public_page_handles_missing_images_and_out_of_stock_products(): void
    {
        $this->post(route('anew_product'), $this->product(['quantity' => 0, 'marked_price' => null]));
        $post = Post::firstOrFail();
        auth()->logout();
        $this->get(route('shop_description', $post->slug))->assertOk()
            ->assertSee('Product image coming soon')->assertSee('Out of stock')
            ->assertSee('https://schema.org/OutOfStock', false)->assertDontSee('Buy Now')
            ->assertDontSee('data-gallery-zoom', false);
        $this->get(route('shop_description', 'does-not-exist'))->assertNotFound();
    }
}
