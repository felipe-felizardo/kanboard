<div class="page-header">
    <h2><?= $this->subtask->getSubtaskActionStatusChange($status) ?></h2>
</div>

<div class="confirm">
    <div class="alert alert-info">
        <?= t('Do you really want to' ) ?> <?= strtolower($this->subtask->getSubtaskActionStatusChange($status)) ?> <?= t('of the subtask:' ) ?>
        <ul>
            <li>
                <strong><?= $this->text->e($subtask['title']) ?></strong>
            </li>
        </ul>
    </div>

    <?= $this->modal->confirmButtons(
        'SubtaskStatusController',
        'toggle', 
        array('status' => $status, 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'subtask_id' => $subtask['id'])
    ) ?>
</div>