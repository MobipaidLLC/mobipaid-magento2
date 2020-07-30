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
namespace Mobipaid\Mobipaid\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Mobipaid\Mobipaid\Model\Method\Flexible as MobipaidAbstract;
use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\App\RequestInterface;

class PaymentConfigProvider implements ConfigProviderInterface
{
    private $paymentHelper;
    private $assetRepo;
    private $request;
    private $mobipaidAbstract;

    private $methodCodes = [
        'mobipaid_flexible'
    ];

    /**
     *
     * @param PaymentHelper    $paymentHelper
     * @param Repository       $assetRepo
     * @param RequestInterface $request
     * @param MobipaidAbstract $mobipaidAbstract
     */
    public function __construct(
        PaymentHelper $paymentHelper,
        Repository $assetRepo,
        RequestInterface $request,
        MobipaidAbstract $mobipaidAbstract
    ) {
        $this->paymentHelper = $paymentHelper;
        $this->assetRepo = $assetRepo;
        $this->request = $request;
        $this->mobipaidAbstract = $mobipaidAbstract;
    }

    /**
     * get configurations
     * @return array
     */
    public function getConfig()
    {
        $config = [];
        foreach ($this->methodCodes as $code) {
            $methodInstance = $this->paymentHelper->getMethodInstance($code);
            if ($methodInstance->isAvailable()) {
                $asset = $this->createAsset('Mobipaid_Mobipaid::images/' . $methodInstance->getLogo());
                $display = 'block';

                $config['payment']['mobipaid']['logos'][$code] = [
                    'url' => $asset->getUrl(),
                    'height' => '50px',
                    'display' => $display,
                    'description' => $this->mobipaidAbstract->getPaymentMethodDescription()
                ];
            }
        }

        return $config;
    }

    /**
     * create an asset
     * @param  string $fileId
     * @param  array  $params
     * @return object
     */
    public function createAsset($fileId, array $params = [])
    {
        $params = array_merge(['_secure' => $this->request->isSecure()], $params);
        return $this->assetRepo->createAsset($fileId, $params);
    }
}
