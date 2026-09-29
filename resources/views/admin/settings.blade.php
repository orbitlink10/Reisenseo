@extends('dashboard.layouts.app')

@section('title', 'Settings')

@section('page-css')
<style>
    .rsd-hint { color: var(--muted); font-size: 13px; margin-bottom: 14px; }
    .rsd-check-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        max-height: 360px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .rsd-check {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid var(--line);
        border-radius: 10px;
        font-size: 13.5px;
        cursor: pointer;
        transition: background .15s ease, border-color .15s ease;
    }
    .rsd-check:hover { background: #f8fafc; border-color: #cbd5e1; }
    .rsd-check input { width: 16px; height: 16px; accent-color: var(--primary); flex: 0 0 auto; }
    @media (max-width: 640px) { .rsd-check-list { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
@include('dashboard.partials.flash')

@php
    $homeCategories = array_map('intval', site_option_array('home_categories'));
    $menuCategories = array_map('intval', site_option_array('menu_categories'));
    $homeShopCategories = array_map('intval', site_option_array('home_shop_categories'));
    $homeProductsEyebrow = site_option('home_products_eyebrow', 'Latest Products');
    $homeProductsTitle = site_option('home_products_title', 'Shop Now');
    $phone = site_option('phone', '+254 714 804 532');
    $email = site_option('contact_email', 'info@reisenseo.com');
    $address = site_option('contact_address', 'Nairobi, Kijabe Street, Norfolk Towers, Kenya');
@endphp

<header class="rsd-page-head">
    <div>
        <span class="rsd-eyebrow">Configuration</span>
        <h1>Settings</h1>
        <p>Control the categories shown on your homepage, the navigation menu and your contact details.</p>
    </div>
</header>

<form method="POST" action="{{ route('save_settings') }}">
    @csrf

    <div class="rsd-grid-2">
        <section class="rsd-panel">
            <div class="rsd-panel__head">
                <div>
                    <p class="rsd-eyebrow">Content</p>
                    <h2>Homepage Categories</h2>
                </div>
            </div>
            <div class="rsd-panel__body">
                <p class="rsd-hint">Select the categories to feature in the "Browse Categories" section of the homepage.</p>
                <div class="rsd-check-list">
                    <input type="hidden" name="{{ site_id() }}_home_categories[]" value="">
                    @forelse ($categories as $category)
                        <label class="rsd-check">
                            <input type="checkbox" name="{{ site_id() }}_home_categories[]" value="{{ $category->id }}" @checked(in_array($category->id, $homeCategories))>
                            <span>{{ $category->name }}</span>
                        </label>
                    @empty
                        <p class="muted">No categories found.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="rsd-panel">
            <div class="rsd-panel__head">
                <div>
                    <p class="rsd-eyebrow">Navigation</p>
                    <h2>Menu Categories</h2>
                </div>
            </div>
            <div class="rsd-panel__body">
                <p class="rsd-hint">Select the categories to show in the header navigation menu.</p>
                <div class="rsd-check-list">
                    <input type="hidden" name="{{ site_id() }}_menu_categories[]" value="">
                    @forelse ($categories as $category)
                        <label class="rsd-check">
                            <input type="checkbox" name="{{ site_id() }}_menu_categories[]" value="{{ $category->id }}" @checked(in_array($category->id, $menuCategories))>
                            <span>{{ $category->name }}</span>
                        </label>
                    @empty
                        <p class="muted">No categories found.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <section class="rsd-panel">
        <div class="rsd-panel__head">
            <div>
                <p class="rsd-eyebrow">Content</p>
                <h2>Latest Products (Shop Now)</h2>
            </div>
        </div>
        <div class="rsd-panel__body">
            <p class="rsd-hint">Choose the categories featured in the homepage "Shop Now" section. Each category appears as a tile and links to its product listing. Leave all unchecked to show 8 categories automatically.</p>
            <div class="rsd-form-grid">
                <div class="rsd-form-group">
                    <label>Small heading</label>
                    <input type="text" class="rsd-form-control" name="{{ site_id() }}_home_products_eyebrow" value="{{ $homeProductsEyebrow }}" placeholder="Latest Products">
                </div>
                <div class="rsd-form-group">
                    <label>Heading</label>
                    <input type="text" class="rsd-form-control" name="{{ site_id() }}_home_products_title" value="{{ $homeProductsTitle }}" placeholder="Shop Now">
                </div>
            </div>
            <div class="rsd-check-list" style="max-height: 420px; margin-top: 8px;">
                <input type="hidden" name="{{ site_id() }}_home_shop_categories[]" value="">
                @forelse ($categories as $category)
                    <label class="rsd-check">
                        <input type="checkbox" name="{{ site_id() }}_home_shop_categories[]" value="{{ $category->id }}" @checked(in_array($category->id, $homeShopCategories))>
                        <span>{{ $category->name }}</span>
                    </label>
                @empty
                    <p class="muted">No categories found.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="rsd-panel">
        <div class="rsd-panel__head">
            <div>
                <p class="rsd-eyebrow">Contact</p>
                <h2>Contact Details</h2>
            </div>
        </div>
        <div class="rsd-panel__body">
            <div class="rsd-form-grid">
                <div class="rsd-form-group">
                    <label>Phone number</label>
                    <input type="text" class="rsd-form-control" name="{{ site_id() }}_phone" value="{{ $phone }}" placeholder="+254 714 804 532">
                </div>
                <div class="rsd-form-group">
                    <label>Email address</label>
                    <input type="email" class="rsd-form-control" name="{{ site_id() }}_contact_email" value="{{ $email }}" placeholder="info@example.com">
                </div>
            </div>
            <div class="rsd-form-group">
                <label>Address</label>
                <input type="text" class="rsd-form-control" name="{{ site_id() }}_contact_address" value="{{ $address }}" placeholder="Nairobi, Kenya">
            </div>
        </div>
    </section>

    <div style="margin-bottom:40px;">
        <button type="submit" class="rsd-btn primary"><i class="fa fa-save"></i> Save Settings</button>
    </div>
</form>
@endsection
