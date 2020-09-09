<div class="dropdown">
    <a class="dropdown-menu dropdown-menu-link-icon"><div class="subtask-submenu"><i class="fa fa-caret-down"></i></div></a>
    <ul>
        <li>
            <?= $this->modal->confirm('edit', $this->subtask->getSubtaskActionStatusChange(1), 'SubtaskStatusController', 'begin', array('status' => '1', 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('edit', $this->subtask->getSubtaskActionStatusChange(2), 'SubtaskStatusController', 'end', array('status' => '2', 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('edit', $this->subtask->getSubtaskActionStatusChange(3), 'SubtaskStatusController', 'end', array('status' => '3', 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('edit', $this->subtask->getSubtaskActionStatusChange(4), 'SubtaskStatusController', 'begin', array('status' => '4', 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('edit', $this->subtask->getSubtaskActionStatusChange(5), 'SubtaskStatusController', 'end', array('status' => '5', 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('edit', $this->subtask->getSubtaskActionStatusChange(6), 'SubtaskStatusController', 'end', array('status' => '6', 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('edit', $this->subtask->getSubtaskActionStatusChange(7), 'SubtaskStatusController', 'end', array('status' => '7', 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])) ?>
        </li>
    </ul>
</div>