<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Hmh_CatalogPositionRules::rules';

    private PageFactory $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hmh_CatalogPositionRules::catalog_product_position');
        $resultPage->getConfig()->getTitle()->prepend(__('Catalog Position Rule'));

        return $resultPage;
    }
}
