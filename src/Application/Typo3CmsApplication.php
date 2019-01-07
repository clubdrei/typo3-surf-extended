<?php

namespace BIT\Typo3SurfExtended\Application;

use BIT\Typo3SurfExtended\Task\CompileExtTemplateAssetsTask;
use BIT\Typo3SurfExtended\Task\RsyncConfigurationTask;
use BIT\Typo3SurfExtended\Task\TYPO3\CMS\FixFolderStructureTask;
use BIT\Typo3SurfExtended\Task\WarmupScriptsTask;
use TYPO3\Surf\Application\TYPO3\CMS;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Workflow;
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

        // Compile assets before transfer
        $workflow->afterStage('package', CompileExtTemplateAssetsTask::class, $this);

        // Add configuration task (Copy config from /config to sharedFolder/Configuration)
        $workflow->afterTask(SymlinkDataTask::class, RsyncConfigurationTask::class, $this);

        // Fix TYPO3 folder structure (e.g. empty typo3temp)
        $workflow->afterTask(FlushCachesTask::class, FixFolderStructureTask::class, $this);

        // Execute warm up scripts after switch
        $workflow->afterStage('switch', WarmupScriptsTask::class, $this);

        // Clear opcache after switch
        $this->registerClearOpcacheTaskIfEnabled($workflow, $deployment);
    }
}