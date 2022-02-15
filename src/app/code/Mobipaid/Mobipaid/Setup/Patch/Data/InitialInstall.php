<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mobipaid\Mobipaid\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
* Patch is mechanism, that allows to do atomic upgrade data changes
*/
class InitialInstall implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply()
    {
        
            /**
             * Prepare database for install
             */
            $this->moduleDataSetup->startSetup();

            $statuses = [
                'payment_pa' => 'Pre-Authorization of Payment',
                'invalid_credential' => 'Invalid Credential',
                'payment_accepted' => 'Payment Accepted',
            ];
            foreach ($statuses as $code => $info) {
                $status[] = [
                    'status' => $code,
                    'label' => $info
                ];
            }
            $this->moduleDataSetup->getConnection()
                ->insertArray($this->moduleDataSetup->getTable('sales_order_status'), ['status', 'label'], $status);

            $states = [
                'payment_pa' => 'new',
                'invalid_credential' => 'new',
                'payment_accepted' => 'processing',
            ];

            foreach ($states as $status => $stateValue) {
                $state[] = [
                    'status' => $status,
                    'state' => $stateValue,
                    'is_default' => 0,
                    'visible_on_front' => '1'
                ];
            }
            
            $this->moduleDataSetup->getConnection()
                ->insertArray(
                    $this->moduleDataSetup->getTable('sales_order_status_state'),
                    ['status', 'state', 'is_default', 'visible_on_front'],
                    $state
                );

            /**
             * Prepare database after install
             */
            $this->moduleDataSetup->endSetup();
        
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }
}
