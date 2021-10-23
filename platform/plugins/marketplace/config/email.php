<?php

return [
    'name'        => 'Marketplace',
    'description' => 'Config email templates for Marketplace',
    'templates'   => [
        'store_new_order' => [
            'title'       => 'plugins/marketplace::marketplace.email.store_new_order_title',
            'description' => 'plugins/marketplace::marketplace.email.store_new_order_description',
            'subject'     => 'New order(s) at {{ site_title }}',
            'can_off'     => true,
            'enabled'     => true,
        ],
        'verify_vendor'   => [
            'title'       => 'plugins/marketplace::marketplace.email.verify_vendor_title',
            'description' => 'plugins/marketplace::marketplace.email.verify_vendor_description',
            'subject'     => 'New vendor at {{ site_title }} needs to be verified',
            'can_off'     => true,
            'enabled'     => true,
        ],
        'vendor-account-approved'   => [
            'title'       => 'plugins/marketplace::marketplace.email.vendor_account_approved_title',
            'description' => 'plugins/marketplace::marketplace.email.vendor_account_approved_description',
            'subject'     => 'Your account has been approved for selling at {{ site_title }}',
            'can_off'     => true,
            'enabled'     => true,
        ],
        'pending-product-approval'   => [
            'title'       => 'plugins/marketplace::marketplace.email.pending_product_approval_title',
            'description' => 'plugins/marketplace::marketplace.email.pending_product_approval_description',
            'subject'     => 'New product by {{ store_name }} needs to be approved',
            'can_off'     => true,
            'enabled'     => true,
        ],
        'product-approved'   => [
            'title'       => 'plugins/marketplace::marketplace.email.product_approved_title',
            'description' => 'plugins/marketplace::marketplace.email.product_approved_description',
            'subject'     => 'Your product has been approved for selling at {{ site_title }}',
            'can_off'     => true,
            'enabled'     => true,
        ],
    ],
    'variables'   => [
        'product_list'     => 'plugins/ecommerce::ecommerce.product_list',
        'payment_detail'   => 'plugins/ecommerce::ecommerce.payment_detail',
        'shipping_method'  => 'plugins/ecommerce::ecommerce.shipping_method',
        'payment_method'   => 'plugins/ecommerce::ecommerce.payment_method',
        'customer_name'    => 'plugins/ecommerce::ecommerce.customer_name',
        'customer_email'   => 'plugins/ecommerce::ecommerce.customer_email',
        'customer_phone'   => 'plugins/ecommerce::ecommerce.customer_phone',
        'customer_address' => 'plugins/ecommerce::ecommerce.customer_address',
        'store_name'       => 'plugins/marketplace::marketplace.email.store_name',
        'store_phone'      => 'plugins/marketplace::marketplace.store_phone',
        'store_link'       => 'plugins/marketplace::marketplace.store_link',
        'product_name'     => 'plugins/marketplace::marketplace.product_name',
        'product_url'      => 'plugins/marketplace::marketplace.product_url',
    ],
];
