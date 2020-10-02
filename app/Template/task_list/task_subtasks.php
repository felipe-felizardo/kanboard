<?php if (! empty($task['subtasks'])): ?>
<div class="task-list-subtasks">
    <?php foreach ($task['subtasks'] as $subtask): ?>
        <div class="task-list-subtask">
            <span class="subtask-cell column-40">
                <span class="subtask-title">
                    <?= $this->url->link(
                        $this->text->e($subtask['title']),
                        'SubtaskController',
                        'show',                           
                        array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'editable' => false, 'subtask_id' => $subtask['id'])) ?>                       
                </span>
            </span>
            <span class="subtask-cell column-20">
                <?= $this->subtask->getSubtaskTooltip($subtask) ?> 
            </span>
            <span class="subtask-cell column-20 subtask-assignee">
                <?php if (! empty($subtask['username'])): ?>
                    <?= $this->text->e($subtask['name'] ?: $subtask['username']) ?>
                <?php endif ?>
            </span>
            <span class="subtask-cell subtask-time-tracking-cell">
                <?= $this->render('subtask/timer', array(
                    'task'    => $task,
                    'subtask' => $subtask,
                )) ?>
            </span>
        </div>
    <?php endforeach ?>
</div>
<?php endif ?>
