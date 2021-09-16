<?php
namespace BIT\Typo3SurfExtended\Application;

use BIT\Typo3SurfExtended\Task\FusioDeployTask;
use BIT\Typo3SurfExtended\Task\FusioInstallTask;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Workflow;

/**
 * TYPO3 Surf application for http://fusio-project.org/
 * @author Christoph Bessei
 */
class FusioApplication extends PhpApplication
{
    use ClearOpcacheTrait;

    /**
     * Extend BaseApplication with additional tasks:
     * * Fusio install (during initial deployment)
     * * Fusio deploy
     *
     * @param \TYPO3\Surf\Domain\Model\Workflow $workflow
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @return void
     */
    public function registerTasks(Workflow $workflow, Deployment $deployment): void
    {
        parent::registerTasks($workflow, $deployment);

        $workflow->addTask(FusioDeployTask::class, 'migrate', $this);

        // Install Fusio
        if ($deployment->hasOption('initialDeployment') && $deployment->getOption('initialDeployment')) {
            $workflow->beforeTask(FusioDeployTask::class, [FusioInstallTask::class], $this);
        }
    }
}
