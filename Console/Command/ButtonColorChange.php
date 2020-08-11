<?php

namespace Nimbus\CTAColorChange\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Config\Console\Command\ConfigSet\ProcessorFacadeFactory;
use Nimbus\CTAColorChange\Model\Config;
use Nimbus\CTAColorChange\Model\HexValidator;

class ButtonColorChange extends Command {

    /**
     * Console command param that holds the background color to set
     */
    CONST BG_COLOR      = 'bg_color';

    /**
     * Console command param that holds the store id
     */
    CONST STORE_ID      = 'store_id';

    /**
     * @var State
     */
    protected $state;

    /**
     * @var ProcessorFacadeFactory
     */
    protected $processorFacadeFactory;

    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * @var HexValidator
     */
    protected $hexValidator;

    /**
     * ButtonColorChange constructor.
     * @param State                    $state
     * @param ProcessorFacadeFactory   $processorFacadeFactory
     * @param StoreRepositoryInterface $storeRepository
     * @param HexValidator             $hexValidator
     */
    public function __construct(
        State $state,
        ProcessorFacadeFactory $processorFacadeFactory,
        StoreRepositoryInterface $storeRepository,
        HexValidator $hexValidator
    ) {
        $this->state                    = $state;
        $this->processorFacadeFactory   = $processorFacadeFactory;
        $this->storeRepository          = $storeRepository;
        $this->hexValidator             = $hexValidator;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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
                        $processorFacade->process(Config::XML_PATH_BGCOLOR, $bgColor, ScopeInterface::SCOPE_STORE, $store->getCode(), false);
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
