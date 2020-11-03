<?php

namespace Kanboard\Helper;

use Kanboard\Core\Base;
use Kanboard\Model\SubtaskModel;

/**
 * Subtask helpers
 *
 * @package helper
 * @author  Frederic Guillot
 */
class SubtaskHelper extends Base
{
    /**
     * Return if the current user has a subtask in progress
     *
     * @return bool
     */
    public function hasSubtaskInProgress()
    {
        return session_is_true('hasSubtaskInProgress');
    }

    /**
     * Render subtask title
     *
     * @param  array $subtask
     * @return string
     */
    public function renderTitle(array $subtask)
    {
        if ($subtask['status'] == 0) {
            $html = '<i class="fa fa-square-o fa-fw ' . ($this->hasSubtaskInProgress() ? 'js-modal-confirm' : '') . '"></i>';
        } elseif ($subtask['status'] == 1) {
            $html = '<i class="fa fa-gears fa-fw"></i>';
        } else {
            $html = '<i class="fa fa-check-square-o fa-fw"></i>';
        }

        return $html.$this->helper->text->e($subtask['title']);
    }

    /**
     * Get the link to toggle subtask status
     *
     * @access public
     * @param  array  $task
     * @param  array  $subtask
     * @param  string $fragment
     * @param  int    $userId
     * @return string
     */
    public function renderToggleStatus(array $task, array $subtask, $fragment = '', $userId = 0)
    {
        if (! $this->helper->user->hasProjectAccess('SubtaskStatusController', 'change', $task['project_id'])) {
            $html = $this->renderTitle($subtask);
        } else {
            $title = $this->renderTitle($subtask);
            $params = array(
                'project_id' => $task['project_id'],
                'task_id'    => $subtask['task_id'],
                'subtask_id' => $subtask['id'],
                'user_id'    => $userId,
                'fragment'   => $fragment,
            );

            if ($subtask['status'] == 0 && $this->hasSubtaskInProgress()) {
                $html = $this->helper->url->link($title, 'SubtaskRestrictionController', 'show', $params, false, 'js-modal-confirm', $this->getSubtaskTooltip($subtask));
            } else {
                $html = $this->helper->url->link($title, 'SubtaskStatusController', 'change', $params, false, 'js-subtask-toggle-status', $this->getSubtaskTooltip($subtask));
            }
        }

        return '<span class="subtask-title">'.$html.'</span>';
    }

    public function renderTimer(array $task, array $subtask)
    {
        $html = '<span class="subtask-timer-toggle">';

        if ($subtask['is_timer_started']) {
            $html .= ' (' . $this->helper->dt->age($subtask['timer_start_date']) .')';
        }

        $html .= '</span>';

        return $html;
    }

    public function renderBulkTitleField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="1"', 'required'), $attributes);

        $html = $this->helper->form->label(t('Title'), 'title');
        $html .= $this->helper->form->textarea('title', $values, $errors, $attributes);
        $html .= '<p class="form-help">'.t('Enter one subtask by line.').'</p>';

