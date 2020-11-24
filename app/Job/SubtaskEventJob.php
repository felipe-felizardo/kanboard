<?php

namespace Kanboard\Job;

use Kanboard\EventBuilder\SubtaskEventBuilder;

/**
 * Class SubtaskEventJob
 *
 * @package Kanboard\Job
 * @author  Frederic Guillot
 */
class SubtaskEventJob extends BaseJob
{
    /**
     * Set job params
     *
     * @param  int   $subtaskId
     * @param  array $eventNames
     * @param  array $values
     * @param  array $subtask
     * @return $this
     */
    public function withParams($subtaskId, array $eventNames, array $values = array(), array $subtask = array())
    {
        $this->jobParams = array($subtaskId, $eventNames, $values, $subtask);
        return $this;
    }

    /**
     * Execute job
     *
     * @param  int   $subtaskId
     * @param  array $eventNames
     * @param  array $values
     * @param  array $subtask
     */
    public function execute($subtaskId, array $eventNames, array $values = array(), array $subtask = array())
    {
        $event = SubtaskEventBuilder::getInstance($this->container)
            ->withSubtaskId($subtaskId)
            ->withValues($values)
            ->withSubtask($subtask)
            ->buildEvent();

        if ($event !== null) {
            foreach ($eventNames as $eventName) {
                $this->dispatcher->dispatch($eventName, $event);
            }
        }
    }
}
