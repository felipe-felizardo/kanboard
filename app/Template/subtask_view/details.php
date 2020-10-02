<section id="task-summary">
    <div class="task-summary-title color-<?= $task['color_id'] ?>"> 
       <h2><?= $this->text->e($subtask['title']) ?></h2>
    </div>

    <?= $this->hook->render('template:task:details:top', array('task' => $task)) ?>

    <div class="task-summary-container">
        <div class="task-summary-columns">
            <div class="task-summary-column">
                <ul class="no-bullet">
                    <li>
                        <strong><?= t('Status:') ?></strong>
                        <span><?= $this->subtask->getSubtaskTooltip($subtask) ?></span>
                    </li>
                    <?= $this->hook->render('template:task:details:first-column', array('task' => $task)) ?>
                </ul>
            </div>
            <div class="task-summary-column">
                <ul class="no-bullet">
                    <li>
                        <strong><?= t('Time estimated:') ?></strong>
                        <span><?= t('%s hours', $subtask['time_estimated']) ?></span>
                    </li>       
                    <?= $this->hook->render('template:task:details:second-column', array('task' => $task)) ?>
                </ul>
            </div>
            <div class="task-summary-column">
                <ul class="no-bullet">
                    <li>
                        <?php if ($task['time_spent']): ?>
                        <strong><?= t('Time spent:') ?></strong>
                        <span><?= t('%s hours', $subtask['time_spent']) ?></span>
                        <?php else: ?>
                        <strong><?= t('Time spent:') ?></strong>
                        <span><?= t('%s hours', 0) ?></span>
                        <?php endif ?>
                    </li>       
                    <?= $this->hook->render('template:task:details:third-column', array('task' => $task)) ?>
                </ul>
            </div>
            <div class="task-summary-column">
                <ul class="no-bullet">
                    <li>
                        <strong><?= t('Assignee:') ?></strong>
                        <span>
                        <?php if (! empty($subtask['username'])): ?>
                            <?= $this->text->e($subtask['name'] ?: $subtask['username']) ?>
                        <?php else: ?>
                            <?= t('not assigned') ?>
                        <?php endif ?>
                        </span>
                    </li>
                    <?= $this->hook->render('template:task:details:third-column', array('task' => $task)) ?>
                </ul>
            </div>
        </div>
    </div>

    <?= $this->hook->render('template:task:details:bottom', array('task' => $task)) ?>
</section>
