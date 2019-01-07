<?php
declare(strict_types=1);

namespace BIT\Typo3SurfExtended\Task;

use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Task\LocalShellTask;

/**
 * Compile assets (npm install && grunt dist) of EXT:template (site package)
 *
 * You can overwrite the working directory with option <strong>assetDir</strong>.
 * The default working directory is EXT:template/Resources/Public/Assets/Src/
 */
class CompileExtTemplateAssetsTask extends LocalShellTask
{
    protected const ASSETS_DIR = '{workspacePath}/public/typo3conf/ext/template/Resources/Public/Assets/Src/';

    /**
     * Executes this action
     *
     * @param \TYPO3\Surf\Domain\Model\Node $node
     * @param \TYPO3\Surf\Domain\Model\Application $application
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @param array $options
     * @throws \TYPO3\Surf\Exception\InvalidConfigurationException
     */
    public function execute(Node $node, Application $application, Deployment $deployment, array $options = [])
    {
        $assetDir = static::ASSETS_DIR;
        if (!empty($options['assetDir'])) {
            $assetDir = $options['assetDir'];
        }
        if (!isset($options['command'])) {
            $options['command'] = [
                'cd '.$assetDir.' && npm install',
                'cd '.$assetDir.' && grunt dist',
            ];
        }

        parent::execute($node, $application, $deployment, $options);
    }
}