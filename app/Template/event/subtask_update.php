<p class="activity-title">
    <?= e('%s updated the subtask', $this->text->e($author)) ?>
    <small class="activity-date"><?= $this->dt->datetime($date_creation) ?></small>
</p>
<div class="activity-description">

    <ul>
        <?php if ($changes['title']): ?>
            <li>
                <?= t('Title: %s', $changes['title']) ?>
            </li>
        <?php endif ?>
        <?php if ($changes['time_estimated']): ?>
            <li>
                <?= t('Time estimated: %sh', $changes['time_estimated']) ?>
            </li>
        <?php endif ?>
        <?php if ($changes['time_spent']): ?>
            <li>
                <?= t('Time spent: %sh', $changes['time_spent']) ?>
            </li>
        <?php endif ?>
        <?php if ($changes['user_id']): ?>
            <li>
                <?= t('Assigned to: %s', $subtask['username']) ?>
            </li>
        <?php endif ?>
        <?php if ($changes['description']): ?>
            <li>
                <?= t('Analysis:') ?>
                <article class="markdown subtask-summary-markdown">
                    <?= $this->text->markdown($changes['description']) ?>
                </article>                
            </li>
        <?php endif ?>        
    </ul>
</div>
