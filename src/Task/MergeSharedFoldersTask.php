<?php
namespace BIT\Typo3SurfExtended\Task;

use Neos\Utility\Files;
use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Task\ShellTask;

/**
 * Merge shared folders/files on node with folders/files in VCS
 * This allows you to have default files (e.g. config) in VCS and a more specific version on the node
 * The version on the node must be stored inside the shared folder
 *
 * @author clubdrei.com Medienagentur GmbH
 */
class MergeSharedFoldersTask extends ShellTask
{
    /**
     * mergeSharedFolders
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
        if (!empty($options['mergeSharedFolders'])) {
            $sharedPath = $application->getSharedPath();
            $releasePath = $deployment->getApplicationReleasePath($node);

            foreach ($options['mergeSharedFolders'] ?? [] as $mergeFolder) {
                $sourcePath = Files::concatenatePaths([$sharedPath, $mergeFolder]) . '/';
                $targetPath = Files::concatenatePaths([$releasePath, $mergeFolder]) . '/';

                $options['command'] = 'rsync -a ' . $sourcePath . ' ' . $targetPath;

                parent::execute($node, $application, $deployment, $options);
            }
        }
    }
}
