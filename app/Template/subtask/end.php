<div class="page-header">
    <h2><?= $this->subtask->getSubtaskActionStatusChange($status) ?></h2>
</div>

<?php if (isset($values['subtasks_added']) && $values['subtasks_added'] > 0): ?>
    <p class="alert alert-success">
    <?php if ($values['subtasks_added'] == 1): ?>
        <?= t('Subtask added successfully.') ?>
    <?php else: ?>
        <?= t('%d subtasks added successfully.', $values['subtasks_added']) ?>
    <?php endif ?>
    </p>
<?php endif ?>

<form method="post" action="<?= $this->url->href('SubtaskStatusController', 'toggle', array('status' => $status, 'task_id' => $task['id'], 'subtask_id' => $subtask_id)) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->label('Considerações:', 'consideracoes') ?>

    <?= $this->form->textEditor('comment', $values, $errors, array('required' => true)) ?>

    <?= $this->modal->submitButtons() ?>
</form>