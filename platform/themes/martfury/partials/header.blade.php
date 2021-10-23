<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts-->
        <link href="https://fonts.googleapis.com/css?family={{ urlencode(theme_option('primary_font', 'Work Sans')) }}:300,400,500,600,700&amp;amp;subset=latin-ext" rel="stylesheet" type="text/css">
        <!-- CSS Library-->

        <style>
            :root {
                --color-1st: {{ theme_option('primary_color', '#fcb800') }};
                --color-2nd: {{ theme_option('secondary_color', '#222222') }};
                --primary-font: '{{ theme_option('primary_font', 'Work Sans') }}', sans-serif;
                --button-text-color: {{ theme_option('button_text_color', '#000') }};
                --header-text-color: {{ theme_option('header_text_color', '#000') }};
                --header-button-background-color: {{ theme_option('header_button_background_color', '#000') }};
                --header-button-text-color: {{ theme_option('header_button_text_color', '#fff') }};
                --header-text-hover-color: {{ theme_option('header_text_hover_color', '#fff') }};
                --header-text-accent-color: {{ theme_option('header_text_accent_color', '#222222') }};
                --header-diliver-border-color: {{ hex_to_rgba(theme_option('header_text_color', '#000'), 0.15) }};
            }
        </style>

        {!! Theme::header() !!}
    </head>
    <body @if (Theme::get('pageId')) id="{{ Theme::get('pageId') }}" @endif @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif>
        {!! apply_filters(THEME_FRONT_BODY, null) !!}
        <div id="alert-container"></div>
        @php
            $categories = !is_plugin_active('ecommerce') ? [] : get_product_categories(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable', 'children', 'children.slugable', 'children.children', 'children.children.slugable', 'metadata'], [], true);
        @endphp

        {!! Theme::get('topHeader') !!}

        <header class="header header--1" data-sticky="{{ Theme::get('stickyHeader', 'true') }}">
            <div class="header__top">
                <div class="ps-container">
                    <div class="header__left">
                        <div class="menu--product-categories">
                            <div class="menu__toggle"><i class="icon-menu"></i><span> {{ __('Shop by Department') }}</span></div>
                            <div class="menu__content" style="display: none">
                                <ul class="menu--dropdown">
                                    {!! Theme::partial('product-categories-dropdown', compact('categories')) !!}
                                </ul>
                            </div>
                        </div><a class="ps-logo" href="{{ route('public.index') }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" height="40"></a>
                    </div>
                    @if (is_plugin_active('ecommerce'))
                        <div class="header__center">
                            <form class="ps-form--quick-search" action="{{ route('public.products') }}" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                                <div class="form-group--icon">
                                    <div class="product-cat-label">{{ __('All') }}</div>
                                    <select class="form-control product-category-select" name="categories[]">
                                        <option value="0">{{ __('All') }}</option>
                                        @foreach ($categories as $category)
                                            <option class="level-0" value="{{ $category->id }}" @if (in_array($category->id, request()->input('categories', []))) selected @endif>{{ $category->name }}</option>
                                            @foreach($category->children as $childCategory)
                                                <option class="level-1" value="{{ $childCategory->id }}" @if (in_array($childCategory->id, request()->input('categories', []))) selected @endif>&nbsp;&nbsp;&nbsp;{{ $childCategory->name }}</option>
                                                @foreach($childCategory->children as $item)
                                                    <option class="level-2" value="{{ $item->id }}" @if (in_array($item->id, request()->input('categories', []))) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $item->name }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <input class="form-control" name="q" type="text" placeholder="{{ __("I'm shopping for...") }}" id="input-search" autocomplete="off">
                                <div class="spinner-icon">
                                    <i class="fa fa-spin fa-spinner"></i>
                                </div>
                                <button type="submit">{{ __('Search') }}</button>
                                <div class="ps-panel--search-result"></div>
                            </form>
                        </div>
                        <div class="header__right">
                            <div class="header__actions">
                                <a class="header__extra btn-compare" href="{{ route('public.compare') }}"><i class="icon-chart-bars"></i><span><i>{{ Cart::instance('compare')->count() }}</i></span></a>
                                <a class="header__extra btn-wishlist" href="{{ route('public.wishlist') }}"><i class="icon-heart"></i><span><i>{{ !auth('customer')->check() ? Cart::instance('wishlist')->count() : auth('customer')->user()->wishlist()->count() }}</i></span></a>
                                @if (EcommerceHelper::isCartEnabled())
                                    <div class="ps-cart--mini">
                                        <a class="header__extra btn-shopping-cart" href="{{ route('public.cart') }}"><i class="icon-bag2"></i><span><i>{{ Cart::instance('cart')->count() }}</i></span></a>
                                        <div class="ps-cart--mobile">
                                            {!! Theme::partial('cart') !!}
                                        </div>
                                    </div>
                                @endif
                                <div class="ps-block--user-header">
                                    <div class="ps-block__left"><i class="icon-user"></i></div>
                                    <div class="ps-block__right">
                                        @if (auth('customer')->check())
                                            <a href="{{ route('customer.overview') }}" class="customer-name">{{ auth('customer')->user()->name }}</a>
                                            <a href="{{ route('customer.logout') }}">{{ __('Logout') }}</a>
                                        @else
                                            <a href="{{ route('customer.login') }}">{{ __('Login') }}</a><a href="{{ route('customer.register') }}">{{ __('Register') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <nav class="navigation">
                <div class="ps-container">
                    <div class="navigation__left">
                        <div class="menu--product-categories">
                            <div class="menu__toggle"><i class="icon-menu"></i><span> {{ __('Shop by Department') }}</span></div>
                            <div class="menu__content" style="display: none">
                                <ul class="menu--dropdown">
                                    {!! Theme::partial('product-categories-dropdown', compact('categories')) !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="navigation__right">
                        {!! Menu::renderMenuLocation('main-menu', [
                            'view'    => 'menu',
                            'options' => ['class' => 'menu'],
                        ]) !!}
                        @if (is_plugin_active('ecommerce'))
                            <ul class="navigation__extra">
                                @if (is_plugin_active('marketplace'))
                                    <li><a href="{{ !auth('customer')->check() ? route('customer.login') : (auth('customer')->user()->is_vendor ? route('marketplace.vendor.dashboard') : route('marketplace.vendor.become-vendor')) }}">{{ __('Sell On Martfury') }}</a></li>
                                @endif
                                <li><a href="{{ route('public.orders.tracking') }}">{{ __('Track your order') }}</a></li>
                                @php $currencies = get_all_currencies(); @endphp
                                @if (count($currencies) > 1)
                                    <li>
                                        <div class="ps-dropdown">
                                            <a href="{{ route('public.change-currency', get_application_currency()->title) }}"><span>{{ get_application_currency()->title }}</span></a>
                                            <ul class="ps-dropdown-menu">
                                                @foreach ($currencies as $currency)
                                                    @if ($currency->id !== get_application_currency_id())
                                                        <li><a href="{{ route('public.change-currency', $currency->title) }}"><span>{{ $currency->title }}</span></a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                                @if (is_plugin_active('language'))
                                    {!! Theme::partial('language-switcher') !!}
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </nav>
        </header>
        @if (Theme::get('headerMobile'))
            {!! Theme::get('headerMobile') !!}
        @else
            {!! Theme::partial('header-mobile') !!}
        @endif
        @if (is_plugin_active('ecommerce'))
            <div class="ps-panel--sidebar" id="cart-mobile" style="display: none">
                <div class="ps-panel__header">
                    <h3>{{ __('Shopping Cart') }}</h3>
                </div>
                <div class="navigation__content">
                    <div class="ps-cart--mobile">
                        {!! Theme::partial('cart') !!}
                    </div>
                </div>
            </div>
            <div class="ps-panel--sidebar" id="navigation-mobile" style="display: none">
                <div class="ps-panel__header">
                    <h3>{{ __('Categories') }}</h3>
                </div>
                <div class="ps-panel__content">
                    <ul class="menu--mobile">
                        {!! Theme::partial('product-categories-dropdown', compact('categories')) !!}
                    </ul>
                </div>
            </div>
        @endif
        <div class="navigation--list">
            <div class="navigation__content">
                <a class="navigation__item ps-toggle--sidebar" href="#menu-mobile"><i class="icon-menu"></i><span> {{ __('Menu') }}</span></a>
                <a class="navigation__item ps-toggle--sidebar" href="#navigation-mobile"><i class="icon-list4"></i><span> {{ __('Categories') }}</span></a>
                <a class="navigation__item ps-toggle--sidebar" href="#search-sidebar"><i class="icon-magnifier"></i><span> {{ __('Search') }}</span></a>
                <a class="navigation__item ps-toggle--sidebar" href="#cart-mobile"><i class="icon-bag2"></i><span> {{ __('Cart') }}</span></a></div>
        </div>
        @if (is_plugin_active('ecommerce'))
            <div class="ps-panel--sidebar" id="search-sidebar" style="display: none">
                <div class="ps-panel__header">
                    <form class="ps-form--search-mobile" action="{{ route('public.products') }}" method="get">
                        <div class="form-group--nest">
                            <input class="form-control" name="q" value="{{ request()->query('q') }}" type="text" placeholder="{{ __('Search something...') }}">
                            <button type="submit"><i class="icon-magnifier"></i></button>
                        </div>
                    </form>
                </div>
                <div class="navigation__content"></div>
            </div>
        @endif
        <div class="ps-panel--sidebar" id="menu-mobile" style="display: none">
            <div class="ps-panel__header">
                <h3>{{ __('Menu') }}</h3>
            </div>
            <div class="ps-panel__content">
                {!! Menu::renderMenuLocation('main-menu', [
                    'view'    => 'menu',
                    'options' => ['class' => 'menu--mobile'],
                ]) !!}
            </div>
        </div>
