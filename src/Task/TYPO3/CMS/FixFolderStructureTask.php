<?php
declare(strict_types=1);

namespace BIT\Typo3SurfExtended\Task\TYPO3\CMS;

use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Task\ShellTask;

class FixFolderStructureTask extends ShellTask
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
    public function execute(Node $node, Application $application, Deployment $deployment, array $options = []): void
    {
        $options['command'] = 'cd {releasePath}/ && ./vendor/bin/typo3cms install:fixfolderstructure';
        parent::execute($node, $application, $deployment, $options);
    }
}
