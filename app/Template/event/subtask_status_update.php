<p class="activity-title">
    <?= e('%s updated the subtask status', $this->text->e($author)) ?>
    <small class="activity-date"><?= $this->dt->datetime($date_creation) ?></small>
</p>
<div class="activity-description">

    <ul>
        <li>   
            <strong>
                <?= $this->subtask->renderStatus($subtask) ?>     
            </strong>    
        </li>        
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
            <article class="markdown subtask-summary-markdown markdown-activity">
                <?= $this->text->markdown($changes['comment']) ?>
            </article>
        </li>
        <?php endif ?>
    </ul>
</div>
