<p class="activity-title">
    <?= e('%s updated the subtask to the status %s', $this->text->e($author), strtoupper(t($subtask['status_name']))) ?>
    <small class="activity-date"><?= $this->dt->datetime($date_creation) ?></small>
</p>
<div class="activity-description">
    <p class="activity-task-title"><?= t('Task: %s', $this->text->e($task['title'])) ?></p>

    <ul>
        <?php if ($subtask['username']): ?>
        <li>   
            <?= t('Assigned to %s', $subtask['name'] ?: $subtask['username']) ?>         
        </li>
        <?php endif ?>
        <?php if (isset($changes['status_time_spent'])): ?>
        <li>
            <?= t('Time spent %sh', $changes['status_time_spent']) ?>
        </li>   
        <?php endif ?>             
        <?php if (isset($changes['comment'])): ?>
        <li>         
            <?= t('Comments:') ?>
            <p><strong><?= $this->text->e($changes['comment']) ?></strong></p>
        </li>
        <?php endif ?>
    </ul>
</div>
