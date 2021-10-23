<?php

namespace Botble\Marketplace\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Models\Customer;

class VerifyVendorForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Customer)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                    'disabled'     => true,
                ],
            ])
            ->add('email', 'text', [
                'label'      => trans('plugins/marketplace::unverified-vendor.forms.email'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'data-counter' => 120,
                    'disabled'     => true,
                ],
            ])
            ->add('store_name', 'text', [
                'label'      => trans('plugins/marketplace::unverified-vendor.forms.store_name'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'disabled'     => true,
                ],
                'value' => $this->getModel()->store->name
            ])
            ->add('store_phone', 'text', [
                'label'      => trans('plugins/marketplace::unverified-vendor.forms.store_phone'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'disabled'     => true,
                ],
                'value' => $this->getModel()->store->phone
            ])
            ->add('avatar', 'html', [
                'label'      => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
                'html' => '<div class="form-group mb-3"><img src="' . $this->getModel()->avatar_url . '" alt="avatar" /></div>',
            ])
            ->setActionButtons(view('core/base::forms.partials.form-actions', [
                'only_save' => true,
                'saveTitle' => trans('plugins/marketplace::unverified-vendor.forms.verify_vendor'),
                'saveIcon'  => 'fas fa-certificate'])
                ->render()
            )
            ->addMetaBoxes([
                'approve-vendor' => [
                    'title'    => null,
                    'content'  => view('plugins/marketplace::partials.verify-vendor-modal', ['vendor' => $this->model])->render(),
                    'wrap'     => false,
                    'priority' => 9999,
                ],
            ])
            ->setBreakFieldPoint('avatar');
    }
}
