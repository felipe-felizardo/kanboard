<?php if (! empty($task['subtasks'])): ?>
<div class="task-list-subtasks">
    <?php foreach ($task['subtasks'] as $subtask): ?>
        <div class="table-list-details">
            <small> 
                <span class="subtask-title">
                    <?= $this->url->link(
                        $this->text->e($subtask['title']),
                        'SubtaskController',
                        'show',
                        array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'editable' => false, 'subtask_id' => $subtask['id'])) ?>
                </span>
            </small>
            <small>
                <?= $this->subtask->renderStatus($subtask) ?>
            </small>
                <?php if (! empty($subtask['username'])): ?>
                    <small>
                        <?= $this->text->e($subtask['name'] ?: $subtask['username']) ?>
                    </small> 
                <?php endif ?>  
            <small>
                <span class="subtask-time-tracking-cell">
                    <?= $this->render('subtask/timer', array(
                        'task'    => $task,
                        'subtask' => $subtask,
                    )) ?>
                </span>
            </small>
        </div>
    <?php endforeach ?>
</div>
<?php endif ?>
