<div class="table-list-details table-list-details-with-icons">
    <?php if ($project['owner_id'] > 0): ?>
        <span><?= $this->text->e($project['owner_name'] ?: $project['owner_username']) ?></span>
    <?php endif ?>

    <span><?= t('Scope:') ?> <?= $project['scope_is_open'] ? t('OPEN') : t('CLOSED') ?> </span>
    
    <span><?= t('Status:') ?> <?= $project['is_active'] ? t('OPEN') : t('CLOSED') ?> </span>

    <?php if ($project['start_date']): ?>
        <span><?= t('Start date: ').$this->dt->date($project['start_date']) ?> </span>
    <?php endif ?>
    <?php if ($project['end_date']): ?>
        <span <?php if (date('Y-m-d') > $project['end_date']): ?> class="task-date-overdue" <?php endif ?>>
            <?= t('End date: ').$this->dt->date($project['end_date']) ?>
        </span>
    <?php endif ?>
</div>