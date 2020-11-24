<section id="subtask-summary">
    <?= $this->hook->render('template:task:details:top', array('task' => $task)) ?>

    <div class="subtask-summary-container">
        <div class="subtask-summary-columns">
            <div class="subtask-summary-column">
                <ul class="no-bullet">
                    <li>
                        <strong class="subtask-summary-status">
                            <?= t('Status:') ?>
                            <?= $this->subtask->renderStatus($subtask) ?>
                            <?= $this->subtask->renderChooseStatus($task, $subtask) ?>
                        </strong>
                    </li>
                    <?= $this->hook->render('template:task:details:first-column', array('task' => $task)) ?>
                </ul>
            </div>
            <div class="subtask-summary-column">
                <ul class="no-bullet">
                    <li>
                        <strong><?= t('Time estimated:') ?></strong>
                        <span><?= t('%s hours', $subtask['time_estimated']) ?></span>
                    </li>       
                    <?= $this->hook->render('template:task:details:second-column', array('task' => $task)) ?>
                </ul>
            </div>
            <div class="subtask-summary-column">
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
            <div class="subtask-summary-column">
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
            <div class="subtask-summary-column">
                <ul class="no-bullet">
                    <li>
                        <strong><?= t('Analysis:') ?></strong>
                        <article class="markdown subtask-summary-markdown">
                            <?= $this->text->markdown($subtask['description'], isset($is_public) && $is_public) ?>
                        </article>
                    </li>
                    <?= $this->hook->render('template:task:details:third-column', array('task' => $task)) ?>
                </ul>
            </div>
            <?php if ($editable): ?>
                <div class="subtask-summary-button" >
                    <?= $this->modal->mediumButton('edit', t('Edit'), 'SubtaskController', 'edit', array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])) ?>
                </div>
            <?php endif ?>
        </div>
    </div>

    <?= $this->hook->render('template:task:details:bottom', array('task' => $task)) ?>
</section>
