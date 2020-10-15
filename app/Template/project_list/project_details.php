<div class="table-list-details table-list-details-with-icons">
    <ul>
        <?php if ($project['owner_id'] > 0): ?>
            <li><?= $this->text->e($project['owner_name'] ?: $project['owner_username']) ?></li>
        <?php endif ?>

        <?php if ($project['start_date']): ?>
            <li><?= t('Start date:').' '.$this->dt->date($project['start_date']) ?></li>
        <?php endif ?>

        <?php if ($project['end_date']): ?>
            <li><?= t('End date:').' '.$this->dt->date($project['end_date']) ?></li>
        <?php endif ?>

        <li><?= t('Scope:') ?> <?= $project['scope_is_open'] ? t('OPEN') : t('CLOSED') ?> </li>
        
        <li><?= t('Status:') ?> <?= $project['is_active'] ? t('OPEN') : t('CLOSED') ?> </li>
    </ul>
</div>