<div class="sidebar sidebar-icons">
    <div class="sidebar-title">
        <h2><?= t('Task #%d', $task['id']) ?></h2>
    </div>
    <ul>
        <li <?= $this->app->checkMenuSelection('TaskViewController', 'show') ?>>
            <?= $this->url->icon('newspaper-o', t('Summary'), 'TaskViewController', 'show', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('ActivityController', 'task') ?>>
            <?= $this->url->icon('dashboard', t('Activity stream'), 'ActivityController', 'task', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('TaskViewController', 'transitions') ?>>
            <?= $this->url->icon('arrows-h', t('Transitions'), 'TaskViewController', 'transitions', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('TaskViewController', 'analytics') ?>>
            <?= $this->url->icon('bar-chart', t('Analytics'), 'TaskViewController', 'analytics', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
        </li>
        <?php if ($task['time_estimated'] > 0 || $task['time_spent'] > 0): ?>
        <li <?= $this->app->checkMenuSelection('TaskViewController', 'timetracking') ?>>
            <?= $this->url->icon('clock-o', t('Time tracking'), 'TaskViewController', 'timetracking', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
        </li>
        <?php endif ?>

        <?= $this->hook->render('template:task:sidebar:information', array('task' => $task)) ?>
    </ul>

    <?php if ($this->user->hasProjectAccess('TaskModificationController', 'edit', $task['project_id'])): ?>
    <div class="sidebar-title">
        <h2><?= t('Manage') ?></h2>
    </div>
    <ul>
        <?php if ($this->user->hasProjectAccess('SubtaskController', 'create', $task['project_id'])): ?>
        <li>
            <?= $this->modal->medium('plus', t('Add a sub-task'), 'SubtaskController', 'create', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
        </li>
        <?php endif ?>
        <?php if ($this->projectRole->canUpdateTask($task)): ?>
        <li>
            <?= $this->modal->large('edit', t('Edit the task'), 'TaskModificationController', 'edit', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
        </li>
        <?php endif ?>
        <li>
            <?= $this->modal->small('clone', t('Move to another project'), 'TaskDuplicationController', 'move', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
        </li>
        <?php if ($this->projectRole->canRemoveTask($task)): ?>
            <li>
                <?= $this->modal->confirm('trash-o', t('Remove'), 'TaskSuppressionController', 'confirm', array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'redirect' => 'board')) ?>
            </li>
        <?php endif ?>
    </ul>
    <?php endif ?>
</div>