        return $html;
    }

    public function renderChooseStatus(array $task, array $subtask)
    {
        $html = '<div class="dropdown">';
        $html .= '<a class="dropdown-menu dropdown-menu-link-icon"><div class="subtask-submenu"><i class="fa fa-caret-down"></i></div></a>';
        $html .= '<ul>';

        switch ($subtask['status']) {
            case SubtaskModel::STATUS_TODO:
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_DEV_INPROGRESS), 'SubtaskStatusController', 'begin', array('status' => SubtaskModel::STATUS_DEV_INPROGRESS, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
            break;
            case SubtaskModel::STATUS_DEV_INPROGRESS:
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_DEV_STOPPED), 'SubtaskStatusController', 'end', array('status' => SubtaskModel::STATUS_DEV_STOPPED, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_DEV_DONE), 'SubtaskStatusController', 'end', array('status' => SubtaskModel::STATUS_DEV_DONE, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
            break;
            case SubtaskModel::STATUS_DEV_STOPPED:
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_DEV_INPROGRESS), 'SubtaskStatusController', 'begin', array('status' => SubtaskModel::STATUS_DEV_INPROGRESS, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
            break;
            case SubtaskModel::STATUS_DEV_DONE: 
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_TEST_INPROGRESS), 'SubtaskStatusController', 'begin', array('status' => SubtaskModel::STATUS_TEST_INPROGRESS, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
            break;
            case SubtaskModel::STATUS_TEST_INPROGRESS:
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_TEST_STOPPED), 'SubtaskStatusController', 'end', array('status' => SubtaskModel::STATUS_TEST_STOPPED, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_TEST_FAILED), 'SubtaskStatusController', 'end', array('status' => SubtaskModel::STATUS_TEST_FAILED, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_DONE), 'SubtaskStatusController', 'end', array('status' => SubtaskModel::STATUS_DONE, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
            break;
            case SubtaskModel::STATUS_TEST_STOPPED: 
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_TEST_INPROGRESS), 'SubtaskStatusController', 'begin', array('status' => SubtaskModel::STATUS_TEST_INPROGRESS, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
            break;
            case SubtaskModel::STATUS_TEST_FAILED;
            case SubtaskModel::STATUS_TEST_FAILED_REQUIREMENTS;
            case SubtaskModel::STATUS_TEST_FAILED_PARTLY_REQUIREMENTS;
            case SubtaskModel::STATUS_TEST_FAILED_ANOTHER_PROBLEM;
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_DEV_INPROGRESS), 'SubtaskStatusController', 'begin', array('status' => SubtaskModel::STATUS_DEV_INPROGRESS, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
            break;
            case SubtaskModel::STATUS_DONE;
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_DEV_INPROGRESS), 'SubtaskStatusController', 'begin', array('status' => SubtaskModel::STATUS_DEV_INPROGRESS, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
                $html .= '<li>';
                $html .= $this->helper->modal->confirm('edit', $this->getSubtaskActionStatusChange(SubtaskModel::STATUS_TEST_INPROGRESS), 'SubtaskStatusController', 'begin', array('status' => SubtaskModel::STATUS_TEST_INPROGRESS, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id']));
                $html .= '</li>';
            break;
            }

        $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }

    public function renderTitleField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="1"', 'required'), $attributes);

        $html = $this->helper->form->label(t('Title'), 'title');
        $html .= $this->helper->form->text('title', $values, $errors, $attributes, 'form-max-width');

        return $html;
    }

    public function renderFailMotiveSelect(int $status, array $fail_motive = array(), array $values, array $errors = array(), array $attributes = array())
    {
        if ($status == SubtaskModel::STATUS_TEST_FAILED)
        {
            $html = $this->helper->form->label(t('Motive'), 'motive');
            $html .= $this->helper->form->select('fail_motive', $fail_motive, $values, $errors, $attributes);
            return $html;
        }

        return null;
    }

    public function renderAssigneeField(array $users, array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="2"'), $attributes);

        $html = $this->helper->form->label(t('Assignee'), 'user_id');
        $html .= $this->helper->form->select('user_id', $users, $values, $errors, $attributes);
        $html .= '&nbsp;';
        $html .= '<small>';
        $html .= '<a href="#" class="assign-me" data-target-id="form-user_id" data-current-id="'.$this->userSession->getId().'" title="'.t('Assign to me').'">'.t('Me').'</a>';
        $html .= '</small>';

        return $html;
    }

    public function renderTimeEstimatedField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="3"'), $attributes);

        $html = $this->helper->form->label(t('Original estimate'), 'time_estimated');
        $html .= $this->helper->form->numeric('time_estimated', $values, $errors, $attributes);
        $html .= ' '.t('hours');

        return $html;
    }

    public function renderTimeSpentField(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="4"'), $attributes);

        $html = $this->helper->form->label(t('Time spent'), 'time_spent');
        $html .= $this->helper->form->numeric('time_spent', $values, $errors, $attributes);
        $html .= ' '.t('hours');

        return $html;
    }

    public function renderStatus(array $subtask)
    {
        switch ($subtask['status']) {
            case SubtaskModel::STATUS_TODO:
                $html = '<span class="subtask-status-todo">';
            break;
            case SubtaskModel::STATUS_DEV_INPROGRESS:
                $html = '<span class="subtask-status-dev-inprogress">';
            break;
            case SubtaskModel::STATUS_DEV_STOPPED:
                $html = '<span class="subtask-status-dev-stopped">';
            break;
            case SubtaskModel::STATUS_DEV_DONE: 
                $html = '<span class="subtask-status-dev-done">';
            break;
            case SubtaskModel::STATUS_TEST_INPROGRESS:
                $html = '<span class="subtask-status-test-inprogress">';
            break;
            case SubtaskModel::STATUS_TEST_STOPPED: 
                $html = '<span class="subtask-status-test-stopped">';
            break;
            case SubtaskModel::STATUS_TEST_FAILED;
                $html = '<span class="subtask-status-test-failed">';
            break;
            case SubtaskModel::STATUS_TEST_FAILED_REQUIREMENTS;
                $html = '<span class="subtask-status-test-failed">';
            break;
            case SubtaskModel::STATUS_TEST_FAILED_PARTLY_REQUIREMENTS;
                $html = '<span class="subtask-status-test-failed">';
            break;
            case SubtaskModel::STATUS_TEST_FAILED_ANOTHER_PROBLEM;
                $html = '<span class="subtask-status-test-failed">';
            break;
            case SubtaskModel::STATUS_DONE;
                $html = '<span class="subtask-status-done">';
            break;
        }

        $html .= $this->getSubtaskTooltip($subtask);
        $html .= '</span>';

        return $html;
    }

    public function getSubtaskTooltip(array $subtask)
    {
        switch ($subtask['status']) {
            case SubtaskModel::STATUS_TODO:
                return t('Subtask not started');
            case SubtaskModel::STATUS_DEV_INPROGRESS:
                return t('Under development');
            case SubtaskModel::STATUS_DEV_STOPPED:
                return t('Development stopped');
            case SubtaskModel::STATUS_DEV_DONE: 
                return t('Development done');
            case SubtaskModel::STATUS_TEST_INPROGRESS:
                return t('Test in progress');
            case SubtaskModel::STATUS_TEST_STOPPED: 
                return t('Test stopped');
            case SubtaskModel::STATUS_TEST_FAILED;
                return t('Test failed');
            case SubtaskModel::STATUS_TEST_FAILED_REQUIREMENTS;
                return t('Fail: Did not meet the requirements');
            case SubtaskModel::STATUS_TEST_FAILED_PARTLY_REQUIREMENTS;
                return t('Fail: Partly meet the requirements');
            case SubtaskModel::STATUS_TEST_FAILED_ANOTHER_PROBLEM;
                return t('Fail: Generated another problem');
            case SubtaskModel::STATUS_DONE;
                return t('Aproved');
        }

        return '';
    }

    public function getSubtaskActionStatusChange(int $newStatus)
    {
        switch ($newStatus) {
            case SubtaskModel::STATUS_TODO:
                return t('Set as todo');
            case SubtaskModel::STATUS_DEV_INPROGRESS:
                return t('Start development');
            case SubtaskModel::STATUS_DEV_STOPPED:
                return t('Stop development');
            case SubtaskModel::STATUS_DEV_DONE: 
                return t('Finish development');
            case SubtaskModel::STATUS_TEST_INPROGRESS:
                return t('Start test');
            case SubtaskModel::STATUS_TEST_STOPPED: 
                return t('Stop test');
            case SubtaskModel::STATUS_TEST_FAILED;
                return t('Fail test');
            case SubtaskModel::STATUS_TEST_FAILED_REQUIREMENTS;
                return t('Did not meet the requirements');
            case SubtaskModel::STATUS_TEST_FAILED_PARTLY_REQUIREMENTS;
                return t('Partly meet the requirements');
            case SubtaskModel::STATUS_TEST_FAILED_ANOTHER_PROBLEM;
                return t('Generated another problem');    
            case SubtaskModel::STATUS_DONE;
                return t('Aprove');
        }

        return '';
    }
}
