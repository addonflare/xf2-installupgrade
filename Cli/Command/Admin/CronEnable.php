<?php

namespace ThemeHouse\InstallAndUpgrade\Cli\Command\Admin;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CronEnable
 * @package ThemeHouse\InstallAndUpgrade\Cli\Command\Admin
 */
class CronEnable extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('iau:cron-enable')
            ->setAliases(['iau-admin:cron-enable', 'iau-cron:enable'])
            ->setDescription('Enable a cron task (or all).')
            ->addArgument(
                'id',
                InputArgument::OPTIONAL,
                'cron id'
            )
            ->addOption(
                'all',
                null,
                InputOption::VALUE_NONE,
                "Enable all cron tasks"
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // be verbose, otherwise we don't get stack trace errors...
        if ($output->getVerbosity() === OutputInterface::VERBOSITY_NORMAL) {
            $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        }

        $id = $input->getArgument('id');
        if (!$id) {
            $all = $input->getOption('all');
            if (!$all) {
                $output->writeln("<error>" . "No cron entry with ID '$id' could be found, or --all not used." . "</error>");

                return 1;
            }

            /** @var \XF\Entity\CronEntry $cron */
            $cronEntries = \XF::finder('XF:CronEntry')->fetch();
            foreach ($cronEntries as $cron) {
                $cron->active = 1;
                $cron->saveIfChanged();
            }
        } else {
            /** @var \XF\Entity\CronEntry $cron */
            $cron = \XF::app()->find('XF:CronEntry', $id);
            if (!$cron) {
                $output->writeln("<error>" . "No cron entry with ID '$id' could be found." . "</error>");

                return 1;
            }

            $cron->active = 1;
            $cron->saveIfChanged();
        }

        return 0;
    }
}