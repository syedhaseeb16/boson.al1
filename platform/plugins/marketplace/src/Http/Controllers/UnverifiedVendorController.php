<?php

namespace Botble\Marketplace\Http\Controllers;

use Assets;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Repositories\Interfaces\CustomerInterface;
use Botble\Marketplace\Forms\VerifyVendorForm;
use Botble\Marketplace\Tables\UnverifiedVendorTable;
use EmailHandler;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use MarketplaceHelper;
use Throwable;

class UnverifiedVendorController extends BaseController
{
    /**
     * @var CustomerInterface
     */
    protected $customerRepository;

    /**
     * @param CustomerInterface $customerRepository
     */
    public function __construct(CustomerInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param UnverifiedVendorTable $table
     * @return Factory|View
     * @throws Throwable
     */
    public function index(UnverifiedVendorTable $table)
    {
        page_title()->setTitle(trans('plugins/marketplace::unverified-vendor.name'));

        return $table->renderTable();
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $vendor = $this->customerRepository->getFirstBy([
            'id'                 => $id,
            'is_vendor'          => true,
            'vendor_verified_at' => null,
        ]);

        if (!$vendor) {
            abort(404);
        }

        event(new BeforeEditContentEvent($request, $vendor));

        page_title()->setTitle(trans('plugins/marketplace::unverified-vendor.verify', ['name' => $vendor->name]));

        Assets::addScriptsDirectly(['vendor/core/plugins/marketplace/js/marketplace-vendor.js']);

        return $formBuilder
            ->create(VerifyVendorForm::class, ['model' => $vendor])
            ->remove('is_vendor')
            ->renderForm();
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, Request $request, BaseHttpResponse $response)
    {
        $vendor = $this->customerRepository
            ->getFirstBy([
                'id'                 => $id,
                'is_vendor'          => true,
                'vendor_verified_at' => null,
            ]);

        if (!$vendor) {
            abort(404);
        }

        $vendor->vendor_verified_at = now();
        $vendor->save();

        event(new UpdatedContentEvent(CUSTOMER_MODULE_SCREEN_NAME, $request, $vendor));

        if (MarketplaceHelper::getSetting('verify_vendor', 1)) {
            $store = auth('customer')->user()->store;

            EmailHandler::setModule(MARKETPLACE_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'store_name' => $store->name,
                ])
                ->sendUsingTemplate('vendor-account-approved', $store->email);
        }

        return $response
            ->setPreviousUrl(route('marketplace.unverified-vendors.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }
}
