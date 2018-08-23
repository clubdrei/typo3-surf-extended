<?php
namespace BIT\Typo3SurfExtended\Application;

use BIT\Typo3SurfExtended\Task\PreSymlinkReleaseWarmupScriptsTask;
use BIT\Typo3SurfExtended\Task\RsyncConfigurationTask;
use BIT\Typo3SurfExtended\Task\WarmupScriptsTask;
use TYPO3\Surf\Application\TYPO3\CMS;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Workflow;
use TYPO3\Surf\Task\SymlinkReleaseTask;
use TYPO3\Surf\Task\TYPO3\CMS\FlushCachesTask;
use TYPO3\Surf\Task\TYPO3\CMS\SymlinkDataTask;

/**
 * @author Christoph Bessei
 */
class Typo3CmsApplication extends CMS
{
    use ClearOpcacheTrait;

    public function registerTasks(Workflow $workflow, Deployment $deployment)
    {
        parent::registerTasks($workflow, $deployment);

        $workflow->beforeTask(SymlinkReleaseTask::class, [PreSymlinkReleaseWarmupScriptsTask::class], $this);

        // Add configuration task (Copy config from /config to sharedFolder/Configuration)
        $workflow->afterTask(SymlinkDataTask::class, [RsyncConfigurationTask::class], $this);

        $workflow->afterTask(FlushCachesTask::class, [WarmupScriptsTask::class], $this);

        $this->registerClearOpcacheTaskIfEnabled($workflow, $deployment);
    }
}
