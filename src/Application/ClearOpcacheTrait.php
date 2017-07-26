<?php
namespace BIT\Typo3SurfExtended\Application;

use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Workflow;
use TYPO3\Surf\Task\Php\WebOpcacheResetCreateScriptTask;
use TYPO3\Surf\Task\Php\WebOpcacheResetExecuteTask;

/**
 * @author Christoph Bessei
 */
trait ClearOpcacheTrait
{
    public function registerClearOpcacheTaskIfEnabled(Workflow $workflow, Deployment $deployment)
    {
        // Add clear opcache task
        if ($this->isClearOpcacheEnabled()) {
            $workflow->addTask(
                WebOpcacheResetCreateScriptTask::class,
                'package',
                $this
            );
            $workflow->addTask(
                WebOpcacheResetExecuteTask::class,
                'switch',
                $this
            );
        }
    }

    protected function isClearOpcacheEnabled(): bool
    {
        return $this->hasOption('clearOpcache') && $this->getOption('clearOpcache');
    }
}
