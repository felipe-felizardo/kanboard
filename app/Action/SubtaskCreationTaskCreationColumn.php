<?php

namespace Kanboard\Action;

use Kanboard\Model\TaskModel;
use Kanboard\Model\SubtaskModel;

/**
 * Create a subtask when a task is created in a certain column.
 *
 * @package Kanboard\Action
 * @author  Felipe Felizardo Gonçalves
 */
class SubtaskCreationTaskCreationColumn extends Base
{
    /**
     * Get automatic action description
     *
     * @access public
     * @return string
     */
    public function getDescription()
    {
        return t('Add a subtask when creating a task in a column');
    }

    /**
     * Get the list of compatible events
     *
     * @access public
     * @return array
     */
    public function getCompatibleEvents()
    {
        return array(
            TaskModel::EVENT_CREATE,
        );
    }

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @access public
     * @return array
     */
    public function getActionRequiredParameters()
    {
        return array(
            'column_id' => t('Column'),
            'subtask' => t('Subtask Title'),
        );
    }

    /**
     * Get the required parameter for the event
     *
     * @access public
     * @return string[]
     */
    public function getEventRequiredParameters()
    {
        return array(
            'task_id',
            'task' => array(
                'id',
                'column_id',
                'project_id',
                'creator_id',
            ),
        );
    }

    /**
     * Execute the action (append to the task description).
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function doAction(array $data)
    {
        $subtaskID = $this->subtaskModel->create(array(
            'title' => $this->getParam('subtask'),
            'user_id' => $data['task']['creator_id'],
            'task_id' => $data['task']['id'],
            'status' => SubtaskModel::STATUS_TODO,
        ));

        if ($subtaskID !== false) {
            return true;
        }

        return false;
    }

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredCondition(array $data)
    {
        return $data['task']['column_id'] == $this->getParam('column_id');
    }
}
