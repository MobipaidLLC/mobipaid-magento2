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
namespace Mobipaid\Mobipaid\Helper;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * The level of Logger
     * @var int
     */
    public $loggerType = Logger::INFO;

    /**
     * Logger file name
     * @var string
     */
    public $fileName = '/var/log/mobipaid_log.log';
}
