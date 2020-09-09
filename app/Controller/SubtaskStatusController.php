<?php

namespace Kanboard\Controller;

/**
 * Subtask Status
 *
 * @package  Kanboard\Controller
 * @author   Frederic Guillot
 */
class SubtaskStatusController extends BaseController
{
    /**
     * Dialog to comment the ending of the status
     *
     * @access public
     */
    public function end()
    {
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);
        $status = $this->request->getStringParam('status');
        $values = array();
        $errors = array();

        $this->response->html($this->template->render('subtask/end', array(
            'values' => $values,
            'errors' => $errors,
            'status' => $status, 
            'task' => $task, 
            'project_id' => $task['project_id'], 
            'subtask_id' => $subtask['id'])));
    }

    /**
     * Confirmation dialog to begin subtask's development or test
     *
     * @access public
     */
    public function begin()
    {
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);
        $status = $this->request->getStringParam('status');

        $this->response->html($this->template->render('subtask/start', array(
            'subtask' => $subtask,
            'task' => $task,
            'status' => $status,
        )));
    }

    /**
     * Change status to the next status: Toto -> In Progress -> Done
     *
     * @access public
     */
    public function change()
    {
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);
        $fragment = $this->request->getStringParam('fragment');

        $status = $this->subtaskStatusModel->toggleStatus($subtask['id']);
        $subtask['status'] = $status;

        if ($fragment === 'table') {
            $html = $this->renderTable($task);
        } elseif ($fragment === 'rows') {
            $html = $this->renderRows($task);
        } else {
            $html = $this->helper->subtask->renderToggleStatus($task, $subtask);
        }

        $this->response->html($html);
    }

    /**
     * Toggle status
     *
     * @access public
     */
    public function toggle()
    {
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);
        $status = $this->request->getStringParam('status');

        $status = $this->subtaskStatusModel->toggle($subtask['id'], $status);
        $subtask['status'] = $status;

        $this->response->redirect($this->helper->url->to('TaskViewController', 'show', array('project_id' => $task['project_id'], 'task_id' => $task['id']), 'subtasks'), true);
    }

    /**
     * Start/stop timer for subtasks
     *
     * @access public
     */
    public function timer()
    {
        $task = $this->getTask();
        $subtask = $this->getSubtask($task);
        $timer = $this->request->getStringParam('timer');

        if ($timer === 'start') {
            $this->subtaskTimeTrackingModel->logStartTime($subtask['id'], $this->userSession->getId());
        } elseif ($timer === 'stop') {
            $this->subtaskTimeTrackingModel->logEndTime($subtask['id'], $this->userSession->getId());
            $this->subtaskTimeTrackingModel->updateTaskTimeTracking($task['id']);
        }

        $this->response->html($this->template->render('subtask/timer', array(
            'task'    => $task,
            'subtask' => $this->subtaskModel->getByIdWithDetails($subtask['id']),
        )));
    }

    /**
     * Render table
     *
     * @access protected
     * @param  array  $task
     * @return string
     */
    protected function renderTable(array $task)
    {
        return $this->template->render('subtask/table', array(
            'task'     => $task,
            'subtasks' => $this->subtaskModel->getAll($task['id']),
            'editable' => $this->helper->user->hasProjectAccess('SubtaskController', 'edit', $task['project_id']),
        ));
    }

    /**
     * Render task list rows
     *
     * @access protected
     * @param  array  $task
     * @return string
     */
    protected function renderRows(array $task)
    {
        $userId = $this->request->getIntegerParam('user_id');

        if ($userId > 0) {
            $task['subtasks'] = $this->subtaskModel->getAllByTaskIdsAndAssignee(array($task['id']), $userId);
        } else {
            $task['subtasks'] = $this->subtaskModel->getAll($task['id']);
        }

        return $this->template->render('task_list/task_subtasks', array(
            'task'    => $task,
            'user_id' => $userId,
        ));
    }
}
