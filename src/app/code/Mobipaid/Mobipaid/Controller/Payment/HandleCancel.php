<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 *
 * @package     Mobipaid
 * @copyright   Copyright (c) 2020 Mobipaid
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mobipaid\Mobipaid\Controller\Payment;

class HandleCancel extends \Mobipaid\Mobipaid\Controller\Payment\Index
{
    /**
     * execute payment handlecancel
     */
    public function execute()
    {
        $orderId = $this->getRequest()->getParam('orderId');
        $this->_order = $this->getOrderByIncerementId($orderId);
        
        $this->logger->info('process cancel url');

        $this->_order->cancel()->save();
        $this->redirectError('You already cancel the payment');
    }
}
