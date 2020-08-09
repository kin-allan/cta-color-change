<?php

namespace Nimbus\CTAColorChange\Console\Command;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputInterface,
    Input\InputArgument,
    Input\InputOption,
    Output\OutputInterface
};

use Magento\Framework\Console\Cli;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class ButtonColorChange extends Command {

    CONST BG_COLOR      = 'bg_color';
    CONST STORE_ID      = 'store_id';

    protected $state;
    protected $processorFacadeFactory;
    protected $storeRepository;
    protected $hexValidator;

    public function __construct(
        \Magento\Framework\App\State $state,
        \Magento\Config\Console\Command\ConfigSet\ProcessorFacadeFactory $processorFacadeFactory,
        \Magento\Store\Api\StoreRepositoryInterface $storeRepository,
        \Nimbus\CTAColorChange\Model\HexValidator $hexValidator
        )
    {
        $this->state                    = $state;
        $this->processorFacadeFactory   = $processorFacadeFactory;
        $this->storeRepository          = $storeRepository;
        $this->hexValidator             = $hexValidator;

        parent::__construct();
    }

    protected function configure()
    {
        $options = [
            new InputArgument(self::BG_COLOR, InputArgument::REQUIRED, 'Button Background Color'),
            new InputArgument(self::STORE_ID, InputArgument::REQUIRED, 'Store ID')
        ];

        $this->setName("nimbus:cta:change")
            ->setDescription("Change CTA background-color on product page")
            ->setDefinition($options);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);

        $output->writeln("<info>Changing CTA color...</info>");

        $storeId    = $input->getArgument(self::STORE_ID);
        $bgColor    = $input->getArgument(self::BG_COLOR);

        if ($storeId) {
            $store = false;
            try {
                $store = $this->storeRepository->getById($storeId);
            } catch (\NoSuchEntityException $e) {
                $store = false;
            }

            if ($store) {

                $processorFacade = $this->processorFacadeFactory->create();

                if ($bgColor) {
                    if ($this->hexValidator->validate($bgColor)) {
                        $processorFacade->process("nimbus_cta_color_change/general/bg_color", $bgColor, ScopeInterface::SCOPE_STORE, $store->getCode(), false);
                        $output->writeln("<info>CTA styles updated for store \"" . $store->getName() . "\". Please refresh cache.</info>");
                        return Cli::RETURN_SUCCESS;
                    } else {
                        $output->writeln("<error>Invalid hex color for \"bg_color\".</error>");
                        return Cli::RETURN_FAILURE;
                    }
                } else {
                    $output->writeln("<error>\"bg_color\" is required.</error>");
                    return Cli::RETURN_FAILURE;
                }
            } else {
                $output->writeln("<error>Store with id " . $storeId . " not found.</error>");
                return Cli::RETURN_FAILURE;
            }
        } else {
            $output->writeln("<error>\"store_id\" is required.</error>");
            return Cli::RETURN_FAILURE;
        }
    }
}
