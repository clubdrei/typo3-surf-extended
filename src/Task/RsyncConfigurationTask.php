<?php
/**
 * @author clubdrei.com Medienagentur GmbH
 */

namespace BIT\Typo3SurfExtended\Task;

use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Domain\Model\Task;
use TYPO3\Surf\Domain\Service\ShellCommandServiceAwareInterface;
use TYPO3\Surf\Domain\Service\ShellCommandServiceAwareTrait;

class RsyncConfigurationTask extends Task implements ShellCommandServiceAwareInterface
{
    use ShellCommandServiceAwareTrait;

    /**
     * Executes this task
     *
     * @param \TYPO3\Surf\Domain\Model\Node $node
     * @param \TYPO3\Surf\Domain\Model\Application $application
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @param array $options
     * @return void
     */
    public function execute(Node $node, Application $application, Deployment $deployment, array $options = [])
    {

        $sharedPath = $application->getSharedPath();
        $sharedConfigurationPath = escapeshellarg($sharedPath . '/Configuration/');

        $releasePath = $deployment->getApplicationReleasePath($application);
        $targetConfigurationPath = escapeshellarg($releasePath . '/config/');

        $rsyncWithoutOverwriteCommand = 'rsync -r --ignore-existing --include=*.php ';
        $commands = [
            'cd ' . $sharedConfigurationPath,
            $rsyncWithoutOverwriteCommand . ' ' . $sharedConfigurationPath . ' ' . $targetConfigurationPath,
        ];

        $this->shell->executeOrSimulate($commands, $node, $deployment);
    }

    /**
     * Simulate this task
     *
     * @param Node $node
     * @param Application $application
     * @param Deployment $deployment
     * @param array $options
     * @return void
     */
    public function simulate(Node $node, Application $application, Deployment $deployment, array $options = [])
    {
        $this->execute($node, $application, $deployment, $options);
    }
}
