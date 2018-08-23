<?php
namespace BIT\Typo3SurfExtended\Task;

use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Task\ShellTask;

/**
 * Execute scripts for warmup
 *
 * @author Christoph Bessei
 */
class PreSymlinkReleaseWarmupScriptsTask extends ShellTask
{
    /**
     *
     * @param \TYPO3\Surf\Domain\Model\Node $node
     * @param \TYPO3\Surf\Domain\Model\Application $application
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @param array $options
     * @return void
     * @throws \TYPO3\Surf\Exception\InvalidConfigurationException
     */
    public function execute(Node $node, Application $application, Deployment $deployment, array $options = [])
    {
        foreach ($options['preSymlinkReleaseWarmupScripts'] ?? [] as $warmupScript) {
            $options['command'] = $warmupScript;
            parent::execute($node, $application, $deployment, $options);
        }
    }
}
