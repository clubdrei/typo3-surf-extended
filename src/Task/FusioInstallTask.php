<?php
namespace BIT\Typo3SurfExtended\Task;

use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Task\ShellTask;

/**
 * @author clubdrei.com Medienagentur GmbH
 */
class FusioInstallTask extends ShellTask
{
    /**
     * Executes the fusio deploy script (bin/fusio deploy)
     *
     * Use the **fusioConfigFile** option to set the .fusio.yml path
     *
     *
     * @param \TYPO3\Surf\Domain\Model\Node $node
     * @param \TYPO3\Surf\Domain\Model\Application $application
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @param array $options
     * @return void
     * @throws \TYPO3\Surf\Exception\InvalidConfigurationException
     */
    public function execute(Node $node, Application $application, Deployment $deployment, array $options = []): void
    {
        if (empty($options['command'])) {
            // Make files in bin executable and start fusio deploy
            $options['command'] = 'cd {releasePath} && chmod +x bin/* && ./bin/fusio install -v';
        }

        parent::execute($node, $application, $deployment, $options);
    }
}
