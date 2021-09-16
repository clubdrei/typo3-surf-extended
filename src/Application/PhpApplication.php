<?php
namespace BIT\Typo3SurfExtended\Application;

use BIT\Typo3SurfExtended\Task\MergeSharedFoldersTask;
use BIT\Typo3SurfExtended\Task\WarmupScriptsTask;
use TYPO3\Surf\Application\BaseApplication;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Workflow;

/**
 * @author Christoph Bessei
 */
class PhpApplication extends BaseApplication
{
    use ClearOpcacheTrait;

    /**
     * Extend BaseApplication with additional tasks:
     *
     * @param \TYPO3\Surf\Domain\Model\Workflow $workflow
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @return void
     */
    public function registerTasks(Workflow $workflow, Deployment $deployment): void
    {
        parent::registerTasks($workflow, $deployment);

        // Merge shared folders/files on node with folders/files in VCS
        $workflow->afterStage('update', [MergeSharedFoldersTask::class,], $this);

        // Execute warm up scripts after switch
        $workflow->afterStage('switch', WarmupScriptsTask::class, $this);

        $this->registerClearOpcacheTaskIfEnabled($workflow, $deployment);
    }
}
