<div class="task-board-icons">
  
    <div class="task-board-icons-row-wrapper">
        <div class="task-board-icons-row">
            <?php if ($task['is_milestone'] == 1): ?>
                <span title="<?= t('Milestone') ?>">
                    <i class="fa fa-flag flag-milestone"></i>
                </span>
            <?php endif ?>

            <?php if ($task['score']): ?>
                <span class="task-score" title="<?= t('Complexity') ?>">
                    <i class="fa fa-trophy"></i>
                    <?= $this->text->e($task['score']) ?>
                </span>
            <?php endif ?>

            <?php if (! empty($task['nb_subtasks'])): ?>
                <?= $this->app->tooltipLink(round($task['nb_completed_subtasks'] / $task['nb_subtasks'] * 100, 0).'%', $this->url->href('BoardTooltipController', 'subtasks', array('task_id' => $task['id'], 'project_id' => $task['project_id']))) ?>
            <?php endif ?>

            <?php if (! empty($task['time_estimated']) || ! empty($task['time_spent'])): ?>
                <span class="task-time-estimated" title="<?= t('Time spent and estimated') ?>">
                    <?= $this->text->e($task['time_spent']) ?>/<?= $this->text->e($task['time_estimated']) ?>h
                </span>
            <?php endif ?>

            <?php if (! empty($task['date_due'])): ?>
                <span class="task-date
                    <?php if (time() > $task['date_due']): ?>
                            task-date-overdue
                    <?php elseif (date('Y-m-d') == date('Y-m-d', $task['date_due'])): ?>
                            task-date-today
                    <?php endif ?>
                    ">
                    <?= $this->dt->datetime($task['date_due']) ?>
                </span>
            <?php endif ?>
        </div>
    </div>
</div>  

<?= $this->hook->render('template:board:task:footer', array('task' => $task)) ?>
